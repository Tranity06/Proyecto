<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resena;
use App\Models\User;

class ResenaController extends Controller
{
    public function getAllFromUser($idUsuario){
        return User::find($idUsuario)->resenas();
    }

    public function create(Request $request, $idUsuario, $idPelicula){
        $resena = Resena::create([
            'valoracion' => $request['valoracion'], 
            'comentario' => $request['comentario'], 
            'usuario_id' => $idUsuario, 
            'pelicula_id' => $idPelicula
        ]);
        return $resena;
    }

    public function update(Request $request, $idResena){
        $resena = Resena::find($idResena);
        $resena['valoracion'] = $request['valoracion'];
        $resena['comentario'] = $request['comentario'];
        $resena->save();
        return $resena;
    }

    public function detele($idResena){
        $resena = Resena::find($idResena);
        $resena->delete();
        return 204;
    }
}
