<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoIngrediente extends Model
{
    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'ingrediente_producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'producto_id', 'ingrediente_id',
    ];

    /**
     * Devuelve el producto.
     */
    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    /**
     * Devuelve el ingrediente.
     */
    public function ingrediente(){
        return $this->belongsTo(Ingrediente::class);
    }
}
