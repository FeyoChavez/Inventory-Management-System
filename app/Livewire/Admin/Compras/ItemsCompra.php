<?php

namespace App\Livewire\Admin\Compras;

use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use App\Models\Lote;
use Exception;
use App\Models\DetalleCompra;
use Livewire\Component;

class ItemsCompra extends Component
{
    public Compra $compra; // variable que recibe la compra seleccionada

    public $productoId;
    public $cantidad = 1; // puedes jalar cualquier variable publica desde la vista
    public $precioCompra;

    public $precioUnitario;

    public $precioVenta;
    
    public $fechaVencimiento;
    
    public $codigoLote;
    public $productos;
    public $totalCompra; // ya la tenemos y esta inicializada en 0 en el componente padre


    public function mount(Compra $compra)  { // recibe la compra seleccionada que mandamos desde la vista
        $this->compra = $compra;
        $this->productos = Producto::all();
        $this->cargarDatos();
    }


    public function cargarDatos() {
        $this->compra->load('detalles.producto', 'detalles.lote'); // esto sale de las relaciones que hemos  
        $this->totalCompra = $this->compra->detalles->sum('subtotal'); // se va a ir sumando la suma del subtotal 
        // esta funcion suma el total de la compra cada vez que se agrega o elimina un item

        // Reiniciar los campos del formulario // aqui estaba el de productos tambien
        $this->reset(['productoId', 'cantidad', 'precioUnitario', 'precioCompra', 'precioVenta', 'fechaVencimiento', 'codigoLote']); // esto sale de la bd
        $this->cantidad = 1; // Que vuelva a iniciar la cantidad en 1
    }

    // Error comun de livewire, nos pide validar campos de forma manual
    protected $rules=[
        'productoId' => 'required ',
        'cantidad' => 'required',
        'precioCompra' => 'required',
        'precioVenta' => 'required',
        'fechaVencimiento' => 'required',
        'codigoLote' => 'required',
    ];

    public function updatedproductoId($value) { // updated es palabra reservada de livewire
        $producto = Producto::find($value);
        if($producto) {
            $this->precioCompra = $producto->precio_compra;
            $this->precioVenta = $producto->precio_venta;
        } else {
            $this->reset(['precioCompra', 'precioVenta']);
        }
     }


    public function agregarItems() {

       // dd('Entrando a la funcion'); Mensaje de consola forzoso, muy util para debuguear

        $this->validate();

        DB::beginTransaction();

        try {
            $producto = Producto::find($this->productoId);

            $loteId = null;

            //CREACION DEL NUEVO LOTE CON EL PRODUCTO QUE ESTAMOS INSERTANDO
            $lote = Lote::create([ // yo declaro estas var aqui y las mando a llamar con las variables publicas que declare al inicio
                'producto_id' => $producto->id,
                'proveedor_id' => $this->compra->proveedor->id,
                'codigo_lote' => $this->codigoLote,
                'fecha_entrada' => now()->toDateString(), // la fecha sale del propio sistema
                'fecha_vencimiento' => $this->fechaVencimiento,
                'cantidad_inicial' => 0,
                'cantidad_actual' => 0,
                'precio_compra' => $this->precioCompra,
                'precio_venta' => $this->precioVenta,
                'estado' => true,
            ]);

            $loteId = $lote->id; // a esta var se le pasa el nuevo lote que se ha creado


            // CREACION DEL DETALLE DE LA COMPRA (tabla detalles_compras)
            $this->compra->detalles()->create([
                'producto_id' => $producto->id,
                'lote_id' => $loteId,
                'precio_unitario' => $this->precioCompra,
                'cantidad' => $this->cantidad,
                'subtotal' => $this->cantidad * $this->precioCompra, // multiplicacion de cantidad por precio unitario
            ]);


            //RECALCULAR EL TOTAL DE LA COMPRA Y GUARDARLO (tabla compras)
            $this->compra->total = $this->compra->detalles->sum('subtotal');
            $this->compra->save(); // se actualiza  el total de la compra

            DB::commit(); // Si el codigo se ejecuta bien, se guarda la transaccion

            $this->cargarDatos(); // para que se recarguen los datos despues de agregar un item

             $this->dispatch(
            'mostrar-alerta',
            icono: 'success',
            mensaje: 'Producto agregado exitosamente'
        );
                       
            

        } catch(\Exception $e) {

             DB::rollBack(); // Si hay algun error, va a retroceder todas las transacciones que se han hecho
             dd('Error al a;adir el producto ' . $e->getMessage());

        }
    }


    public function render()
    {
        return view('livewire.admin.compras.items-compra');
    }

    public function prueba() {
        $this->dispatch(
            'mostrar-alerta',
            icono: 'success',
            mensaje: 'Desde el componente'
        );
        //$this->cantidad = $this->cantidad;
    }

    public function borrarItem($detalleId) {

        DB::beginTransaction();

        try {

            // BUSCA el item del producto
            $detalle = DetalleCompra::find($detalleId);

            // BORRAR el lote del detalle de producto eliminado
            $lote_id = $detalle->lote_id; // del detalle de la compra sacamos el lote_id
            $lote = Lote::find($lote_id); // buscamos el lote con ese id
            $lote->delete(); 

            // BUSCA y ELIMINA el item del producto
            $detalle->delete();


            // RECALCULAR EL TOTAL DE LA COMPRA Y GUARDARLO (tabla compras) se resta el subtotal
            $this->compra->total = $this->compra->detalles->sum('subtotal');
            $this->compra->save(); 

            DB::commit();  

            $this->cargarDatos();  

             $this->dispatch(
            'mostrar-alerta',
            icono: 'success',
            mensaje: 'Producto borrado exitosamente'
        );
                       
            

        } catch(\Exception $e) {

             DB::rollBack(); // Si hay algun error, va a retroceder todas las transacciones que se han hecho
             dd('Error al borrar el producto ' . $e->getMessage());

        }

    }
}
