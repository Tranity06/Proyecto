<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sesion;
use App\Models\Butaca;

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
     * Devuelve todas las sesiones que hay en la sala.
     */
    public function sesiones(){
        return $this->hasMany(Sesion::class)->get();
    }

    /**
     * Devuelve todas las butacas que hay en la sala.
     */
    public function butacas(){
        return $this->hasMany(Butaca::class)->get();
    }
}
