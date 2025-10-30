<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade'); // hace referencia de la tabla productos a la tabla categorias
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion');
            $table->text('imagen');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock_maximo')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->string('unidad_medida')->default('unidad');
            $table->boolean('estado')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
