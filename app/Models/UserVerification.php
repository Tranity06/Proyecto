<?php
/**
 * Created by PhpStorm.
 * User: Emanuel
 * Date: 17/5/18
 * Time: 20:35
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','token'
    ];
}