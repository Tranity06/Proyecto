<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionEdad extends Model
{

    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'calificaciones_edades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'icono',
    ];

    /**
     * Devuelve todas las películas que tienen esta calificación por edad.
     */
    public function peliculas(){
        return $this->hasMany(pelicula::class)->get();
    }
}
