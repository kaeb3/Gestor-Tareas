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
       Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            
            // Foreign Key Constraints (20 pts)
            $table->foreignId('user_id')
                  ->constrained('users') // Hace referencia a la tabla 'users'
                  ->onDelete('cascade');
                  
            $table->timestamps();
            $table->softDeletes(); // Borrado Lógico (20 pts)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
