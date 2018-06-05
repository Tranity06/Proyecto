<?php
/**
 * Created by PhpStorm.
 * User: Emanuel
 * Date: 5/6/18
 * Time: 21:32
 */

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class PerfilController extends Controller {

    public function cambiarEmail(Request $request){
        $user = User::find($this->getUser()->id);

        $user->email = $request->email;

        $user->saveOrFail();

        return response()->json('Success',200);
    }

    public function getUser(){
        $user = auth()->user();

        if ( $user == null ) {
            return response()->json('Permiso denegado', 403);
        }

        return $user;
    }

}