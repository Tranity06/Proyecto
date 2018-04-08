<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'clave', 'tlf',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'clave',
    ];

    /**
     * Devuelve todas las reseñas del usuario
     */
    public function resenas(){
        return $this->hasMany(Resenas::class);
    }

    /**
     * Devuelve todas las facturas del usuario
     */
    public function facturas(){
        return $this->hasMany(Facturas::class);
    }
}
