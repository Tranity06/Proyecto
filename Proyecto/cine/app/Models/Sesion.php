<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'sesiones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha', 'hora', 'estado', 'pelicula_id', 'sala_id',
    ];

    /**
     * Devuelve la película que se proyecta en la sesión.
     */
    public function pelicula(){
        return $this->belongsTo(Pelicula::class);
    }

    /**
     * Devuelve la sala en la que se da la sesión.
     */
    public function sala(){
        return $this->belongsTo(Sala::class);
    }
}
