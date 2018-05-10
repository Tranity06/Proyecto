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

/**
 * HOME
 */
Route::get('/',function (){
    return view('vuehome');
})->name('home');

Route::get('user/verify/{verification_code}', 'APIAuthController@verifyUser');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

/*Route::get('/signup','AuthController@getSignup')->name('auth.signup');

Route::post('/signup','AuthController@postSignup');


Route::get('/login','AuthController@getLogin')->name('auth.login');

Route::post('/login','AuthController@postLogin');

Route::get('/logout','AuthController@getLogout')->name('auth.logout');

Route::get('/profile', 'AuthController@profile')->name('auth.profile');

Route::post('/profile', 'AuthController@update_avatar');*/

/**
 * Verificar cuenta
 */

Route::get('/verify/{token}','VerifyController@verify')->name('verify');


/**
 * Comprar entrada
 */

Route::get('/entrada','EntradaController@index')->name('comprarentrada');

/**
 * SPA
 */

Route::get('/spa',function (){
    return view('spa');
});

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