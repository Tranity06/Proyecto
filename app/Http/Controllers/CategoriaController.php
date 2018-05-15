<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller {

    public function list() {
        $categorias = Categoria::all();
    }

    public function getAdd() {
        return view('categoria.add');
    }

    public function postAdd(Request $request) {
        Categoria::create([
            'nombre' => $request['nombre']
        ]);
    }

    public function getUpdate(Request $request) {
        $id = $request->input('id');
        $categoria = Categoria::find($id);
    }

    public function postUpdate(Request $request) {
        $id = $request->input('id');
        $categoria = Categoria::find($id);
        $categoria::update([
            'nombre' => $request['nombre']
        ]);
    }

    public function delete(Request $request) {
        $id = $request->input('id');
        $categoria = Categoria::find($id);
        $categoria::destroy($categoria);
    }

}

?>