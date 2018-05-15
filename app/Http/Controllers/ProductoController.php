<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller {

    public function list() {
        $productos = Producto::all();
    }

    public function getAdd() {
        $categorias = Categoria::all();
    }

    public function postAdd(Request $request, $idCategoria) {
        $this->validate($request, [
            'nombre' => 'unique:producto'
        ]);

        $imagen = $request->get('image');
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
        Image::make($imageData)->resize(300, 300)->save( public_path('/uploads/avatars/' . $fileName));
        $user->avatar = $fileName;
        
        Producto::create([
            'nombre' => $request['nombre'],
            'precio' => $request['precio'],
            'descripcion' => $request['descripcion'],
            'stock' => $request['stock'],
            'imagen' => $imagen,
            'categoria_id' => $idCategoria
        ]);
    }

    public function getUpdate(Request $request) {
        $categorias = Categoria::all();
        $id = $request['id'];
        $producto = Producto::find($id);
    }

    public function postUpdate(Request $request, $idCategoria) {
        Producto::update([
            'nombre' => $request['nombre'],
            'precio' => $request['precio'],
            'descripcion' => $request['descripcion'],
            'stock' => $request['stock'],
            'categoria_id' => $idCategoria
        ]);
    }

    public function delete(Request $request) {
        $id = $request['id'];
        $producto = Producto::find($id);
        $producto::destroy($producto);
    }

}

?>