<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idtmdb', 'titulo', 'titulo_original', 'estreno', 'generos', 'director', 'actores', 'sinopsis', 'duracion', 'cartel', 'trailer', 'slider_image', 'popularidad'
    ];

    protected $casts = [
        'slider' => 'boolean',
    ];

    /**
     * Devuelve el género de la película.
     */
 /*   public function genero(){
        return $this->belongsTo(Genero::class);
    }*/

    /**
     * Devuelve la calificación de edad de la película.
     */
 /*   public function calificacion_edad(){
        return $this->belongsTo(CalificacionEdad::class);
    }*/

    /**
     * Devuelve todas las reseñas de la película.
     */
    public function resenas(){
        return $this->hasMany(Resena::class)->get();
    }

    /**
     * Devuelve todas las sesiones de la película.
     */
    public function sesiones(){
        return $this->hasMany(Sesion::class)->get();
    }
}
