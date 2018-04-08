<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha', 'usuario_id',
    ];

    /**
     * Devuelve las butacas reservadas que pertenecen a la factura.
     */
    public function butacas_reservadas(){
        return $this->belongsTo(Butaca_reservada::class);
    }

    /**
     * Devuelve todas las líneas de venta de la factura.
     */
    public function lineas_venta(){
        return $this->hasMany(LineaVenta::class);
    }
}
