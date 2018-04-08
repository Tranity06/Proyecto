<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ButacaReservada extends Model
{
    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'butacas_reservadas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado', 'sesion_id', 'butaca_id', 'factura_id',
    ];

    /**
     * Devuelve la sesión de la película reservada.
     */
    public function sesion(){
        return $this->belongsTo(Sesion::class);
    }

    /**
     * Devuelve la butaca a la que hace referencia.
     */
    public function butaca(){
        return $this->belongsTo(Butaca::class);
    }

    /**
     * Devuelve la factura a la que pertenece la reserva.
     */
    public function factura(){
        return $this->belongsTo(Factura::class);
    }
}
