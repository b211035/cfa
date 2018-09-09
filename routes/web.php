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
Route::get('home', 'HomeController@index')->name('home');
Route::get('talk/{id}', 'HomeController@talk')->name('talk');
Route::get('log', 'HomeController@log')->name('log');

// admin
Route::get('/admin', 'Admin\AdminController@index')->name('admin_home');

Route::get('admin/bot', 'Admin\AdminController@bot')->name('admin_bot');
Route::post('admin/bot', 'Admin\AdminController@botRegist');
Route::get('admin/bot/delete/{id}', 'Admin\AdminController@botDelete')->name('admin_bot_delete');

Route::get('admin/scenario', 'Admin\AdminController@scenario')->name('admin_scenario');
Route::post('admin/scenario', 'Admin\AdminController@scenarioRegist');
Route::get('admin/scenario/delete/{id}', 'Admin\AdminController@scenarioDelete')->name('admin_scenario_delete');

Route::get('admin/user', 'Admin\AdminController@user')->name('admin_user');
Route::get('admin/user/log/{id}', 'Admin\AdminController@userLog')->name('admin_user_log');

Route::get('admin/login', 'Admin\LoginController@showLoginForm')->name('admin_login');
Route::post('admin/login', 'Admin\LoginController@login');
