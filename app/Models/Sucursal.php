<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    /** @use HasFactory<\Database\Factories\SucursalFactory> */
    use HasFactory;

    protected $table = 'sucursals';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'activa',
    ];

    public function inventarioSucursalLotes()
    {
        return $this->hasMany(InventarioSucursalLote::class); // una sucursal tiene muchos inventarios de lotes
    }

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class); // una sucursal tiene muchos movimientos de inventario
    }
}
