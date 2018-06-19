<?php

namespace App\Http\Controllers;

use App\Events\ProductoEvent;
use App\Models\Producto;
use App\Models\ProductoIngrediente;
use App\Models\Productoproducto;
use App\Models\Categoria;
//use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Validator;
//use Intervention\Image\Facades\Image;

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
       /* $validator = Validator::make($request->imagen, [
            'imagen' => 'required|image64:jpg,png'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        } else {
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->resize(300, 300)->save( public_path('/uploads/productos/' . $fileName));
        }*/
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
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        
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

        broadcast(new ProductoEvent($idProducto,$request['precio']))->toOthers();

        return response()->json($producto, 200);
    }

    public function deleteProducto($idProducto) {
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $producto = Producto::find($idProducto);

        if ( $producto == null ){
            return response()->json('El producto indicado no existe.', 400);
        }
        
        $producto->delete();
        return response()->json('Producto borrado.', 204);
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

    /*public function cambiarAvatar(Request $request){
        $validator = Validator::make($request->imagen, [
            'imagen' => 'required|image64:png'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        } else {
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->resize(300, 300)->save( public_path('/uploads/avatars/' . $fileName));

            $user = User::find($this->getUser()->id);
            $user->avatar = $fileName;
            $user->saveOrFail();

            return response()->json(['success'=>true,'avatar_name'=>$fileName],200);
        }
    }*/

}

?>