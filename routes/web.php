<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ArchivoController; 
use App\Http\Controllers\ColaboradorController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    // 🛑 CRUD PROYECTOS (Definido Manualmente para evitar conflictos 403 y 404) 🛑
    
    // Create & Store (Necesitan ir antes de 'show')
    Route::get('proyectos/create', [ProyectoController::class, 'create'])->name('proyectos.create');
    Route::post('proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
    
    Route::post('proyectos', [ProyectoController::class, 'store'])
        ->name('proyectos.store')
        ->withoutMiddleware('can');
        
    // Index
    Route::get('proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    
    // Show (Genérica - va después de 'create')
    Route::get('proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');

    // Edit, Update, Destroy (Necesitan el parámetro {proyecto})
    Route::get('proyectos/{proyecto}/edit', [ProyectoController::class, 'edit'])->name('proyectos.edit');
    Route::put('proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');
    Route::delete('proyectos/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');

    // Rutas anidadas y otras (sin cambios)
    Route::resource('proyectos.tareas', TareaController::class)->only(['create', 'store']); 
    
    Route::get('/archivos/{archivo}/descargar', [ArchivoController::class, 'download'])
        ->name('archivos.download');
    Route::post('/proyectos/{proyecto}/colaboradores', [ColaboradorController::class, 'store'])->name('colaboradores.store'); 
});

require __DIR__.'/auth.php';