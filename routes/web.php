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

// teacher
Route::prefix('teacher')->group(function () {
    Route::get('/', 'Teacher\TeacherController@index')->name('teacher_home');

    Route::get('bot', 'Teacher\BotController@index')->name('teacher_bot');
    Route::get('bot/regist', 'Teacher\BotController@registForm')->name('teacher_bot_regist');
    Route::post('bot/regist', 'Teacher\BotController@regist');
    Route::get('bot/update/{id}', 'Teacher\BotController@updateForm')->name('teacher_bot_update');
    Route::post('bot/update/{id}', 'Teacher\BotController@update');
    Route::get('bot/delete/{id}', 'Teacher\BotController@delete')->name('teacher_bot_delete');

    Route::get('scenario', 'Teacher\ScenarioController@index')->name('teacher_scenario');
    Route::get('scenario/regist', 'Teacher\ScenarioController@registForm')->name('teacher_scenario_regist');
    Route::post('scenario/regist', 'Teacher\ScenarioController@regist');
    Route::get('scenario/update/{id}', 'Teacher\ScenarioController@updateForm')->name('teacher_scenario_update');
    Route::post('scenario/update/{id}', 'Teacher\ScenarioController@update');
    Route::get('scenario/delete/{id}', 'Teacher\ScenarioController@delete')->name('teacher_scenario_delete');

    Route::get('stage', 'Teacher\StageController@index')->name('teacher_stage');
    Route::get('stage/regist', 'Teacher\StageController@registForm')->name('teacher_stage_regist');
    Route::post('stage/regist', 'Teacher\StageController@regist');
    Route::get('stage/update/{id}', 'Teacher\StageController@updateForm')->name('teacher_stage_update');
    Route::post('stage/update/{id}', 'Teacher\StageController@update');
    Route::get('stage/delete/{id}', 'Teacher\StageController@delete')->name('teacher_stage_delete');

    Route::get('user', 'Teacher\UserController@index')->name('teacher_user');
    Route::get('user/regist', 'Teacher\UserController@registForm')->name('teacher_user_regist');
    Route::post('user/regist', 'Teacher\UserController@regist');
    Route::get('user/relation/{id}', 'Teacher\UserController@relation')->name('teacher_user_relation');
    Route::get('user/log/{id}', 'Teacher\UserController@log')->name('teacher_user_log');
    Route::get('user/log/{id}/{scenario}', 'Teacher\UserController@logScenario')->name('teacher_user_log_scenario');
    Route::get('user/log/{id}/{scenario}/download', 'Teacher\UserController@logDownload')->name('teacher_user_log_scenario_download');

    Route::get('login', 'Teacher\LoginController@showLoginForm')->name('teacher_login');
    Route::post('login', 'Teacher\LoginController@login');
});

// admin
Route::prefix('admin')->group(function () {
    Route::get('/', 'Admin\AdminController@index')->name('admin_home');

    Route::get('bot', 'Admin\AdminController@bot')->name('admin_bot');
    Route::post('bot', 'Admin\AdminController@botRegist');
    Route::get('bot/delete/{id}', 'Admin\AdminController@botDelete')->name('admin_bot_delete');

    Route::get('scenario', 'Admin\AdminController@scenario')->name('admin_scenario');
    Route::post('scenario', 'Admin\AdminController@scenarioRegist');
    Route::get('scenario/delete/{id}', 'Admin\AdminController@scenarioDelete')->name('admin_scenario_delete');

    Route::get('user', 'Admin\UserController@index')->name('admin_user');
    Route::get('user/log/{id}', 'Admin\UserController@log')->name('admin_user_log');
    Route::get('user/log/{id}/{scenario}', 'Admin\UserController@logScenario')->name('admin_user_log_scenario');
    Route::get('user/log/{id}/{scenario}/download', 'Admin\UserController@logDownload')->name('admin_user_log_scenario_download');

    Route::get('teacher', 'Admin\TeacherController@index')->name('admin_teacher');
    Route::get('teacher/regist', 'Admin\TeacherController@registForm')->name('admin_teacher_regist');
    Route::post('teacher/regist', 'Admin\TeacherController@regist');
    Route::get('teacher/delete/{id}', 'Admin\TeacherController@delete')->name('admin_teacher_delete');

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin_login');
    Route::post('login', 'Admin\LoginController@login');
});