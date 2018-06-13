<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoIngrediente;
use App\Models\Productoproducto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Auth;
use Validator;

class ProductoController extends Controller {

    public function crear(){
        // Comprobar autenticación
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $categorias = Categoria::all();
        $admin = Auth::guard('admin')->user()->name;
        return view('productos.crear', compact('admin', 'categorias'));
    }

    public function getAll() {
        return response()->json(Producto::all());
    }

    public function addProducto(Request $request) {
        //Validacion de los datos
        $credentials = $request->only('nombre', 'precio', 'imagen', 'categoria_id');
        $rules = [
            'nombre' => 'required|string|min:1',
            'precio' => 'required|min:1',
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
            'imagen' => $request['imagen'],
            'categoria_id' => $request['categoria_id']
        ]);

        return response()->json($producto, 201);
    }

    public function updateProducto(Request $request, $idProducto) {
        $producto = Producto::find($idProducto);

        if ( $producto == null ){
            return response()->json('El producto indicado no existe.', 403);
        }

        $credentials = $request->only('nombre', 'precio', 'categoria_id');
        $rules = [
            'nombre' => 'required|string|min:1'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json('Debes rellenar todos los campos.', 403);
        }

        $producto->nombre = $request['nombre'];
        $producto->precio = $request['precio'];
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

    public function mostrarProducto( $idProducto ){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $categorias = Categoria::all();

        $producto = Producto::find($idProducto);
        return view('productos.editar', compact('admin', 'producto', 'categorias'));
    }

}

?>