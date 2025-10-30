<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';

    protected $fillable = [
        'producto_id',
        'proveedor_id',
        'codigo_lote',
        'fecha_entrada',
        'fecha_vencimiento',
        'cantidad_inicial',
        'cantidad_actual',
        'precio_compra',
        'precio_venta',
        'estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class); // un lote pertenece a un producto
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class); // un lote pertenece a un proveedor
    }

    public function inventarioSucursalLotes()
    {
        return $this->hasMany(InventarioSucursalLote::class); // un lote tiene muchos inventarios en sucursales
    }

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class); // un lote puede tener muchos movimientos de inventario
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class); // un lote puede tener muchos detalles de compra
    }
}
