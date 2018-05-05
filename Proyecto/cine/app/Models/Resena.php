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
        'valoracion', 'comentario', 'usuario_id', 'pelicula_id'
    ];

    /**
     * Devuelve la película a la que pertenece.
     */
    public function pelicula(){
        return $this->belongsTo(Pelicula::class);
    }

    /**
     * Devuelve el usuario al que pertenece.
     */
    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }
}
