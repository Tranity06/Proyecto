<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Butaca extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fila','numero','estado','sala_id'
    ];

    /**
     * Devuelve la sala donde está la butaca.
     */
    public function sala(){
        return $this->belongsTo(Sala::class)->get();
    }
}
