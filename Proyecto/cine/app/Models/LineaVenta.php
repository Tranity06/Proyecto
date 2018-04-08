<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineaVenta extends Model
{
    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'lineas_ventas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad', 'producto_id', 'factura_id',
    ];

    /**
     * Devuelve el producto al que hace referencia.
     */
    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    /**
     * Devuelve la factura a la que pertenece.
     */
    public function butaca(){
        return $this->belongsTo(Factura::class);
    }
}
