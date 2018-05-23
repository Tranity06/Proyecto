<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller {

    public function getAll() {
        return response()->json(Ingrediente::all());
    }

    public function addIngrediente(Request $request) {
        $ingrediente = Ingrediente::create([
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
        ]);

        return response()->json($ingrediente, 201);
    }

    public function updateIngrediente(Request $request, $idIngrediente) {
        $ingrediente = Ingrediente::find($idIngrediente);
        $ingrediente->nombre = $request['nombre'];
        $ingrediente->descripcion = $request['descripcion'];
        $ingrediente->save();

        return response()->json($ingrediente, 200);
    }

    public function deleteIngrediente($idIngrediente) {
        $ingrediente = Ingrediente::find($idIngrediente);
        $ingrediente->delete();

        return 204;
    }

}

?>