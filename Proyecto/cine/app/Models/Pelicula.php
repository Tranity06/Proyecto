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
        'titulo', 'director', 'sinopsis', 'duracion', ' actores', 'cartel', 'genero_id', 'calificacion_edad_id',
    ];

    /**
     * Devuelve el género de la película.
     */
    public function genero(){
        return $this->belongsTo(Genero::class);
    }

    /**
     * Devuelve la calificación de edad de la película.
     */
    public function calificacion_edad(){
        return $this->belongsTo(Calificacion_edades::class);
    }

    /**
     * Devuelve todas las reseñas de la película.
     */
    public function resenas(){
        return $this->hasMany(Resena::class);
    }

    /**
     * Devuelve todas las sesiones de la película.
     */
    public function sesiones(){
        return $this->hasMany(Sesion::class);
    }
}
