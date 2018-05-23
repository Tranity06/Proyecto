<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller {

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

    public function deleteMenu(Request $request, $idMenu) {
        $menu = Menu::find($idMenu);
        $menu->delete();

        return 204;
    }

}

?>