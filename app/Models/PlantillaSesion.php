<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaSesion extends Model
{
    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'plantillas_sesiones';

    protected $fillable = [
        'nombre', 'descripcion'
    ];

    /**
     * Sesiones de la plantilla
     */
    public function sesiones(){
        return $this->belongsToMany(SesionVacia::class);
    }
}
