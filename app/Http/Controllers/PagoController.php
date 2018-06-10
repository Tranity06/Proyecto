<?php

namespace App\Http\Controllers;

use App\Mail\PagoEmail;
use App\Models\User;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PagoController extends Controller {

    public function confirmarPago(Request $request){
        $user = User::find($this->getUser()->id);

        $datos_pago['nombre_pelicula'] = $request->nombre_pelicula;
        $datos_pago['dia'] = $request->dia;
        $datos_pago['nombre_tarjeta'] = $request->nombre_tarjeta;

        $email_pago = new PagoEmail($user,$datos_pago);
        Mail::to($user->email)->send($email_pago);

       // obtengo los datos.
       // si son correctos, envio el email
       // y si no devuelvo error


       return response()->json('Success',200);
    }

    public function getUser(){
        $user = JWTAuth::toUser(JWTAuth::getToken());

        if ( $user == null ) {
            return response()->json('Permiso denegado', 403);
        }

        return $user;
    }

}

?>
