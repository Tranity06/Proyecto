<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Notifications\VerifyEmail;
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
        'password' => 'required|min:6|confirmed'
      ]);

     $usuario = Usuario::create([
        'nombre' => $request->input('nombre'),
        'email' => $request->input('email'),
        'tlf' => $request->input('tlf'),
        'password' => bcrypt($request->input('password')),
        'token' => str_random(25),
      ]);

     $usuario->sendVerificationEmail();

    return redirect()->route('home');
  }

  public function getLogin(){
    return view('auth.login');
  }

  public function postLogin(Request $request){
      $this->validate($request,[
        'email' => 'required',
        'password' => 'required'
      ]);

     $email= $request->input('email');
     $password= $request->input('password');
     $remember = $request->has('remember');

     $success = Auth::attempt(['email' => $email, 'password' => $password],$remember);    

     if(!$success){
        return redirect()->back();
     }

     return redirect()->route('home');
  }

  public function getLogout(){
    Auth::logout();
    return redirect()->route('home');
  }

}
