<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Butaca extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fila', 'numero', 'estado', 'sala_id',
    ];

    /**
     * Devuelve el la sala a la que pertenece la butaca.
     */
    public function sala(){
        return $this->belongsTo(Sala::class);
    }

    /**
     * Devuelve todas las reservas de esta butaca en las diferentes sesiones.
     */
    public function reservas(){
        return $this->hasMany(Butaca_reservada::class);
    }
}
