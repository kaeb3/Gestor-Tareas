<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Http\Requests\GuardarProyectoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;

class ProyectoController extends Controller
{
    /**
     * Muestra una lista de todos los proyectos del usuario (propios y colaboraciones).
     */
    public function index()
    {
        $proyectos = Proyecto::with(['dueno', 'colaboradores']) 
                             ->where('user_id', Auth::id()) 
                             ->orWhereHas('colaboradores', function ($query) { 
                                 $query->where('user_id', Auth::id());
                             })
                             ->latest()
                             ->get();
                             
        return view('proyectos.index', compact('proyectos'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('proyectos.create');
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(GuardarProyectoRequest $request)
    {
        $proyecto = Auth::user()->proyectos()->create($request->validated()); 

        return redirect()->route('proyectos.index')
                         ->with('success', 'Proyecto "' . $proyecto->titulo . '" creado con éxito.');
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(Proyecto $proyecto)
    {
        // La autorización del Route Resource ha sido deshabilitada en web.php.
        $proyecto->load('tareas'); 

        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Proyecto $proyecto)
    {
        // $this->authorize('update', $proyecto); // Comentado temporalmente
        return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(GuardarProyectoRequest $request, Proyecto $proyecto)
    {
        // $this->authorize('update', $proyecto); // Comentado temporalmente

        $proyecto->update($request->validated());

        return redirect()->route('proyectos.show', $proyecto)
                         ->with('success', 'Proyecto actualizado con éxito.');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Proyecto $proyecto)
    {
        // $this->authorize('delete', $proyecto); // Comentado temporalmente

        $proyecto->delete(); 

        return redirect()->route('proyectos.index')
                         ->with('success', 'Proyecto eliminado (lógicamente) con éxito.');
    }
}