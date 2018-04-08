<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller{

  public function getSignup(){
      //devuelveme la vista resources/views/auth/signup.blade.php
      return view('auth.signup');
  }

  public function postSignup(Request $request){
        dd('Hi');
  }
}
