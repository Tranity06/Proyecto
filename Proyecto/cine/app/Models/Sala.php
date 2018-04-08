<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero',
    ];

    /**
     * Devuelve todas las sesiones que se dan en esta sala.
     */
    public function sesiones(){
        return $this->hasMany(Sesion::class);
    }

    /**
     * Devuelve todas las butacas que hay en esta sala.
     */
    public function butacas(){
        return $this->hasMany(Butaca::class);
    }
}
