<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'valoracion', 'comentario', 'user_id', 'pelicula_id'
    ];

    /**
     * Devuelve la película a la que pertenece.
     */
    public function pelicula(){
        return $this->belongsTo(Pelicula::class)->get();
    }

    /**
     * Devuelve el usuario al que pertenece.
     */
    public function user(){
        return $this->belongsTo(User::class)->get();
    }
}
