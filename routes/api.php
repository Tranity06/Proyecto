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
Route::post('/resena/{idUsuario}','ResenaController@crearResenia')->name('resena.crearResenia');
Route::put('/resena/{idResena}','ResenaController@update')->name('resena.update');
Route::delete('/resena/{idResena}','ResenaController@delete')->name('resena.delete');

/**
 * SLIDER
 */
Route::get('/slider','SliderController@get')->name('slider.get');

/**
 * Categorias
 */

Route::prefix('categoria')->group(function() {
    Route::get('/add', 'CategoriaController@getAdd')->name('categoria.add');
    Route::post('/add', 'CategoriaController@postAdd');
    Route::get('/', 'CategoriaController@list')->name('categoria.list');
    Route::get('/update', 'CategoriaController@getUpdate')->name('categoria.update');
    Route::post('/update', 'CategoriaController@postUpdate');
    Route::get('/delete', 'CategoriaController@delete')->name('categoria.delete');
  });
  
  
  /**
   * Productos
   */
  
  Route::prefix('producto')->group(function() {
    Route::get('/add', 'ProductoController@getAdd')->name('producto.add');
    Route::post('/add', 'ProductoController@postAdd');
    Route::get('/', 'ProductoController@list')->name('producto.list');
    Route::get('/update', 'ProductoController@getUpdate')->name('producto.update');
    Route::post('/update', 'ProductoController@postUpdate');
    Route::get('/delete', 'ProductoController@delete')->name('producto.delete');
  });
  
  
  /**
   * Ingredientes
   */
  
  Route::prefix('ingrediente')->group(function() {
    Route::get('/add', 'IngredienteController@getAdd')->name('ingrediente.add');
    Route::post('/add', 'IngredienteController@postAdd');
    Route::get('/', 'IngredienteController@list')->name('ingrediente.list');
    Route::get('/update', 'IngredienteController@getUpdate')->name('ingrediente.update');
    Route::post('/update', 'IngredienteController@postUpdate');
    Route::get('/delete', 'IngredienteController@delete')->name('ingrediente.delete');
  });
  
  
  /**
   * Menus
   */
  
  Route::prefix('menu')->group(function() {
    Route::get('/add', 'MenuController@getAdd')->name('menu.add');
    Route::post('/add', 'MenuController@postAdd');
    Route::get('/', 'MenuController@list')->name('menu.list');
    Route::get('/update', 'MenuController@getUpdate')->name('menu.update');
    Route::post('/update', 'MenuController@postUpdate');
    Route::get('/delete', 'MenuController@delete')->name('menu.delete');
  });