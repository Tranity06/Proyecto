<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
