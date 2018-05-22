<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\Resena;
use App\Models\Sesion;
use App\Models\User;

class PeliculaController extends Controller
{
    const TAM_CARTEL = 'w342';

    public function crear(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion
        
        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }
        return view('pelicula.crear', compact('admin'));
    }

    public function crearPost(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion

        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }

        if ( $this->existe($request['idtmdb'])){
            $repetida = true;
            return view('pelicula.crear', compact('admin', 'repetida'));
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

    public function mostrar(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion

        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }

        $peliculas = Pelicula::all();
        return view('pelicula.mostrar', compact('admin', 'peliculas'));
    }

    public function borrar(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion

        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }

        $pelicula = Pelicula::find($request['id']);
        if( $pelicula == null ){
            return "no borrado";
        }
        $pelicula->delete();
        return "Borrado";
    }

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

    public function getAll(){
        $peliculas = Pelicula::orderBy('estreno', 'desc')->get();

        foreach ( $peliculas as $pelicula ){
            $pelicula['sesiones'] = $pelicula->sesiones();
        }

        return $peliculas;
    }

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

            $sesion['horas'] = [];
            foreach( $horas as $hora ){
                $ses['id'] = $hora['id'];
                $ses['hora'] = $hora['hora'];
                $ses['sala_id'] = $hora['sala_id'];
                array_push($sesion['horas'], $ses);
            }
            array_push($sesiones, $sesion);
        }
        $pelicula['sesiones'] = $sesiones;
        return $pelicula;
    }

    public function getResenas($idPelicula){
        $resenas = Resena::where('pelicula_id', $idPelicula)->get();
         foreach ($resenas as $resena ){
            $user = $resena->user();
            $resena['nombre_usuario'] = $user->name;
            $resena['imagen_usuario'] = $user->avatar;
        } 
        return $resenas;
    }

    public function getSesiones($fecha){
        return Sesion::where('fecha', $fecha)->get();
    }
}
