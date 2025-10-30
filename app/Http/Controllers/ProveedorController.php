<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedors = Proveedor::all();
        return view('admin.proveedores.index', compact('proveedors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:proveedors,email',
        ]);

       $proveedor = new Proveedor();
         $proveedor->empresa = $request->empresa;
         $proveedor->nombre = $request->nombre;
         $proveedor->direccion = $request->direccion;
         $proveedor->telefono = $request->telefono;
         $proveedor->email = $request->email;
         $proveedor->save();

        return redirect()->route('proveedores.index')
            ->with('mensaje', 'Proveedor creado exitosamente')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $validator =  Validator::make($request->all(), [ // Esto es para evitar que al actualizar un proveedor con el mismo email, no de error de unique
            'empresa' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:proveedors,email,'.$id,
        ]);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_id', $id);

        }

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->empresa = $request->empresa;
        $proveedor->nombre = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->save();

        return redirect()->route('proveedores.index')
            ->with('mensaje', 'Proveedor actualizado exitosamente')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')
            ->with('mensaje', 'Proveedor eliminado exitosamente')
            ->with('icono', 'success');
    }
}
