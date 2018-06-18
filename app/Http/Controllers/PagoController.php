<?php

namespace App\Http\Controllers;

use App\Events\ButacaEvent;
use App\Mail\PagoEmail;
use App\Models\User;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PagoController extends Controller {

    public function confirmarPago(Request $request){

        /*
                    nombre_pelicula: this.titulo,
                    hora: this.horaSeleccionada,
                    sala_id: this.salanum,
                    butacas: store.getters.selectedSeats,
                    item_restaurante: store.getters.cartItems,
                    nombre_tarjeta: datosVisa.nombre,
                    numero_tarjeta: datosVisa.numero
        */
        $user = User::find($this->getUser()->id);

        $datos_pago['nombre_pelicula'] = $request->nombre_pelicula;
        $datos_pago['hora'] = $request->hora;
        $datos_pago['sala_id'] = $request->sala_id;
        $datos_pago['butacas'] = $request->butacas;
        $datos_pago['items_restaurante'] = $request->items_restaurante;
        $datos_pago['precio_total'] = $request->precio_total;
        $datos_pago['nombre_tarjeta'] = $request->nombre_tarjeta;
        $datos_pago['numero_tarjeta'] = $request->numero;

        $email_pago = new PagoEmail($user,$datos_pago);
        Mail::to($user->email)->send($email_pago);

        foreach ($request->butacas as $butaca){
            broadcast(new ButacaEvent($butaca,['estado'=>1]))->toOthers();
        }


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
