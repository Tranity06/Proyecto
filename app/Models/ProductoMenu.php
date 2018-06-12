<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoMenu extends Model
{
    /**
     * Tabla a la que hace referencia (no sigue el convenio Laravel).
     */
    protected $table = 'menu_producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'producto_id', 'menu_id'
    ];

    /**
     * Devuelve el producto.
     */
    public function producto(){
        return $this->belongsTo(Producto::class)->get();
    }

    /**
     * Devuelve el menu.
     */
    public function menu(){
        return $this->belongsTo(Menu::class)->get();
    }
}
