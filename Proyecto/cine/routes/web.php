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
/*
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/

Auth::routes();

Route::get('/admin', 'Admin\Home@index');
  Route::prefix('admin')->group(function() {
    Route::get('/login', 'Admin\Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'Admin\Home@index')->name('admin.dashboard');
    Route::post('/logout', 'Admin\Home@logout');
  });