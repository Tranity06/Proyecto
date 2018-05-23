<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;

class SliderController extends Controller
{
    /**
     * API
     */
    public function get(){
        return Pelicula::select('slider_image', 'trailer', 'titulo', 'generos', 'estreno')->where('slider', true)->get();
    }

    /**
     * WEB
     */
    public function mostrar(Request $request){
        $admin = $request->session()->get('nombre'); //Obtener el nombre del usuario de los datos de la sesion

        // Si no hay ningún usuario logueado regirige al login
        if ($admin == null){
            return redirect('/admin');
        }

        $peliculas = Pelicula::all();
        return view('pelicula.slider', compact('admin', 'peliculas'));
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
        $pelicula['slider'] = 0;
        $pelicula->save();
        return "Borrado";
    }

    public function anadir(Request $request){
        $pelicula = Pelicula::find($request['anadir']);
        $pelicula['slider'] = 1;
        $pelicula->save();
        return redirect('/slider');
    }
}


