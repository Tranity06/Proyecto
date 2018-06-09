<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoIngrediente;
use App\Models\ProductoMenu;
//use App\Models\Categoria;
use Illuminate\Http\Request;
use Auth;
use Validator;

class ProductoController extends Controller {

    public function crear(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        return view('producto.crear', compact('admin'));
    }

    public function getAll() {
        return response()->json(Producto::all());
    }

    public function addProducto(Request $request) {
        //Validacion de los datos
    $credentials = $request->only('nombre', 'precio', 'stock', 'imagen', 'categoria_id');
        $rules = [
            'nombre' => 'required|string|min:1',
            'precio' => 'required|min:1',
            'stock' => 'required|int|min:1',
            'imagen' => 'required|string|min:1',
            'categoria_id' => 'required|min:1'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json('Debes rellenar todos los campos.', 403);
        }
        
        $producto = Producto::create([
            'nombre' => $request['nombre'],
            'precio' => $request['precio'],
            'stock' => $request['stock'],
            'imagen' => $request['imagen'],
            'categoria_id' => $request['categoria_id']
        ]);

        ProductoIngrediente::create([
            'producto_id' => $producto->id,
            'ingrediente_id' => $request['ingrediente_id']
        ]);

        MenuIngrediente::create([
            'producto_id' => $producto->id,
            'menu_id' => $request['menu_id']
        ]);

        return response()->json($producto, 201);
    }

    public function updateProducto(Request $request, $idProducto) {
        $producto = Producto::find($idProducto);

        $producto->nombre = $request['nombre'];
        $producto->precio = $request['precio'];
        $producto->stock = $request['stock'];
        $producto->imagen = $request['imagen'];
        $producto->categoria_id = $request['categoria_id'];

        $producto->save();

        return response()->json($producto, 200);
    }

    public function deleteProducto($idProducto) {
        $producto = Producto::find($idProducto);
        $producto->delete();

        return 204;
    }

    public function mostrar(){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        
        $productos = Producto::all();
        return view('productos.mostrar', compact('admin', 'productos'));
    }

}

?>