<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion',
    ];

    /**
     * Devuelve los productos que contienen este ingrediente.
     */
    public function productos(){
        return $this->belongsToMany(Producto::class)->withTimestamps();
    }
}
