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
        Schema::create('accesorios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('tipo_accesorio_id');  // Relación con tipos_accesorios
            $table->string('descripcion');
            $table->decimal('precio', 8,2);
            $table->Integer('stock');
            $table->string('imagen')->nullable(); // Campo para almacenar la ruta de la imagen
            $table->timestamps();
        
            $table->foreign('tipo_accesorio_id')->references('id')->on('tipo_accesorios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesorios');
    }
};
