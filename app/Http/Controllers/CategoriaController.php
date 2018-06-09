<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

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
        return view('categoria.crear', compact('admin'));
    }

    //me comenta Lorena que crear categoria va en la parte de administrador y no va por api[Que es solamente para el front].
    public function crearCategoria(Request $request) {
        $categoria = Categoria::create([
            'nombre' => $request['nombre'],
        ]);

        //devuelvo un 201 que indica que se ha creado, realmente ningun estado hace falta que se devuelva
        //Laravel lo hace automaticamente, pero me gusta verlo claro.
        return response()->json($categoria, 201);
    }

    //va en la parte de administrador y no va por api[Que es solamente para el front].
    public function update(Request $request,$idCategoria) {
        $categoria = Categoria::find($idCategoria);
        $categoria->nombre = $request['nombre'];
        $categoria->save();

        return response()->json($categoria,200);
    }

    //va en la parte de administrador y no va por api[Que es solamente para el front].
    public function delete($idCategoria) {
        $categoria = Categoria::find($idCategoria);
        $categoria->delete();
        return 204;
    }

}

?>