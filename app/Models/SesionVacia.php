<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesionVacia extends Model
{
    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'sesion_vacias';

    protected $fillable = [
        'pase', 'hora', 'sala_id'
    ];

    /**
     * Plantillas a las que pertenece
     */
    public function plantillas(){
        return $this->belongsToMany(PlantillaSesion::class);
    }

    /**
     * Sala de la sesion
     */
    public function sala(){
        return $this->belongsTo(Sala::class)->get();
    }
}
