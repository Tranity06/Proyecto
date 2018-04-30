<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Devuelve todas las salas.
Route::get("/sala", function (){
    return App\Models\Sala::all();
});

// Devuelve todas las butacas de una sala.
Route::get("/butaca/{id}", function ($id){
    return App\Models\Butaca::all()->where('sala_id',$id);
});

Route::put("/butaca/{id}", function (Request $request, $id){

    $butaca = App\Models\Butaca::findOrFail($id);
    $butaca->update($request->all());

    // Real-time
    event(new \App\Events\ButacaPosted());

    return 204;
});