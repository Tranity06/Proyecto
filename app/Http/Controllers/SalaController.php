<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Sala;
use Auth;
use App\Models\Butaca;
use App\Models\Sesion;

class SalaController extends Controller
{
    /**
     * Muestra la lista de salas registradas.
     * Si el administrador no está autenticado redirige al login.
     */
    public function motrarTodas(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $salas = Sala::orderBy('numero')->get();
        foreach ($salas as $sala ){
            $sala['sesiones'] = sizeof($sala->sesiones());
            $sala['aforo'] = sizeof($sala->butacas());
        }
        return view('sala.mostrar', compact('admin', 'salas'));
    }

    /**
     * Muestra los detalles de la sala indicada.
     * Si el administrador no está autenticado redirige al login.
     */
    public function motrarSala( $idSala ){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $sala = Sala::find($idSala);

        $sala['aforo'] = sizeof($sala->butacas());
        $sala['filas'] = $sala->butacas()->max('fila');
        $sala['butacas'] = $sala->butacas()->max('numero');

        $sesiones = $sala->sesiones();

        $butacas_bloqueadas = [];
        $butacas = $sala->butacas();
        foreach($butacas as $butaca){
            if ($butaca->estado == "1"){
                array_push($butacas_bloqueadas, $butaca);
            }
        }
        return view('sala.detalle', compact('admin', 'sala', 'butacas_bloqueadas', 'sesiones'));
    }

    /**
     * Muestra el formulario para registrar una nueva sala.
     * Al registrar la sala también se registran sus butacas.
     * Si el administrador no está autenticado redirige al login.
     */
    public function crear(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        return view('sala.crear', compact('admin'));
    }

    /**
     * Registra los datos de la nueva sala.
     * Si el administrador no está autenticado redirige al login sin guardar los datos.
     * No se pueden crear dos salas con el mismo número de sala.
     */
    public function crearPost(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        //Comprobar datos
        $credentials = $request->only('numero', 'filas', 'butacas');
        $rules = [
            'numero' => 'required|integer|min:1',
            'filas' => 'required|integer|min:1',
            'butacas' => 'required|integer|min:1'
        ];
        $validator = Validator::make($credentials, $rules);
        if ( $validator->fails()){
            return response()->json('Los datos introducidos no son correctos.', 403);
        }

        //Comprobar que no está registrada
        $existe = Sala::where('numero', $request->numero)->first();
        if ( $existe != null ){
            return response()->json('La sala ya existe.', 403);
        }

        //Crear sala
        $sala = Sala::create([
            'numero' => $request->numero,
        ]);

        //Crear butacas
        for ( $fila=1 ; $fila<=$request->filas ; $fila++ ){
            for ( $butaca=1 ; $butaca<=$request->butacas ; $butaca++ ){
                Butaca::create([
                    'fila' => $fila,
                    'numero' => $butaca,
                    'estado' => 0,
                    'sala_id' => $sala->id
                ]);
            }
        }

        return response()->json('Sala creada.', 201);
    }

    /**
     * Elimina la sala indicada.
     * Elimina las butacas de la sala.
     * Si el administrador no está autenticado redirige al login.
     */
    public function borrar(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        //Comprobar que la sala existe
        $sala = Sala::find($request->idSala);
        if ( $sala == null ){
            return response()->json('La sala indicada no existe.', 403);
        }
        /* $sala = Sala::where('numero', $request->idSala)->get()->first();
        if ( $sala == null ){
            return response()->json('La sala indicada no existe.', 403);
        } */

        //Comprobar que la sala no tiene sesiones programadas
        $sesiones = $sala->sesiones();
        $hoy = strtotime(date('Y-m-d', time()));
        foreach ( $sesiones as $sesion ){
            $fecha = strtotime($sesion->fecha);
            if ( $fecha >= $hoy ){
                return response()->json('La sala tiene sesiones programadas.', 403);
            }
        }

        //Borrar butacas de la sala
        $butacas = Butaca::where('sala_id','=', $sala->id)->get();
        foreach ($butacas as $butaca ){
            $butaca->delete();
        }
        
        //Borrar la sala
        $sala->delete();
        return response()->json('Sala borrada.', 204);
    }
}
