<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use App\Mail\NuevoColaborador;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
 

class ColaboradorController extends Controller
{
    public function store(Request $request, Proyecto $proyecto)
    {
        // Validar y obtener el usuario a añadir (ej. por su email)
        $request->validate(['email_colaborador' => 'required|email|exists:users,email']);
        $colaborador = User::where('email', $request->email_colaborador)->first();

        // Adjuntar el colaborador (crea registro en tabla pivote)
        $proyecto->colaboradores()->attach($colaborador->id);

        // Envío de correo electrónico personalizado (100 pts)
        Mail::to($colaborador->email)->send(new NuevoColaborador($proyecto));

        return back()->with('success', 'Colaborador añadido y notificado por correo.');
}
}
