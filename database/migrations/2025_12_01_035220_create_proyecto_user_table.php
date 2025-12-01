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
       // Tabla Pivote para relación Muchos a Muchos (30 pts)
        Schema::create('proyecto_user', function (Blueprint $table) {
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('proyecto_id')->constrained()->onDelete('cascade');
            
            $table->primary(['user_id', 'proyecto_id']);
            
            // $table->string('rol_en_proyecto')->default('colaborador'); // Para puntos extra

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_user');
    }
};
