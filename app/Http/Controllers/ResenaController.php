<?php

namespace App\Http\Controllers;

use App\Events\ResenaEvent;
use Illuminate\Http\Request;
use App\Models\Resena;
use JWTAuth;

class ResenaController extends Controller
{
    /**
     * Devuelve todas las reseñas del usuario logueado.
     */
    public function getAllFromUser(){
        $user = auth()->user();
        if ( $user == null ) {
            return response()->json('Permiso denegado', 403);
        }
        return response()->json($user->resenas(), 201); 
    }

    /**
     * Si el uusario está logueado registra la reseña.
     * El usuario no puede escribir dos reseñas sobre la misma pelicula.
     */
    public function crearResenia(Request $request){
        //$user = auth()->user();
        $user = JWTAuth::toUser(JWTAuth::getToken());

        $user_resenas = Resena::where([
            ['user_id',$user->id],
            ['pelicula_id',$request['pelicula_id']]
        ])->get();
        if ( sizeof($user_resenas) > 0 ){
            return response('¡Ya has comentado sobre esta película! Puedes editar tu reseña desde tu perfil.', 403);
        }

        $resena = Resena::create([
            'valoracion' => $request['valoracion'], 
            'comentario' => $request['comentario'], 
            'user_id' => $user->id,
            'pelicula_id' => $request['pelicula_id']
        ]);

        $resena['imagen_usuario'] = $user->avatar;
        $resena['nombre_usuario'] = $user->name;

        broadcast(new ResenaEvent($resena))->toOthers();

        return response()->json($resena, 201);
    }

    public function update(Request $request, $idResena){
        $resena = Resena::find($idResena);
        $resena['valoracion'] = $request['valoracion'];
        $resena['comentario'] = $request['comentario'];
        $resena->save();
        return $resena;
    }

    public function delete($idResena){
        $resena = Resena::find($idResena);
        $resena->delete();
        return 204;
    }
}
