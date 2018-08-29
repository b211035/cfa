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

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// main
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/talk/{id}', 'HomeController@talk')->name('talk');


// admin
Route::get('/admin', 'AdminController@index')->name('admin_home');
Route::get('/admin/bot', 'AdminController@bot')->name('admin_bot');
Route::post('admin/bot', 'AdminController@botRegist');
Route::get('/admin/scenario', 'AdminController@scenario')->name('admin_scenario');
Route::post('admin/scenario', 'AdminController@scenarioRegist');
