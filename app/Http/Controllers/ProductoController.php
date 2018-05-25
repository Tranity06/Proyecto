<?php

namespace App\Http\Controllers;

use App\Models\Producto;
//use App\Models\Categoria;
use Illuminate\Http\Request;
use Validator;

class ProductoController extends Controller {

    public function getAll() {
        return response()->json(Producto::all());
    }

    public function addProducto(Request $request) {
        //Validacion de los datos
    $credentials = $request->only('nombre', 'precio', 'descripcion', 'stock', 'categoria_id');
        $rules = [
            'nombre' => 'required|string|min:1',
            'precio' => 'required|min:1',
            'descripcion' => 'required|string|min:1',
            'stock' => 'required|int|min:1',
            'categoria_id' => 'required|min:1'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json('Debes rellenar todos los campos.', 403);
        }

        
        
        Producto::create([
            'nombre' => $request['nombre'],
            'precio' => $request['precio'],
            'descripcion' => $request['descripcion'],
            'stock' => $request['stock'],
            'categoria_id' => $request['categoria_id']
        ]);

        return response()->json($producto, 201);
    }

    public function updateProducto(Request $request, $idProducto, $idCategoria) {
        $producto = Producto::find($idProducto);

        $producto->nombre = $request['nombre'];
        $producto->precio = $request['precio'];
        $producto->descripcion = $request['descripcion'];
        $producto->stock = $request['stock'];
        $producto->id_categoria = $idCategoria;

        $producto->save();

        return response()->json($producto, 200);
    }

    public function deleteProducto($idProducto) {
        $producto = Producto::find($idProducto);
        $producto->delete();

        return 204;
    }

}

?>