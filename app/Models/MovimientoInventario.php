<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimiento_inventarios';

    protected $fillable = [
        'producto_id',
        'lote_id',
        'sucursal_id',
        'tipo_movimiento',
        'cantidad',
        'fecha',
        'observaciones',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class); // un movimiento pertenece a un producto
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class); // un movimiento pertenece a un lote
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class); // un movimiento pertenece a una sucursal
    }
}
