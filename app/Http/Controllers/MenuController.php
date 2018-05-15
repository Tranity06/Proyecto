<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller {

    public function list() {
        $menus = menu::all();
    }

    public function postAdd(Request $request) {
        $this->validate($request, [
            'nombre' => 'unique:menu'
        ]);
        
        Menu::create([
            'nombre' => $request['nombre']
        ]);
    }

    public function getUpdate(Request $request) {
        $id = $request->input('id');
        $menu = Menu::find($id);
    }

    public function postUpdate(Request $request) {
        $id = $request->input('id');
        $menu = Menu::find($id);
        $menu::update([
            'nombre' => $request['nombre']
        ]);
    }

    public function delete(Request $request) {
        $id = $request->input('id');
        $menu = Menu::find($id);
        $menu::destroy($menu);
    }

}

?>