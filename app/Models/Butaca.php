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
}
