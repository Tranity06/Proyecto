<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\Home;  //Posible quitar parte Home?

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('user/verify/{verification_code}', 'APIAuthController@verifyUser');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

/**
 * Authentication ADMIN
 */

Route::get('/admin', 'Admin\Home@index');
  Route::prefix('admin')->group(function() {
    Route::get('/login', 'Admin\Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'Admin\Home@index')->name('admin.dashboard');
    Route::post('/logout', 'Admin\Home@logout');
  });

  /**
   * Gestion ADMINISTRADORES
   */
  Route::get('admin/settings', 'Admin\AdministradoresController@mostrarDetalleCuenta')->name('admin.perfil');
  
  Route::post('admin/comprobar','Admin\AdministradoresController@comprobarDatos'); //AJAX
  Route::get('admin/comprobar','Admin\AdministradoresController@comprobarDatos');
  
  Route::post('admin/modificaradmin','Admin\AdministradoresController@modificarAdmin')->name('admin.modificarPerfil');
  Route::get('admin/modificaradmin','Admin\AdministradoresController@modificarAdmin');

  Route::get('admin/crearadministrador', 'Admin\AdministradoresController@crearGet')->name('admin.crearAdmin.get');
  Route::post('admin/crearadministrador', 'Admin\AdministradoresController@crearPost')->name('admin.crearAdmin.post');
  
  Route::get('admin/administradores', 'Admin\AdministradoresController@mostrar')->name('admin.listarAdmin');
  
  Route::post('admin/borrar', 'Admin\AdministradoresController@borrar')->name('admin.borrarAdmin');
  Route::get('admin/borrar', 'Admin\AdministradoresController@borrar');

  /**
   * Gestión PELÍCULAS
   */
  Route::get('pelicula/crear', 'PeliculaController@crear');
  Route::post('pelicula/crear', 'PeliculaController@crearPost')->name('pelicula.crear');
  Route::get('peliculas/mostrar', 'PeliculaController@mostrar');
  Route::post('peliculas/borrar', 'PeliculaController@borrar');

  /**
   * Gestión SLIDER
   */
  Route::get('slider', 'SliderController@mostrar');
  Route::post('slider/borrar', 'SliderController@borrar');
  Route::post('/slider/anadir', 'SliderController@anadir');

  /**
   * Gestión SALAS
   */
  ROUTE::get('salas', 'SalaController@motrarTodas')->name('salas.mostrar');
  ROUTE::get('sala/{idSala}', 'SalaController@motrarSala');
  ROUTE::get('sala', 'SalaController@crear');
  ROUTE::post('sala', 'SalaController@crearPost'); //AJAX
  ROUTE::post('sala/borrar', 'SalaController@borrar'); //AJAX
  //ROUTE::post('sala/modificar', 'SalaController@modificar'); //AJAX

  /**
   * Gestión BUTACAS
   */
  Route::post('butaca/bloquear', 'ButacaController@bloquear');
  Route::post('butaca/desbloquear', 'ButacaController@desbloquear');

  /**
   * Gestión SESIONES
   */
  Route::get('sesiones', 'SesionController@mostrarTodas')->name('sesiones.mostrar');
  Route::get('sesion/{idSesion}', 'SesionController@mostrarSesion');
  Route::get('sesion', 'SesionController@crear');
  Route::post('sesion', 'SesionController@crearPost'); //AJAX
  Route::post('sesion/borrar', 'SesionController@borrar'); //AJAX
  Route::post('sesion/modificar', 'SesionController@mostrarTodas'); //AJAX

  /**
   * Gestión PLANTILLAS_SESIONES
   */
  Route::get('plantillas', 'PlantillaSesionController@mostrarTodas')->name('plantillas.mostrar');
  Route::get('plantilla/{idPlantilla}', 'PlantillaSesionController@mostrarPlantilla')->name('plantilla.mostrar');
  Route::get('plantilla', 'PlantillaSesionController@crear')->name('plantillas.crear');
  Route::post('plantilla', 'PlantillaSesionController@crearPost'); //AJAX
  Route::post('plantilla/modificar', 'PlantillaSesionController@modificar'); //AJAX
  Route::post('plantilla/borrar', 'PlantillaSesionController@borrar'); //AJAX

  /**
   * Gestión SESIONES_VACIAS
   */
  Route::post('sesionvacia/borrar', 'SesionVaciaController@borrar'); //AJAX
  Route::post('sesionvacia/crear', 'SesionVaciaController@crear'); //AJAX
  
  /**
   * Gestión MENÚS
   */
  Route::get('menus/crear', 'MenuController@crear');
  Route::post('menus/crear', 'MenuController@addMenu')->name('menus.crear');
  Route::get('menus/mostrar', 'MenuController@mostrar')->name('menus.mostrar');
  Route::get('menus/{idMenu}', 'MenuController@mostrarMenu');
  Route::post('menus/{idMenu}', 'MenuController@updateMenu');
  Route::post('menus/borrar', 'MenuController@deleteMenu');

  /**
   * Gestión CATEGORÍAS
   */
  Route::get('categorias/crear', 'CategoriaController@crear');
  Route::post('categorias/crear', 'CategoriaController@addCategoria')->name('categorias.crear');
  Route::get('categorias/mostrar', 'CategoriaController@mostrar')->name('categorias.mostrar');
  Route::get('categorias/{idCategoria}', 'CategoriaController@mostrarCategoria');
  Route::post('categorias/{idCategoria}', 'CategoriaController@updateCategoria');
  Route::post('categorias/borrar', 'CategoriaController@deleteCategoria');

  /**
   * Gestion de productos de menus
   */
  Route::get('productomenu/{idMenu}', 'MenuController@menuProductos');
  Route::post('productomenu/{idMenu}', 'MenuController@anadirProductos');
  Route::get('productomenu/getproductos/{idMenu}', 'MenuController@getProductosMenu');
  Route::delete('productomenu/{idMenu}', 'MenuController@borrarProductos');
 //////// Route::post('productomenu/{idMenu}', 'MenuController@borrarProductos');

  /**
   * Gestión PRODUCTOS
   */
  Route::get('productos/crear', 'ProductoController@crear');
  Route::post('productos/crear', 'ProductoController@addProducto')->name('producto.crear');
  Route::get('productos/mostrar', 'ProductoController@mostrar');
  Route::get('productos/{idProducto}', 'ProductoController@mostrarProducto');
  Route::post('productos/{idProducto}', 'ProductoController@updateProducto');

  
/**
 * HOME -> NO TOCAR tiene que ser SIEMPRE la ultima ruta.
 */
Route::get('/{any}', 'SpaController@index')->where('any', '.*')->name('home');
