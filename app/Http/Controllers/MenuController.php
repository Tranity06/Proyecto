<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Auth;

class MenuController extends Controller {

    public function crear(){
        // Comprobar autenticación
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

        return response()->json($menu, 200);
    }

    public function deleteMenu($idMenu) {
        $menu = Menu::find($idMenu);
        $menu->delete();

        return 204;
    }

    public function mostrar(){
        if (!Auth::guard('admin')->check()){
            return redirect('/admin'); 
        }
        $admin = Auth::guard('admin')->user()->name;
        
        $menus = Menu::all();
        return view('menus.mostrar', compact('admin', 'menus'));
    }

}

?>