<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $table = 'productos'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre', 
        'descripcion',
        'imagen',
        'precio_compra',
        'precio_venta',
        'stock_maximo',
        'stock_minimo',
        'unidad_medida',
        'estado',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class); // belongsTo porque es la relacion a uno y solo pertenece a una categoria
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class); // un producto puede tener muchos lotes
    }
    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class); // un producto puede tener muchos movimientos de inventario
    }

    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class); // un producto puede tener muchos detalles de compra
    }
}
