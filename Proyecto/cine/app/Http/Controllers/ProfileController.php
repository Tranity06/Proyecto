<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Validator;


class ProfileController extends Controller
{
    public function update_avatar(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image64:jpeg,jpg,png',
            'userId' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        } else {
            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->resize(300, 300)->save( public_path('/uploads/avatars/' . $fileName));

            $user = User::find($request->get('userId'));
            $user->avatar = $fileName;
            $user->save();

            return response()->json(['success'=>true,'avatar_name'=>$fileName]);
        }
    }
}
