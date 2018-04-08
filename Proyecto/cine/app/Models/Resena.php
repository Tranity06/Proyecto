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
        'fecha', 'valoracion', 'comentario', 'usuario_id', 'pelicula_id',
    ];

    /**
     * Devuelve el usuario al que pertenece la reseña.
     */
    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Devuelve la película a la que hace referencia la reseña.
     */
    public function pelicula(){
        return $this->belongsTo(Pelicula::class);
    }
}
