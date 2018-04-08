<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * Devuelve todas las películas que tienen esta calificación por edad.
     */
    public function peliculas(){
        return $this->hasMany(pelicula::class);
    }
}
