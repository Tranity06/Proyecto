<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Sesion;
use App\Models\Sala;
use App\Models\Pelicula;

class SesionController extends Controller
{
    public function mostrarTodas(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        $admin = Auth::guard('admin')->user()->name;
        $fechas = Sesion::distinct()->orderBy('fecha')->get(['fecha']);
        $salas = Sala::get(['id']);
        $peliculas = Pelicula::get(['id', 'titulo']);

        $sesiones = [];
        foreach ( $fechas as $fecha ){
            foreach ($salas as $sala){
                $ses = Sesion::where([
                    ['fecha', '=', $fecha->fecha],
                    ['sala_id', '=', $sala->id]
                ])->get();
                foreach ($ses as $sion){
                    for ($pase=1 ; $pase<=4 ; $pase++){
                        $datosSes = $sion->where('pase',$pase)->first();
                        $sesiones[$fecha->fecha][$sala->id][$pase] = [
                            'id'=> $datosSes['id'],
                            'estado' => $datosSes['estado'],
                            'hora' => $datosSes['hora'],
                            'pelicula' => [
                                'id' => Pelicula::find($datosSes['pelicula_id'])['id'],
                                'titulo' => Pelicula::find($datosSes['pelicula_id'])['titulo']
                            ]
                        ];
                    }
                }
            }
        }
    $sesiones = json_encode($sesiones);
    return view('sesiones.mostrar', compact('admin', 'sesiones', 'peliculas'));
    }
}
