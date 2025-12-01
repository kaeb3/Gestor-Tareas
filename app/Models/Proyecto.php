<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User; // <-- ¡Añade esta línea!
use App\Models\Tarea; // Implementa Borrado Lógico (20 pts)

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['titulo', 'descripcion', 'user_id'];

    // Relación 1:m Inversa: El dueño del proyecto
    public function dueno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación 1:m: Un proyecto tiene muchas tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }

    // Relación m:n: Un proyecto tiene muchos colaboradores
    public function colaboradores()
    {
        // Define la tabla pivote 'proyecto_user'
        return $this->belongsToMany(User::class, 'proyecto_user');
    }
}