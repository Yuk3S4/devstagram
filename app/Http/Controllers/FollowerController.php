<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        // attach -> para relaciones con la misma tabla
        $user->followers()->attach( auth()->user()->id );

        return back();
    }

    public function destroy(User $user)
    {
        // attach -> para relaciones con la misma tabla
        $user->followers()->detach( auth()->user()->id );

        return back();
    }
}
