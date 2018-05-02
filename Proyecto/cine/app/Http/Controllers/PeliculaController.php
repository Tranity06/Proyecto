<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;

class PeliculaController extends Controller
{
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
            'cartel' => $request['poster']
        ]);
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
}
