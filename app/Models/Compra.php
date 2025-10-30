<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{

    protected $table = 'compras';
    protected $fillable = [
        'proveedor_id',
        'fecha',
        'total',
        'quantidade',
        'estado',
        'observaciones',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class);
    }
}
