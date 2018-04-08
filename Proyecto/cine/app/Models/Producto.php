<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'precio', 'stock', 'imagen', 'categoria_id',
    ];

    /**
     * Devuelve la categoría del producto.
     */
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Devuelve todas los ingredientes del producto
     */
    public function ingredientes(){
        return $this->belongsToMany(Ingrediente::class)->withTimestamps();
    }

    /**
     * Devuelve los menús en los que se incluye este producto
     */
    public function menus(){
        return $this->belongsToMany(Menu::class)->withTimestamps();
    }
}
