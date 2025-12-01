<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Tarea;     // 👈 CORRECCIÓN: Modelo Tarea importado
use App\Models\Archivo;   // 👈 CORRECCIÓN: Modelo Archivo importado
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Útil para depuración

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Generalmente, este método no se usa para rutas anidadas,
        // pero puedes redirigir al dashboard o a una lista principal de tareas.
        return redirect()->route('dashboard'); 
    }

    /**
     * Show the form for creating a new resource.
     * Recibe el proyecto del cual se creará la tarea (Rutas anidadas).
     */
    public function create(Proyecto $proyecto)
    {
        // Muestra el formulario de creación, pasando el objeto Proyecto
        // para que la vista sepa a qué proyecto asignar la tarea.
        return view('tareas.create', compact('proyecto'));
    }

    /**
     * Store a newly created resource in storage.
     * Nota: Deberías usar una Request personalizada para la validación, como GuardarTareaRequest.
     */
    public function store(Request $request)
    {
        // 1. Validar los campos de la tarea (y los archivos)
        // Agregamos 'descripcion' que es nullable
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proyecto_id' => 'required|exists:proyectos,id',
            'archivos.*' => 'nullable|file|max:5000', // Máximo 5MB por archivo
        ]);

        // 2. Crear la Tarea
        $tarea = Tarea::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'proyecto_id' => $request->proyecto_id,
            'user_id' => auth()->id(), // Asignar la tarea al usuario actual
            'estado' => 'pendiente', // O el estado inicial que uses
        ]);

        // 3. Procesar la carga de archivos (Si se implementó el modelo Archivo y la relación)
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                if ($archivo) { // Comprobación adicional por si es null
                    // Almacena el archivo en el disco 'public' y genera un nombre único
                    $ruta = $archivo->store('archivos_tareas', 'public'); 
    
                    $tarea->archivos()->create([
                        'nombre_original' => $archivo->getClientOriginalName(),
                        'ruta' => $ruta,
                        // El 'tarea_id' se asigna automáticamente por la relación
                    ]);
                }
            }
        }

        // 4. Redirigir a la vista de detalle del proyecto
        return redirect()->route('proyectos.show', $request->proyecto_id)
                         ->with('success', 'Tarea "' . $tarea->titulo . '" creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        // Puedes implementar aquí la Policy para ver tareas
        // $this->authorize('view', $tarea);

        // Muestra la vista de detalle de la tarea
        return view('tareas.show', compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        //
    }
}