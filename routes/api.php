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

Route::post('/register', 'APIAuthController@register')->name('auth.register');
Route::post('/login', 'APIAuthController@login')->name('auth.login');
Route::post('/google', 'APIAuthController@loginWithGoogle')->name('auth.google');
Route::post('/recover', 'APIAuthController@recover')->name('auth.recover');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'APIAuthController@logout')->name('auth.logout');
    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Devuelve todas las butacas de una sala.
Route::get("/butaca/{id}", function ($id){
    return App\Models\ButacaReservada::all()->where('sesion_id',$id)->values();
});

Route::post("/butaca/{id}", function (Request $request, $id){

    $butaca = App\Models\ButacaReservada::findOrFail($id);
    $butaca->update($request->all());
    // Real-time
    broadcast(new ButacaEvent($id,$request->all()))->toOthers();

    return '';
});

/**
 * PELICULAS
 */
Route::get('peliculas', 'PeliculaController@getAll')->name('pelicula.getAll');
Route::get('pelicula/{idPelicula}','PeliculaController@getOne')->name('pelicula.getOne'); // este es para la informacion de la pelicula
Route::get('pelicula/{idPelicula}/resenas','PeliculaController@getResenas')->name('pelicula.getResenas');
Route::get('pelicula/{idPelicula}/entrada','PeliculaController@getEntrada')->name('pelicula.getEntrada');
//Route::get('pelicula/sesiones/{fecha}','PeliculaController@getSesiones')->name('pelicula.getSesiones');

/**
 * Pago
 */

Route::post('/pago','PagoController@confirmarPago')->name('pago.confirmarPago');

/**
 * Reseñas
 */

Route::get('/resena','ResenaController@getAllFromUser')->name('resena.get');
Route::post('/resena','ResenaController@crearResenia')->name('resena.crearResenia');
Route::put('/resena/{idResena}','ResenaController@update')->name('resena.update');
Route::delete('/resena/{idResena}','ResenaController@delete')->name('resena.delete');

/**
 * SLIDER
 */
Route::get('/slider','SliderController@get')->name('slider.get');

/**
 * Categorias
 */

/** NO UTILICES VERBOS EN LAS RUTAS, solamente el nombre, mira nuestros ejemplos mas arriba, el de reseña es un buen ejemplo.
 *  GET -> /categoria -> Lista y una categoria en concreto
 *  POST ->  /categoria -> y pasas por request todos los parametros necesarios para crear una categoria
 *  PUT -> /categoria/{idCategoria}
 *  DELETE -> /categoria/{idCategoria}
 */

Route::get('/categoria','CategoriaController@getAll')->name('categoria.get');
Route::post('/categoria','CategoriaController@crearCategoria')->name('categoria.crearCategoria');
Route::put('/categoria/{idCategoria}','CategoriaController@update')->name('categoria.update');
Route::delete('/categoria/{idCategoria}','CategoriaController@delete')->name('categoria.delete');
  
  
/**
 * Ingredientes
 */

Route::get('/ingrediente', 'IngredienteController@getAll')->name('ingrediente.get');
Route::post('/ingrediente', 'IngredienteController@addIngrediente')->name('ingrediente.add');
Route::put('/ingrediente/{idIngrediente}', 'IngredienteController@updateIngrediente')->name('ingrediente.update');
Route::delete('/ingrediente/{idIngrediente}', 'IngredienteController@deleteIngrediente')->name('ingrediente.delete');


/**
 * Menus
 */

Route::get('/menu', 'MenuController@getAll')->name('menu.get');
Route::post('/menu', 'MenuController@addMenu')->name('menu.add');
Route::put('/menu/{idMenu}', 'MenuController@updateMenu')->name('menu.update');
Route::delete('/menu/{idMenu}', 'MenuController@deleteMenu')->name('menu.delete');


/**
 * Productos
 */

Route::get('/producto', 'ProductoController@getAll')->name('producto.get');
Route::post('/producto', 'ProductoController@addProducto')->name('producto.add');
Route::put('/producto/{idProducto}', 'ProductoController@updateProducto')->name('producto.update');
Route::delete('/producto/{idProducto}', 'ProductoController@deleteProducto')->name('producto.delete');

/**
 * Perfil
 */

Route::post('/datos/email','PerfilController@cambiarEmail')->name('cambiar.email');
Route::post('/datos/telefono','PerfilController@cambiarTelefono')->name('cambiar.telefono');
Route::post('/datos/avatar','PerfilController@cambiarAvatar')->name('cambiar.avatar');
Route::post('/datos/clave','PerfilController@cambiarClave')->name('cambiar.clave');