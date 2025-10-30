<?php

namespace App\Http\Controllers;

use App\Models\InventarioSucursalLote;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class InventarioSucursalLoteController extends Controller
{
    public function index()  {
      //  $inventario_sucursal_por_lotes = InventarioSucursalLote::with('sucursal')->get();

          $sucursales = Sucursal::withCount('inventarioSucursalLotes')->get();
          
          foreach($sucursales as $sucursal) {
            $sucursal->total_inventario = InventarioSucursalLote::where('sucursal_id', $sucursal->id)->sum('cantidad_en_sucursal');
            // crea un campo nuevo (total_inventario) y suma la cantidad...
          }


          return view ('admin.inventario.sucursales_por_lotes.index', compact('sucursales'));


     //   return response()->json($inventario_sucursal_por_lotes);

    }


    public function mostrar_inventario_por_sucursal($id) {
      $sucursal = Sucursal::findOrFail($id);
      $inventario_sucursal_por_lotes = InventarioSucursalLote::where('sucursal_id', $id)
      ->with('lote.producto', 'lote.proveedor')
      ->get();

      return view ('admin.inventario.sucursales_por_lotes.mostrar_inventario_por_sucursal', compact('sucursal', 'inventario_sucursal_por_lotes'));

      // return response()->json($inventario_sucursal_por_lotes);

    }
}
