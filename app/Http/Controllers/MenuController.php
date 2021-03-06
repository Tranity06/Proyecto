<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Auth;
use App\Models\Producto;
use App\Models\ProductoMenu;

class MenuController extends Controller {

    public function crear(){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        return view('menus.crear', compact('admin'));
    }

    public function getAll() {
        return response()->json(Menu::all());
    }

    public function addMenu(Request $request) {
        $menu = Menu::create([
            'nombre' => $request['nombre'],
        ]);

        return response()->json($menu, 201);
    }

    public function updateMenu(Request $request, $idMenu) {
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $menu = Menu::find($idMenu);
        
        if ( $menu == null ){
            return response()->json('El menu indicado no existe.', 403);
        }
        
        $menu->nombre = $request['nombre'];
        $menu->save();

        return response()->json($menu, 200);
    }

    public function mostrar(){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        
        $menus = Menu::all();
        return view('menus.mostrar', compact('admin', 'menus'));
    }

    public function deleteMenu($idMenu){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $menu = menu::find($idMenu);

        if ( $menu == null ){
            return response()->json('El menu indicado no existe.', 400);
        }
        
        $menu->delete();
        return response()->json('Menu borrado.', 204);
    }

    public function mostrarMenu( $idMenu ){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $menu = Menu::find($idMenu);
        return view('menus.editar', compact('admin', 'menu'));
    }

    public function menuProductos($idMenu) {
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $menu = Menu::find($idMenu);
        $productos = Producto::all();

        return view('menus.productos', compact('admin', 'menu', 'productos'));
    }

    public function anadirProductos(Request $request, $idMenu) {
        $productos = $request->productos;
        $productos = explode(',', $productos);

        $menu = Menu::find($idMenu);
        $menu->productos()->attach($productos);

        return response()->json($menu, 200);
    }

    public function getProductosMenu($idMenu) {
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;

        $menu = Menu::find($idMenu);
        $productos = $menu->productos()->get();

        return view('menus.productosexistentes', compact('admin', 'menu', 'productos'));
    }

    public function borrarProductos(Request $request, $idMenu) {
        $productos = $request->productos;
        $productos = explode(',', $productos);

        $menu = Menu::find($idMenu);
        $menu->productos()->detach($productos);

        return response()->json($menu, 204);
    }

}

?>