<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verify($token){
        Usuario::where('token',$token)->firstOrFail()
                ->update(['token' => null]);

        return redirect()->route('home');
    }
}
