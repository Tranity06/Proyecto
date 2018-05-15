<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller {

    public function list() {
        $ingredientes = Ingrediente::all();
    }

    public function getAdd() {
    }

    public function postAdd(Request $request) {
        $this->validate($request, [
            'nombre' => 'unique:ingrediente'
        ]);
        
        Ingrediente::create([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion']
        ]);
    }

    public function getUpdate(Request $request) {
        $id = $request->input('id');
        $ingrediente = Ingrediente::find($id);
    }

    public function postUpdate(Request $request) {
        $id = $request->input('id');
        $ingrediente = Ingrediente::find($id);
        $Ingrediente::update([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion']
        ]);
    }

    public function delete(Request $request) {
        $id = $request->input('id');
        $ingrediente = Ingrediente::find($id);
        $Ingrediente::destroy($ingrediente);
    }

}

?>