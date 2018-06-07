<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use Auth;

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
    public function mostrar(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $peliculas = Pelicula::all();
        return view('pelicula.slider', compact('admin', 'peliculas'));
    }

    public function borrar(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
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
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        
        $pelicula = Pelicula::find($request['anadir']);
        $pelicula['slider'] = 1;
        $pelicula->save();
        return redirect('/slider');
    }
}


