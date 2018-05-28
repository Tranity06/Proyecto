<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ButacaController extends Controller
{
    /**
     * Bloquea la butaca indicada.
     * Si el administrador no está autenticado redirige al login.
     * Recibe el id de la sala, la fila y las butacas.
     */
    public function bloquear( Request $request ){

    }

    /**
     * Desbloquea la butaca indicada.
     * Si el administrador no está autenticado redirige al login.
     * Recibe el id de la butaca.
     */
    public function desbloquear( Request $request ){

    }
}
