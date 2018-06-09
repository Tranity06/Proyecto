<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
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
     * Devuelve los productos que contienen este menu.
     */
    public function productos(){
        return $this->belongsToMany(Producto::class)->get();
    }
}
