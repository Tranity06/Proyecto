<?php

namespace App\Http\Controllers;

use App\Events\ResenaEvent;
use Illuminate\Http\Request;
use App\Models\Resena;
use App\Models\User;
use JWTAuth;

class ResenaController extends Controller
{
    public function getAllFromUser($idUsuario){
        return User::find($idUsuario)->resenas();
    }

    public function crearResenia(Request $request, $idUsuario){
        $user = $this->getAuthenticatedUser();

        $user_resenas = Resena::where([
            ['user_id',$idUsuario],
            ['pelicula_id',$request['pelicula_id']]
        ])->get();
        if ( sizeof($user_resenas) > 0 ){
            return response('¡Ya has comentado sobre esta película! Puedes editar tu reseña desde tu perfil.', 403);
        }

        $resena = Resena::create([
            'valoracion' => $request['valoracion'], 
            'comentario' => $request['comentario'], 
            'user_id' => $idUsuario,
            'pelicula_id' => $request['pelicula_id']
        ]);

        $user = $resena->user();
        $resena['imagen_usuario'] = $user->avatar;
        $resena['nombre_usuario'] = $user->name;

        broadcast(new ResenaEvent($resena))->toOthers();

        return $resena;
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

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }
}
