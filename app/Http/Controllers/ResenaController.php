<?php

namespace App\Http\Controllers;

use App\Events\ResenaEvent;
use Illuminate\Http\Request;
use App\Models\Resena;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class ResenaController extends Controller
{
    /**
     * Devuelve todas las reseñas del usuario logueado.
     */
    public function getAllFromUser(){
        try{
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (JWTException $e){
            return response()->json('Permiso denegado.', 403);
        }

        return response()->json($user->resenas(), 201); 
    }

    /**
     * Si el usuario está logueado registra la reseña.
     * El usuario no puede escribir dos reseñas sobre la misma pelicula.
     */
    public function crearResenia(Request $request){
        //Comprobar autenticación
        try{
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (JWTException $e){
            return response()->json('Debes autenticarte para poder comentar.', 403);
        }

        //Comprobar si el usuario ya ha comentado la película
        $user_resenas = Resena::where([
            ['user_id',$user->id],
            ['pelicula_id',$request->pelicula_id]
        ])->get();
        if ( sizeof($user_resenas) > 0 ){
            return response('¡Ya has comentado sobre esta película! Puedes editar tu reseña desde tu perfil.', 403);
        }

        //Comprobar que los datos son correctos
        $credentials = $request->only('valoracion', 'comentario', 'pelicula_id');
        $rules = [
            'valoracion' => 'required|min:1',
            'comentario' => 'required|string|min:1',
            'pelicula_id' => 'required|min:1'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json('Debes rellenar todos los campos.', 403);
        }

        //Crear la reseña
        $res = Resena::create([
            'valoracion' => $request['valoracion'], 
            'comentario' => $request['comentario'], 
            'user_id' => $user->id,
            'pelicula_id' => $request['pelicula_id']
        ]);
        $resenaJson = [
            'tipo' => 'write',
            'id' => $res->id,
            'comentario' => $res->comentario,
            'imagen_usuario' => $user->avatar,
            'nombre_usuario' => $user->name
        ];


        broadcast(new ResenaEvent($resenaJson))->toOthers();

        return response()->json($resenaJson, 201);
    }

    /**
     * Actualiza la reseña indicada con los datos pasados.
     * El usuario debe estar logueado para modificar una reseña.
     * La reseña debe pertenecer al usuario logueado. 
     */
    public function update(Request $request, $idResena){
        //Comprobar autenticación
        try{
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (JWTException $e){
            return response()->json('Debes autenticarte para poder comentar.', 403);
        }

        //Comprobar que la reseña existe
        $resena = Resena::find($idResena);
        if ( $resena == null ){
            return response()->json('La reseña solicitada no existe.', 400);
        }

        //Comprobar que la reseña pertenece al usuario logueado
        if ($user->id != $resena->user_id){
            return response()->json('Ops, no puedes modificar la reseña de otro usuario!', 403);
        }

        //Comprobar que los datos son correctos
        $credentials = $request->only('valoracion', 'comentario');
        $rules = [
            'valoracion' => 'required|min:1',
            'comentario' => 'required|string|min:1'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json('Debes rellenar todos los campos.', 403);
        }

        //Adjuntar información a la respuesta
        $resena['valoracion'] = $request['valoracion'];
        $resena['comentario'] = $request['comentario'];

        $resenaJson = [
            'tipo' => 'update',
            'id' => $resena->id,
            'comentario' => $resena->comentario,
            'imagen_usuario' => $user->avatar,
            'nombre_usuario' => $user->name
        ];

        broadcast(new ResenaEvent($resenaJson))->toOthers();

        $resena->save();
        return response()->json($resenaJson, 201);
    }

    /**
     * Elimina la reseña indicada.
     * El usuario debe estar logueado.
     * La reseña debe ser del usuario logueado.
     */
    public function delete($idResena){
        //Comprobar autenticación
        try{
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (JWTException $e){
            return response()->json('Debes autenticarte para poder comentar.', 403);
        }

        //Comprobar que la reseña existe
        $resena = Resena::find($idResena);
        if ( $resena == null ){
            return response()->json('La reseña solicitada no existe.', 400);
        }

        //Comprobar que la reseña pertenece al usuario logueado
        if ($user->id != $resena->user_id){
            return response()->json('Ops, no puedes modificar la reseña de otro usuario!', 403);
        }

        //Eliminar la reseña
        $resena = Resena::find($idResena);
        $resena->delete();
        return response()->json('Reseña eliminada.', 204);
    }
}
