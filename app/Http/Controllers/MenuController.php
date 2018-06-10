<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Auth;

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
        $menu = Menu::find($idMenu);
        $menu->nombre = $request['nombre'];
        $menu->save();

        if ( $menu == null ){
            return response()->json('El menu indicado no existe.', 403);
        }

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

    public function deleteMenu(Request $request){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }

        $menu = menu::find($request->idMenu);

        if ( $menu == null ){
            return response()->json('El menu indicado no existe.', 403);
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

}

?>