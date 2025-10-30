<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioSucursalLote extends Model
{
    protected $table = 'inventario_sucursal_lotes';

    protected $fillable = [
        'lote_id',
        'sucursal_id',
        'cantidad_en_sucursal',
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class); // un inventario pertenece a un lote
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class); // un inventario pertenece a una sucursal
    }
}
