<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AuthController extends Controller{

  public function getSignup(){
      //devuelveme la vista resources/views/auth/signup.blade.php
      return view('auth.signup');
  }

  public function postSignup(Request $request){
      $this->validate($request,[
        'nombre' => 'required|unique:usuarios|alpha_dash|max:20',
        'email' => 'required|unique:usuarios|email|max:255',
        'tlf' => 'required|regex:/(6)[0-9]{8}/',
        'clave' => 'required|min:6|confirmed'
      ]);

      Usuario::create([
        'nombre' => $request->input('nombre'),
        'email' => $request->input('email'),
        'tlf' => $request->input('tlf'),
        'clave' => bcrypt($request->input('clave'))
      ]);

      redirect()->route(('home'));
  }
}
