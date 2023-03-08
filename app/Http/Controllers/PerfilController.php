<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // Modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil']
        ]);

        if ($request->imagen) { // ? Si hay imágen
            // Obteniendo el archivo
            $imagen = $request->file('imagen');

            // Generar nombres únicos
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            // Intervenir la imágen con Intervetion Image para que sean imágenes cuadradas (1000x1000)
            $imagenServer = Image::make($imagen);
            $imagenServer->fit(1000, 1000);

            // Guardarla en el servidor (public/nombreImagen)
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServer->save($imagenPath);
        }

        // Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
