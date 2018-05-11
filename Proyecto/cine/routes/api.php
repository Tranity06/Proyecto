<?php

use App\Events\ButacaEvent;
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

Route::post('/register', 'APIAuthController@register');
Route::post('/login', 'APIAuthController@login');
Route::post('/recover', 'APIAuthController@recover');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'APIAuthController@logout');
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Guardar avatar
Route::post('/avatar', 'ProfileController@update_avatar');

// Devuelve todas las salas.
Route::get("/sala", function (){
    return App\Models\Sala::all();
});

// Devuelve todas las butacas de una sala.
Route::get("/butaca/{id}", function ($id){
    return App\Models\Butaca::all()->where('sala_id',$id)->values();
});

Route::post("/butaca/{id}", function (Request $request, $id){

    $butaca = App\Models\Butaca::findOrFail($id);
    $butaca->update($request->all());
    // Real-time
    broadcast(new ButacaEvent($id,$request->all()))->toOthers();

    return '';
});

/**
 * PELICULAS
 */
Route::get('peliculas', 'PeliculaController@getAll')->name('pelicula.getAll');
Route::get('pelicula/{idPelicula}','PeliculaController@getOne')->name('pelicula.getOne');
Route::get('pelicula/{idPelicula}/resenas','PeliculaController@getResenas')->name('pelicula.getResenas');
Route::get('pelicula/sesiones/{fecha}','PeliculaController@getSesiones')->name('pelicula.getSesiones');

/**
 * Reseñas
 */
Route::get('/resena/{idUsuario}','ResenaController@getAllFromUser')->name('resena.get');
Route::post('/resena/{idUsuario}/{idPelicula}','ResenaController@create')->name('resena.create');
Route::put('/resena/{idResena}','ResenaController@update')->name('resena.update');
Route::delete('/resena/{idResena}','ResenaController@detele')->name('resena.delete');

/**
 * SLIDER
 */
Route::get('/slider','SliderController@get')->name('slider.get');