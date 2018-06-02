<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SesionVacia;

class SesionVaciaController extends Controller
{
    /**
     * Borra la sesión indicada.
     * Si el administrador no está autenticado redirige al loggin.
     */
    public function borrar(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $sesion = SesionVacia::find($request->idSesion);
        if ($sesion == null ){
            return response()->json('La sesión no existe.', 403); 
        }

        $sesion->delete();
        return response()->json('Borrado', 204);
    }

    /**
     * Crea una nueva sesión con los datos dados.
     * Si el administrador no está autenticado redirige al loggin.
     */
    public function crear(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        // Comprobar que no está registrada la sesión.
        $repe = SesionVacia::where([
            ['sala_id', '=', $request->idSala],
            ['pase', '=', $request->pase],
            ['hora', '=', $request->hora] 
        ])->get();
        if ( sizeof($repe) > 0 ){
            return response()->json('La sesión ya está registrada.', 403);
        }

        $sesion = SesionVacia::create([
            'sala_id' => $request->idSala,
            'pase' => $request->pase,
            'hora' => $request->hora
        ]);

        return response()->json($sesion, 201);
    }
}
