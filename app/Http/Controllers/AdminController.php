<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Compra;
use App\Models\Lote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $total_sucursales = Sucursal::count();
        $total_categorias = Categoria::count();
        $total_productos = Producto::count();
        $total_proveedores = Proveedor::count();
        $total_compras = Compra::count();
        $total_lotes_vencidos = Lote::where('fecha_vencimiento', '<', Carbon::now())->count(); // para mostrar los lotes vencidos desde el dashboard

        return view('admin.index', compact('total_sucursales', 'total_categorias', 
        'total_productos', 'total_proveedores', 'total_compras', 'total_lotes_vencidos')); // Vista de admin dashboard en views
    }
}
