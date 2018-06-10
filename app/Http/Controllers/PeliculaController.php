<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\Resena;
use App\Models\Sesion;
use App\Models\User;
use Auth;
use Validator;
use App\Models\ButacaReservada;
use App\Models\Butaca;

class PeliculaController extends Controller
{
    // Constante para el tamaño máximo del cartel de las películas
    const TAM_CARTEL = 'w342';

    /**
     * Si el administrador está logueado devuelve el formulario para crear una nueva pelñicula.
     * Si el administrador no está logueado redirige al login.
     */
    public function crear(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        return view('pelicula.crear', compact('admin'));
    }

    /**
     * Registra la película con los datos pasados por el administrador.
     * Si el administrador no está logueado redirige al login.
     * Todos los campos deben tener contenido.
     * No se puede registrar dos veces la misma película.
     */
    public function crearPost(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        //Comprobar que la pelicula no está ya registrada
        if ( $this->existe($request['idtmdb'])){
            $repetida = true;
            return view('pelicula.crear', compact('admin', 'repetida'));
        }

        //Comprobar validez de los datos
        $credentials = $request->only('idtmdb', 'titulo', 'titulo_original', 'estreno', 'generos', 'director', 'actores', 'sinopsis', 'duracion', 'poster', 'trailer', 'slider_image', 'popularidad');
        $rules = [
            'idtmdb' => 'required|integer|min:1|unique:peliculas',
            'titulo' => 'required|string|min:1',
            'titulo_original' => 'required|string|min:1',
            'estreno' => 'required|date',
            'generos' => 'required|string|min:1',
            'director' => 'required|string|min:1',
            'actores' => 'required|string|min:1',
            'sinopsis' => 'required|string|min:1',
            'duracion' => 'required|integer|min:1',
            'poster' => 'required|string|min:1',
            'trailer' => 'required|string|min:1',
            'slider_image' => 'required|string|min:1',
            'popularidad' => 'required|min:1'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json('Debes rellenar todos los campos.', 403);
        }

        $poster = str_replace('w500', self::TAM_CARTEL, $request['poster']);

        $pelicula = Pelicula::create([
            'idtmdb' => $request['idtmdb'],
            'titulo' => $request['titulo'],
            'titulo_original' => $request['titulo_original'],
            'estreno' => $request['estreno'],
            'generos' => $request['generos'],
            'director' => $request['director'],
            'actores' => $request['actores'],
            'sinopsis' => $request['sinopsis'],
            'duracion' => $request['duracion'],
            'cartel' => $poster,
            'trailer' => $request['trailer'],
            'slider_image' => $request['slider_image'],
            'popularidad' => $request['popularidad']
        ]);

        if (isset($request['slider'])){
            if ( sizeof(Pelicula::where('slider', true)->get()) >= 3 ){
                $noslider = 'noslider';
                return view('pelicula.crear', compact('admin','noslider'));
            }
            $pelicula['slider'] = 1;
            $pelicula->save();            
        }
        return view('pelicula.crear', compact('admin', 'pelicula'));
    }

    /**
     * Muestra la información de las películas registradas.
     * Si el administrador no está logueado redirige al login
     */
    public function mostrar(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        
        $peliculas = Pelicula::all();
        return view('pelicula.mostrar', compact('admin', 'peliculas'));
    }

    /**
     * Elimina la película.
     * Si el administrador no está logueado redirige al login.
     */
    public function borrar(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $pelicula = Pelicula::find($request['id']);
        if( $pelicula == null ){
            return response()->json('La película indicada no existe', 400);
        }
        $pelicula->delete();
        return response('Película borrada.', 204);
        //return response()->json('Película borrada.', 204);
    }

    /**
     * Comprueba si la película existe en la base de datos
     */
    private static function existe( $idtmdb ){
        $pelicula = Pelicula::where('idtmdb', $idtmdb)->first();
        if ( $pelicula == null ){
            return false;
        }
        return true;
    }
    
    /**
     * API
     */

    /**
     * Devuelve todas las películas registradas.
     * Devuelve todas las sesiones activas de las películas el día de la consulta.
     */
    public function getAll(){
        $peliculas = Pelicula::orderBy('estreno', 'desc')->get();
        $hoy = date('Y-n-d');

        $pelis = [];
        $peli = [];
        foreach ( $peliculas as $pelicula ){
            $peli['titulo'] = $pelicula->titulo;
            $peli['is_estreno'] = false;
            $peli['proximamente'] = false;
            $peli['cartel'] = $pelicula->cartel;
            $peli['trailer'] = $pelicula->trailer;
            if ( strtotime($pelicula->estreno) == strtotime($hoy) ){
                $peli['is_estreno'] = true;
            }
            else if ( strtotime($pelicula->estreno) > strtotime($hoy) ){
                $peli['proximamente'] = true;
            }
            array_push($pelis, $peli);
        }

        return response()->json($pelis, 200);
    }

    /**
     * Devuelve la información de la película indicada y
     * las sesiones agrupadas por fechas y ordenadas por hora.
     * Sólo las sesiones activas.
     */
    public function getOne($idPelicula){
        $pelicula = Pelicula::find($idPelicula);
        $fechas = Sesion::distinct()->where('pelicula_id',$idPelicula)->orderBy('fecha')->get(['fecha']);
        $sesiones = [];
        foreach ( $fechas as $fecha ){
            $sesion['fecha'] = $fecha['fecha'];
            $horas =  Sesion::where([
                ['pelicula_id', $idPelicula],
                ['estado', 1],
                ['fecha', $fecha['fecha']]
            ])->orderBy('hora')->get();

            if ( sizeof($horas) > 0){
                $sesion['horas'] = [];
                foreach( $horas as $hora ){
                    $butacas_reservadas = $hora->butacasReservadas()->get();
                    $butacas = [];
                    foreach ( $butacas_reservadas as $butaca_reservada ){
                        $butaca['id'] = $butaca_reservada->id;
                        $butaca['estado'] = $butaca_reservada->estado;
                        $butaca['fila'] = Butaca::find($butaca_reservada->butaca_id)->fila;
                        $butaca['numero'] = Butaca::find($butaca_reservada->butaca_id)->numero;
                        array_push($butacas, $butaca);
                    }
                    $ses['sesion_id'] = $hora['id'];
                    $ses['hora'] = $hora['hora'];
                    $ses['sala_id'] = $hora['sala_id'];
                    $ses['butacas'] = $butacas;
                    array_push($sesion['horas'], $ses);
                }
                    array_push($sesiones, $sesion);
            }
        }
        $pelicula['sesiones'] = $sesiones;
        return response()->json($pelicula, 200);
    }

    /**
     * Devuelve todas las reseñas de la película indicada
     */
    public function getResenas($idPelicula){
        $resenas = Resena::where('pelicula_id', $idPelicula)->get();
         foreach ($resenas as $resena ){
            $user = $resena->user();
            $resena['nombre_usuario'] = $user->name;
            $resena['imagen_usuario'] = $user->avatar;
        }
        return response()->json($resenas, 200);
    }

    /**
     * Devuelve las sesiones activas programadas para el día indicado.
     */
    public function getSesiones($fecha){
        $sesiones = Sesion::where([
            ['fecha', $fecha],
            ['estado', 1]
        ])->get();
        return response()->json($sesiones, 200);
    }
}
