<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index(Request $request)
    {

        //variables globales
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');
        
        $lotes = Lote::with('producto', 'proveedor')->get(); // Esta variable la mandas a llamar en la view para mostrar los datos en el foreach


        if($fecha_desde && $fecha_hasta) {
            $lotes = Lote::with('producto', 'proveedor')
            ->whereBetween('fecha_vencimiento', [$fecha_desde, $fecha_hasta])
            ->get();
        }

        $lotes->each(function ($lote) {
            $fecha_vencimiento = Carbon::parse($lote->fecha_vencimiento);
            $hoy = Carbon::today();
            
            $lote->is_expired = Carbon::parse($lote->fecha_vencimiento)->isPast(); // esto es como un foreach para que recorra todos los lotes
            $lote->days_to_expire = $hoy->diffInDays($fecha_vencimiento, false);
        });

        //return response()->json($lotes);
        return view('admin.lotes.index', compact('lotes'));
    }
}
