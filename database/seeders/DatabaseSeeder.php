<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Sucursal::factory(10)->create(); // Crea 10 sucursales falsas, define cuantos ejemplos quieres
        Categoria::factory(30)->create(); // Crea 10 categorias falsas, define cuantos ejemplos quieres
        Producto::factory(25)->create(); // Crea 50 productos falsas, define cuantos ejemplos quieres
        Proveedor::factory(20)->create(); // Crea 50 proveedores falsas, define cuantos ejemplos quieres

        User::create([
            'name' => 'Feyo Chavez',
            'email' => 'admin@hotmail.com',
            'password' => bcrypt('adminadmin'), // Cambia la contraseña según tus necesidades
        ]);
        
    }
}
