<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {
        // Obteniendo el archivo
        $imagen = $request->file('file');

        // Generar nombres únicos
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // Intervenir la imágen con Intervetion Image para que sean imágenes cuadradas (1000x1000)
        $imagenServer = Image::make($imagen);
        $imagenServer->fit(1000, 1000);

        // Guardarla en el servidor (public/nombreImagen)
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServer->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
