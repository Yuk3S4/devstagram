<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // __invoke -> método que se manda llamar automáticamente, es como un constructor
    public function __invoke()
    {
        // Obtener a quienes seguimos
        // pluck() -> extraer solo los id´s de las personas que seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray();
        // Obtener los posts que esten dentro del arreglo ids
        // latest -> mostrar las nuevas publicaciones primero
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);

        return view('home', [
            'posts' => $posts
        ]);
    }
}
