<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'clave', 'tlf', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'clave','remember_token'
    ];

    /**
     * Devuelve todas las reseñas del usuario
     */
    public function resenas(){
        return $this->hasMany(Resenas::class);
    }

    /**
     * Devuelve todas las facturas del usuario
     */
    public function facturas(){
        return $this->hasMany(Facturas::class);
    }
}
