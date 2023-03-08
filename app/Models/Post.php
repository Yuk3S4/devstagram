<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    public function user()
    {
        // Relación belongsTo Un post tiene un usuario
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comentarios()
    {
        // Uno a muchos
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        // Posicionarse en la tabla de likes y ver si en el campo user_id ya esta el id mandado
        return $this->likes->contains('user_id', $user->id);
    }
}
