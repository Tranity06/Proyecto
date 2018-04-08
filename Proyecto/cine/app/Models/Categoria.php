<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * Devuelve los productos que pertenecen a esta categoría.
     */
    public function productos(){
        return $this->hasMany(Producto::class);
    }
}
