<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Sesion;
use App\Models\Sala;
use App\Models\Pelicula;
use App\Models\PlantillaSesion;
use App\Models\Butaca;
use App\Models\ButacaReservada;

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
    $plantillas = PlantillaSesion::get();
    $sesionesvacias = [];
    foreach($plantillas as $plantilla){
        foreach($salas as $sala){
            for ( $pase=1 ; $pase<5 ; $pase++ ){
                $sesionesvacias[$plantilla->id][$sala->id][$pase] = $plantilla->sesiones()->where([
                    ['sala_id','=', $sala->id],
                    ['pase','=', $pase]
                ])->get(['hora']);
            }
        }
    }
    $sesionesvacias = json_encode($sesionesvacias);
    return view('sesiones.mostrar', compact('admin', 'sesiones', 'peliculas', 'plantillas', 'sesionesvacias'));
    }

    public function crearPost(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        $admin = Auth::guard('admin')->user()->name;
        
        $sesiones_registradas = Sesion::where([
            ['fecha', '=', $request->sesiones[0]['fecha']]
        ]);

        foreach($sesiones_registradas->get() as $sesion_regis){
            $sesion_regis->butacasReservadas()->delete();
        };

        $sesiones_registradas->delete();

        foreach($request->sesiones as $sesion){
            $sala = Sala::where('numero', (int)$sesion['sala'])->first();

            $sesion_registrada = Sesion::create([
                'fecha' => $sesion['fecha'],
                'pase' => (int)$sesion['pase'],
                'hora' => $sesion['hora'],
                'estado' => (int)$sesion['estado'],
                'pelicula_id' => (int)$sesion['pelicula_id'],
                'sala_id' => $sala->id
            ]);

            $butacas_reservadas = Butaca::where('sala_id', $sala->id)->get();
            foreach($butacas_reservadas as $butaca_reservada){
                ButacaReservada::create([
                    'estado' => $butaca_reservada->estado,
                    'sesion_id' => $sesion_registrada->id,
                    'butaca_id' => $butaca_reservada->id,
                ]);
            }
        }
        return response()->json("Exito", 200);
    }
}