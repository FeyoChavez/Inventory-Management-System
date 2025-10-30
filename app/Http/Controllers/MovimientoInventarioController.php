<?php

namespace App\Http\Controllers;

use App\Models\MovimientoInventario;
use Illuminate\Http\Request;

class MovimientoInventarioController extends Controller
{
    public function index() {

        $movimientos = MovimientoInventario::all();

        return view('admin.inventario.movimientos.index', compact('movimientos'));
    }
}
