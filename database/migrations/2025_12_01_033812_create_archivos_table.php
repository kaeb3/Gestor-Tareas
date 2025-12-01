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
        Schema::create('archivos', function (Blueprint $table) {
    $table->id();
    // Foreign Key a Tarea
    $table->foreignId('tarea_id')->constrained()->onDelete('cascade');
    $table->string('nombre_original'); // Nombre que subió el usuario
    $table->string('ruta'); // La ruta interna y el nombre único guardado por Laravel
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
