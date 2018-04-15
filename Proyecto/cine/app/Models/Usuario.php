<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use \Illuminate\Notifications\Notifiable;

class Usuario extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password', 'tlf', 'avatar','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token'
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

    public function verified(){
        return $this->token === null;
    }

    public function sendVerificationEmail(){
        $this->notify(new VerifyEmail($this));
    }

}
