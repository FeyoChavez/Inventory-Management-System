<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\InventarioSucursalLote;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use App\Mail\CompraProveedorMail; // Clase que creamos para enviar correos
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::all();
        return view('admin.compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $sucursales = Sucursal::all();

        return view('admin.compras.create', compact('proveedores', 'productos', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedors,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $compra = new Compra();
        $compra->proveedor_id = $request->proveedor_id;
        $compra->fecha = $request->fecha;
        $compra->observaciones = $request->observaciones;
        $compra->total = 0; // Inicialmente el total es 0, se actualizará al agregar productos
        $compra->estado = 'pendiente'; // estado inicial de la compra

        $compra->save();

        return redirect()->route('compras.edit', $compra->id)
        ->with('mensaje', 'Compra creada exitosamente, ahora puede añadir productos.')
        ->with('icono', 'success');
    }

    public function edit($id)
    {
        $compra = Compra::findOrFail($id);
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        $sucursales = Sucursal::all();


        return view('admin.compras.edit', compact('compra', 'proveedores', 'productos', 'sucursales'));
    }


    public function enviarCorreo(Compra $compra){
        $compra->load('detalles.producto', 'proveedor');

        $compra->estado = 'Enviado al proveedor';
        $compra->save();


        $proveedorEmail = $compra->proveedor->email;

        Mail::to($proveedorEmail)->send(new CompraProveedorMail($compra));

        return redirect()->route('compras.edit', $compra->id)
        ->with('mensaje', 'Correo enviado exitosamente al proveedor.')
        ->with('icono', 'success');
    }



    public function finalizarCompra(Request $request, Compra $compra){ // recibimos la compra (Compra $compra)

        $compra->load('detalles.producto', 'proveedor');

        if($compra->detalles->isEmpty()) {
            return redirect()->back()
            ->with('mensaje', 'No se puede finalizar la compra sin productos.')
            ->with('icono', 'error');
        }

        $request->validate([
            'sucursal_id' => 'required',
        ]); 

        DB::beginTransaction();

        try { 

            foreach($compra->detalles as $detalle) {
                $lote = $detalle->lote;
                $producto = $detalle->producto;

                // ACTUALIZAR la cantidad del lote en la tabla lotes
                $lote->cantidad_actual = $lote->cantidad_actual + $detalle->cantidad;
                $lote->save();

                // ACTUALIZAR o CREAR el registro en inventario_sucursales_lote
                $inventarioLote = InventarioSucursalLote::firstOrCreate([
                    'lote_id' => $lote->id,
                    'sucursal_id' => $request->sucursal_id,
                    'cantidad_en_sucursal' => 0,
                ]);

                $inventarioLote->cantidad_en_sucursal = $inventarioLote->cantidad_en_sucursal + $detalle->cantidad;
                $inventarioLote->save();


                // REGISTRAR el movimiento en la tabla movimientos_inventario
                $movimientoInventario = MovimientoInventario::create([
                    'producto_id' => $producto->id,
                    'lote_id' => $lote->id,
                    'sucursal_id' => $request->sucursal_id,
                    'tipo_movimiento' => 'Entrada',
                    'cantidad' => $detalle->cantidad,
                    'fecha' => now(),
                    //la observacion no se pone necesariamente debido a que es un campo nulo
                ]);

            }

            // ACTUALIZAR el estado de la compra 
            $compra->estado = 'Recibido';
            $compra->save();

            DB::commit(); // Si el codigo se ejecuta bien, se guarda la transaccion

            return redirect()->route('compras.index')
                ->with('mensaje', 'La compra se finalizó correctamente.')
                ->with('icono', 'success');

        } catch(\Exception $e) {

             DB::rollBack(); // Si hay algun error, va a retroceder todas las transacciones que se han hecho
             dd('Error al finalizar la compra ' . $e->getMessage());

        }
    }


    public function show($id) {

        $compra = Compra::findOrFail($id);
        $compra->load('detalles.producto', 'proveedor');

        $movimientoEntrada = MovimientoInventario::whereHas('lote', function($query) use ($compra) {
            $query->whereIn('id', $compra->detalles->pluck('lote_id'));
        })->where('tipo_movimiento', 'Entrada')->first();

        $sucursal_destino = null;
        if($movimientoEntrada) {
            $sucursal_destino = Sucursal::find($movimientoEntrada->sucursal_id);
        }
        
        return view('admin.compras.show', compact('compra', 'sucursal_destino'));
    }


    public function destroy($id) {

        $compra = Compra::with('detalles')->findOrFail($id);
       // return response()->json($compra);

        DB::beginTransaction();
        try { 

            foreach($compra->detalles as $detalle){
                $lote = $detalle->lote;

                $lote->delete();

                $detalle->delete();
            }

            $compra->delete();

            DB::commit(); 

            return redirect()->route('compras.index')
                ->with('mensaje', 'La compra se eliminó exitosamente.')
                ->with('icono', 'success');

        } catch(\Exception $e) {

             DB::rollBack(); // Si hay algun error, va a retroceder todas las transacciones que se han hecho
             dd('Error al eliminar la compra ' . $e->getMessage());
        }

    }

}
