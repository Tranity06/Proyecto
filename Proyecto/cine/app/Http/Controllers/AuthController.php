<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    return redirect()->route('home');
  }

  public function getLogin(){
    return view('auth.login');
  }

  public function postLogin(Request $request){
      $this->validate($request,[
        'email' => 'required',
        'clave' => 'required'
      ]);

      $email= $request->input('email');
      $clave= $request->input('clave');
      $recordar = $request->has('recordar');

      var_dump($email);
      var_dump($clave);
      var_dump($recordar);   

     var_dump(Auth::attempt(['email' => $email, 'clave' => $clave]));

     $success = Auth::attempt(['email' => $email, 'clave' => $clave],$recordar);    

     var_dump($success);

     if(!$success){

       //return redirect()->back();
     }

     //return redirect()->route('home');
  }

}
