<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantillaSesion;
use Auth;
use App\Models\Sala;

class PlantillaSesionController extends Controller
{
    /**
     * Muestra la lista de las plantillas creadas.
     * Si el administrador no está autenticado redirige al login
     */
    public function mostrarTodas(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        $admin = Auth::guard('admin')->user()->name;
        $plantillas = PlantillaSesion::get();
        return view('plantillas.mostrar', compact('admin', 'plantillas'));
    }

    /**
     * Muestra el formulario para crear una nueva plantilla.
     * Si el administrador no está autenticado redirige al login.
     */
    public function crear(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $salas = Sala::all('numero');
        return view('plantillas.crear', compact('admin', 'salas'));
    }

    /**
     * Registra los datos de la nueva plantilla.
     * Si el administrador no está autenticado redirige al login.
     */
    public function crearPost(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $descripcion = ' ';
        if ( isset($request->descripcion) && strlen($request->descripcion) > 1 ){
            $descripcion = $request->descripcion;
        }
        $plantilla = PlantillaSesion::create([
            'nombre' => $request->nombre,
            'descripcion' => $descripcion
        ]);

        return response()->json($plantilla, 201);
    }

    /**
     * Modifica los datos de una plantilla.
     * Si el administrador no está autenticado redirige al login.
     */
    public function modificar(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        // Comprobar que la plantilla está registrada
        $plantilla = PlantillaSesion::find($request->idPlantilla);
        if ( $plantilla == null ){
            return response()->json('La plantilla no existe.', 403);
        }

        // Cambiar el nombre
        if ( isset($request->nombre) && strlen(trim($request->nombre)) > 0 ){
            $plantilla->nombre = $request->nombre;
        }

        // Cambiar descripción
        if ( isset($request->descripcion) && strlen(trim($request->descripcion)) > 0 ){
            $plantilla->descripcion = $request->descripcion;
        }
        $plantilla->save();

        return response()->json('Modificado', 204);
    }

    /**
     * Elimina de la base de datos la plantilla indicada.
     * Si el administrador no está autenticado redirige al login.
     */
    public function borrar(Request $request){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        // Comprobar que la plantilla está registrada
        $plantilla = PlantillaSesion::find($request->idPlantilla);
        if ( $plantilla == null ){
            return response()->json('La plantilla no existe.', 403);
        }

        $plantilla->delete();
        return response()->json('Borrado', 204);
    }
}
