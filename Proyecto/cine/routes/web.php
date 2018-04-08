<?php

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

Route::get('/','HomeController@index')->name('home');

/**
 * Authentication
 */

Route::get('/signup','AuthController@getSignup')->name('auth.signup');

Route::post('/signup','AuthController@postSignup');


Route::get('/login','AuthController@getLogin')->name('auth.login');

Route::post('/login','AuthController@postLogin');