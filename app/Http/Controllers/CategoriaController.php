<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categorias = Categoria::all(); // Obtener todas las categorías de la base de datos, esto en lugar de un codigo sql, previene inyecciones sql (eloquent)
        //return response()->json($categorias);
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // este metodo es el que nos permite guardar
    {
        $request->validate([ // se restringen solo los campos que se no se permitan nulos
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save(); // guarda en la base de datos

        return redirect()->route('categorias.index')
        ->with('mensaje', 'Categoría creada exitosamente.')
        ->with('icono', 'success');


       //return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.show', compact('categoria'));
        //return response()->json($categoria);
        //echo $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) // Metodo para llevar a la vista que edita los cambios
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) // Metodo para actualizar los cambios
    {
        //return response()->json($request->all());

        $request->validate([ // se restringen solo los campos que se no se permitan nulos
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save(); // guarda en la base de datos

        return redirect()->route('categorias.index')
        ->with('mensaje', 'Categoría actualizada exitosamente.')
        ->with('icono', 'success'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categorias.index')
        ->with('mensaje', 'Categoría eliminada exitosamente.')
        ->with('icono', 'success');
    }
}
