<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use JWTFactory;

class APIRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:usuarios|alpha_dash|max:20',
            'email' => 'required|unique:usuarios|email|max:255',
            'tlf' => 'required|regex:/(6)[0-9]{8}/',
            'password' => 'required|min:6|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        Usuario::create([
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            'tlf' => $request->input('tlf'),
            'password' => bcrypt($request->input('password')),
            'token' => str_random(25),
        ]);

        $user = Usuario::first();
        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token'));
    }
}