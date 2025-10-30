<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request; //Librerias necesarias para eliminar las imagenes de la carpeta storage
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.create', compact('categorias')); // El compact nos permite jalar las categorias con el foreach
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // return response()->json($request->all());
       $request->validate([ // se restringen solo los campos que se no se permitan nulos
            'categoria_id' => 'required|exists:categorias,id', // validacion del lado del servidor
            'codigo' => 'required|unique:productos,codigo',
            'nombre' => 'required',  
            'descripcion' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'stock_maximo' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'unidad_medida' => 'required',
            'estado' => 'required|boolean',
        ]);

        $producto = new Producto();
        $producto->categoria_id = $request->categoria_id;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->imagen = $request->file('imagen')->store('imagenes/productos', 'public'); // Esta imagen viene desde el formulario de create
        $producto->precio_compra = $request->precio_compra; // las imagenes se guardan en storage/app/public/imagenes/productos, se crea automaticamente la carpeta si no existe
        $producto->precio_venta = $request->precio_venta;
        $producto->stock_maximo = $request->stock_maximo;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->unidad_medida = $request->unidad_medida;
        $producto->estado = $request->estado;
        $producto->save(); // guarda en la base de datos

        return redirect()->route('productos.index')
        ->with('mensaje', 'Producto creado exitosamente')
        ->with('icono', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.show', compact('producto'));   // checa entre producto y productos
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id )
    {
        $request->validate([ // se restringen solo los campos que se no se permitan nulos
            'categoria_id' => 'required|exists:categorias,id', // validacion del lado del servidor
            'codigo' => 'required|unique:productos,codigo,'.$id,
            'nombre' => 'required',  
            'descripcion' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // no nos obliga a actualizar por una nueva imagen
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'stock_maximo' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'unidad_medida' => 'required',
            'estado' => 'required|boolean',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->categoria_id = $request->categoria_id;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            Storage::disk('public')->delete($producto->imagen); // Elimina la imagen anterior
            $producto->imagen = $request->file('imagen')->store('imagenes/productos', 'public'); // Esta imagen viene desde el formulario de create
        }

        $producto->precio_compra = $request->precio_compra; // las imagenes se guardan en storage/app/public/imagenes/productos, se crea automaticamente la carpeta si no existe
        $producto->precio_venta = $request->precio_venta;
        $producto->stock_maximo = $request->stock_maximo;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->unidad_medida = $request->unidad_medida;
        $producto->estado = $request->estado;
        $producto->save(); // guarda en la base de datos

         return redirect()->route('productos.index')
        ->with('mensaje', 'Producto actualizado exitosamente')
        ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $producto = Producto::findOrFail($id);
        Storage::disk('public')->delete($producto->imagen); // Elimina la imagen asociada al producto
        $producto->delete();

        return redirect()->route('productos.index')
        ->with('mensaje', 'Producto eliminado exitosamente')
        ->with('icono', 'success');
    }
}
