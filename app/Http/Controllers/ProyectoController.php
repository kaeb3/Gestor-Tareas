<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /// Resolver problema de N + 1 consultas (Eager loading)
    $proyectos = Proyecto::with(['dueno', 'colaboradores']) 
                         // Proyectos creados por el usuario
                         ->where('user_id', Auth::id()) 
                         // Proyectos donde el usuario es colaborador
                         ->orWhereHas('colaboradores', function ($query) { 
                             $query->where('user_id', Auth::id());
                         })
                         ->latest()
                         ->get();
                         
    return view('proyectos.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proyectos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuardarProyectoRequest $request)
    {
        // El user_id se asigna automáticamente al proyecto del usuario autenticado
    $proyecto = Auth::user()->proyectos()->create($request->validated()); 

    return redirect()->route('proyectos.index')
                         ->with('success', 'Proyecto "' . $proyecto->titulo . '" creado con éxito.');

    return redirect()->route('proyectos.index')
                     ->with('success', 'Proyecto creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto)
    {
        // Restringir el acceso si no es dueño  
    $this->authorize('view', $proyecto);

    return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto)
    {
        // Restringir el acceso si no es dueño  
    $this->authorize('update', $proyecto);

    return view('proyectos.edit', compact('proyecto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuardarProyectoRequest $request, Proyecto $proyecto)
    {
        $this->authorize('update', $proyecto); 

        $proyecto->update($request->validated());

        return redirect()->route('proyectos.show', $proyecto)
                         ->with('success', 'Proyecto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto)
    {
        $this->authorize('delete', $proyecto); 

        $proyecto->delete(); // Esto realiza el Soft Delete (20 pts)

        return redirect()->route('proyectos.index')
                         ->with('success', 'Proyecto eliminado (lógicamente) con éxito.');
    }
}
