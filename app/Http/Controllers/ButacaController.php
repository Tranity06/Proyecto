<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Sala;
use App\Models\Butaca;

class ButacaController extends Controller
{
    /**
     * Bloquea la butaca indicada.
     * Si el administrador no está autenticado redirige al login.
     * Recibe el id de la sala, la fila y las butacas.
     */
    public function bloquear( Request $request ){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        //Recoger los datos
        $sala = Sala::find($request->idSala);
        $fila = $request->fila;
        $butacas = isset($request->butacas) ? $request->butacas : $this->filaEntera($sala);

        //Modificar las butacas
        $butacas_modificadas = [];
        foreach ($butacas as $butaca){
            if ($fila>$sala->butacas()->max('fila') || $butaca>$sala->butacas()->max('numero')){
                return response()->json('La fila o butaca no existe.', 403);
            }
            $but = Butaca::where([
                ['sala_id', '=', $request->idSala],
                ['fila', $fila],
                ['numero', $butaca]
            ])->get()->first();
            $but->update([
                'estado' => 1
            ]);
            array_push($butacas_modificadas, $but);
        }
        return response()->json($butacas_modificadas, 201);
    }

    /**
     * Desbloquea la butaca indicada.
     * Si el administrador no está autenticado redirige al login.
     * Recibe el id de la butaca.
     */
    public function desbloquear( Request $request ){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $butaca = Butaca::find($request->idButaca);
        if ( $butaca == null ){
            return response()->json('La fila o butaca no existe.', 403);
        }
        $butaca->update([
            'estado' => 0
        ]);
        return response()->json('Butaca actualizada.', 201);
    }

    private function filaEntera( $sala ){
        $butacas = [];
        for ( $i=1 ; $i<=$sala->butacas()->max('numero') ; $i++ ){
            array_push($butacas, $i);
        }
        return $butacas;
    }
}
