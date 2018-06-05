<?php
/**
 * Created by PhpStorm.
 * User: Emanuel
 * Date: 5/6/18
 * Time: 21:32
 */

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Image;
use Validator;

class PerfilController extends Controller {

    public function cambiarEmail(Request $request){
        $user = User::find($this->getUser()->id);

        $user->email = $request->email;

        $user->saveOrFail();

        return response()->json('Success',200);
    }

    public function cambiarTelefono(Request $request){
        $user = User::find($this->getUser()->id);

        $user->telefono = $request->telefono;

        $user->saveOrFail();

        return response()->json('Success',200);
    }

    public function cambiarAvatar(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png'
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
    }

    public function getUser(){
        $user = auth()->user();

        if ( $user == null ) {
            return response()->json('Permiso denegado', 403);
        }

        return $user;
    }

}