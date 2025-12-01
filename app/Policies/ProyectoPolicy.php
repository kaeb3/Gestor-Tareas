<?php

namespace App\Policies;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProyectoPolicy
{
    // Permite que un admin haga cualquier cosa, sin pasar por la validación
    public function before(User $user, string $ability): ?bool
    {
        if ($user->rol === 'admin') {
            return true;
        }
        return null;
    }

    public function create(User $user): bool
    {
        // 🛑 AÑADIDO: Permite a cualquier usuario autenticado crear un proyecto
        return true; 
    }

    // Quién puede ver el proyecto (dueño o colaborador)
    public function view(User $user, Proyecto $proyecto): bool
    {
        // El dueño O el usuario está entre los colaboradores
        return $user->id === $proyecto->user_id || $proyecto->colaboradores->contains($user);
    }

    // Quién puede actualizar
    public function update(User $user, Proyecto $proyecto): bool
    {
        // Solo el dueño
        return $user->id === $proyecto->user_id;
    }

    // Quién puede eliminar
    public function delete(User $user, Proyecto $proyecto): bool
    {
        // Solo el dueño
        return $user->id === $proyecto->user_id;
    }
}
