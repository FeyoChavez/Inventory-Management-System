<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    use HasFactory;

    protected $table = 'categorias'; // Nombre de la tabla en la base de datos
    protected $fillable = [
        'nombre', 
        'descripcion',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id'); // hasMany porque es la relacion a muchos, una categoria tiene muchos productos
    }
}
