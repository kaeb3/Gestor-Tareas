<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    // Pertenece a un proyecto (1:m inversa)
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function archivos()
{
    return $this->hasMany(Archivo::class);
}
}
