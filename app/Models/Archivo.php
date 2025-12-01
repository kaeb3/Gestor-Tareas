<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
   protected $fillable = ['tarea_id', 'nombre_original', 'ruta'];

public function tarea()
{
    return $this->belongsTo(Tarea::class);
}
}
