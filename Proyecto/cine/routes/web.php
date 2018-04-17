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

Auth::routes();
Route::get('/','HomeController@index')->name('home');

/**
 * Authentication USER
 */

Route::get('/signup','AuthController@getSignup')->name('auth.signup');

Route::post('/signup','AuthController@postSignup');


Route::get('/login','AuthController@getLogin')->name('auth.login');

Route::post('/login','AuthController@postLogin');

Route::get('/logout','AuthController@getLogout')->name('auth.logout');


/**
 * Verificar cuenta
 */

Route::get('/verify/{token}','VerifyController@verify')->name('verify');

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
  Route::post('admin/comprobar','Admin\AdministradoresController@comprobarDatos');
  Route::post('admin/midificaradmin','Admin\AdministradoresController@modificarAdmin');
