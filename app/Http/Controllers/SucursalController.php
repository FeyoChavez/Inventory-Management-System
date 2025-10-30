<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::all(); // Esta variable tu la defines, puede tener cualquier nombre asi sea en ingles o español
        return view('admin.sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        return view('admin.sucursales.create');
    }

    public function store(Request $request) // recibe toda la informacion del formulario y la guarda en $request
    {

        $request->validate([ // se restringen solo los campos que se no se permitan nulos
            'nombre' => 'required|string|max:255', // validacion del lado del servidor
            'direccion' => 'required',
            'telefono' => 'required',
            'activa' => 'required|boolean',
        ]);

        $sucursal = new Sucursal();
        $sucursal->nombre = $request->nombre;
        $sucursal->direccion = $request->direccion;
        $sucursal->telefono = $request->telefono;
        $sucursal->activa = $request->activa;
        $sucursal->save(); // guarda en la base de datos

        return redirect()->route('sucursales.index')
        ->with('mensaje', 'Sucursal creada exitosamente.')
        ->with('icono', 'success');

        //return response()->json($request->all());
    }

    public function show($id)
    {
        $sucursal = Sucursal::findOrFail($id); // Busca la sucursal por ID o falla si no la encuentra y manda un 404
        return view('admin.sucursales.show', compact('sucursal'));
    }

   
    public function edit($id)
    {
        $sucursal = Sucursal::findOrFail($id); // Busca la sucursal por ID o falla si no la encuentra y manda un 404
        return view('admin.sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, $id)
    {
            $request->validate([  
            'nombre' => 'required|string|max:255',  
            'direccion' => 'required',
            'telefono' => 'required',
            'activa' => 'required|boolean',
        ]);

        $sucursal = Sucursal::findOrFail($id);
        $sucursal->nombre = $request->nombre;
        $sucursal->direccion = $request->direccion;
        $sucursal->telefono = $request->telefono;
        $sucursal->activa = $request->activa;
        $sucursal->save(); // guarda en la base de datos

        return redirect()->route('sucursales.index')
        ->with('mensaje', 'Sucursal actualizada exitosamente.')
        ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();

        return redirect()->route('sucursales.index')
        ->with('mensaje', 'Sucursal eliminada exitosamente.')
        ->with('icono', 'success');
    }
}
