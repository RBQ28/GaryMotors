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
        Schema::create('motos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('marca');
            $table->string('categoria'); // Columna para la categoría
            $table->decimal('precio', 8, 2);
            $table->text('descripcion');
            $table->integer('anio');
            $table->integer('cilindrada');
            $table->string('imagen')->nullable(); // Columna para la imagen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motos');
    }
};
