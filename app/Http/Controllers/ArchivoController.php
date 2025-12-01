<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    public function download(Archivo $archivo)
    {
        // Opcional: Autorizar que solo usuarios del proyecto puedan descargar
        // $this->authorize('download', $archivo); 

        // Devuelve el archivo para su descarga
        // (Mostrar archivo) o (listado de archivos y descarga) (50 pts)
        return Storage::disk('public')->download($archivo->ruta, $archivo->nombre_original);
    }
}
