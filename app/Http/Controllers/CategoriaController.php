<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Auth;

class CategoriaController extends Controller {

    public function getAll() {
       return response()->json(Categoria::all(),200);
    }

    /**
     * Comprueba si el admin esta logueado
     * Si lo esta accede a la creacion de Categorias, sino vuelve a la pantalla de autenticacion
     */
    public function crear(){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        return view('categorias.crear', compact('admin'));
    }

    public function addCategoria(Request $request) {
        $categoria = Categoria::create([
            'nombre' => $request['nombre'],
        ]);

        return response()->json($categoria, 201);
    }

    public function updateCategoria(Request $request,$idCategoria) {
        $categoria = Categoria::find($idCategoria);
        $categoria->nombre = $request['nombre'];
        $categoria->save();

        return response()->json($categoria,200);
    }

    public function deleteCategoria($idCategoria) {
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $categoria = Categoria::find($idCategoria);

        if ( $categoria == null ){
            return response()->json('La categoría indicada no existe.', 400);
        }
        
        $categoria->delete();
        return response()->json('Categoria borrada.', 204);
    }

    public function mostrar(){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        
        $categorias = Categoria::all();
        return view('categorias.mostrar', compact('admin', 'categorias'));
    }

    public function mostrarCategoria( $idCategoria ){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $categoria = Categoria::find($idCategoria);
        return view('categorias.editar', compact('admin', 'categoria'));
    }

}

?>