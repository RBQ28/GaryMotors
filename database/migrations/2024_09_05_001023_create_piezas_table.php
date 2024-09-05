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
        Schema::create('piezas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('tipo_pieza_id');  // Relación con tipos_piezas
            $table->string('descripcion');
            $table->decimal('precio', 8,2);
            $table->unsignedBigInteger('stock');
            $table->string('imagen')->nullable(); // Campo para almacenar la ruta de la imagen
            $table->timestamps();
        
            $table->foreign('tipo_pieza_id')->references('id')->on('tipos_piezas')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piezas');
    }
};
