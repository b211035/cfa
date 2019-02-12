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
})->name('root');

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
Route::get('log/{id}', 'HomeController@log')->name('log');
Route::get('log/stage/{id}', 'HomeController@stageLog')->name('stage_log');

Route::get('profile', 'HomeController@profile')->name('profile');
Route::get('school', 'HomeController@schoolRegistForm')->name('user_school');
Route::post('school', 'HomeController@schoolRegist');

Route::get('avatar', 'UserAvatarController@index')->name('user_avatar');
Route::get('avatar/regist', 'UserAvatarController@registForm')->name('user_avatar_regist');
Route::post('avatar/regist', 'UserAvatarController@regist');
Route::get('avatar/update/{avatar_id}', 'UserAvatarController@updateForm')->name('user_avatar_update');
Route::post('avatar/update/{avatar_id}', 'UserAvatarController@update');
Route::get('avatar/delete/{avatar_id}', 'UserAvatarController@delete')->name('user_avatar_delete');


// teacher
Route::prefix('teacher')->group(function () {
    Route::get('/', 'Teacher\TeacherController@index')->name('teacher_home');
    Route::get('profile', 'Teacher\TeacherController@profile')->name('teacher_profile');
    Route::get('school', 'Teacher\TeacherController@schoolRegistForm')->name('teacher_school');
    Route::post('school', 'Teacher\TeacherController@schoolRegist');


    Route::get('bot', 'Teacher\BotController@index')->name('teacher_bot');
    Route::get('bot/regist', 'Teacher\BotController@registForm')->name('teacher_bot_regist');
    Route::post('bot/regist', 'Teacher\BotController@regist');
    Route::get('bot/update/{id}', 'Teacher\BotController@updateForm')->name('teacher_bot_update');
    Route::post('bot/update/{id}', 'Teacher\BotController@update');
    Route::get('bot/delete/{id}', 'Teacher\BotController@delete')->name('teacher_bot_delete');

    Route::get('bot/avatar', 'Teacher\BotAvatarController@index')->name('teacher_bot_avatar');
    Route::get('bot/avatar/regist', 'Teacher\BotAvatarController@registForm')->name('teacher_bot_avatar_regist');
    Route::post('bot/avatar/regist', 'Teacher\BotAvatarController@regist');
    Route::get('bot/avatar/update/{avatar_id}', 'Teacher\BotAvatarController@updateForm')->name('teacher_bot_avatar_update');
    Route::post('bot/avatar/update/{avatar_id}', 'Teacher\BotAvatarController@update');
    Route::get('bot/avatar/delete/{avatar_id}', 'Teacher\BotAvatarController@delete')->name('teacher_bot_avatar_delete');

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

    Route::get('stage/next/{prev_id}', 'Teacher\StageController@nextStage')->name('teacher_next_stage');
    Route::post('stage/next/{prev_id}', 'Teacher\StageController@addNextStage');
    Route::get('stage/next/delete/{prev_id}/{next_id}', 'Teacher\StageController@deleteNextStage')->name('teacher_next_stage_delete');

    Route::get('user', 'Teacher\UserController@index')->name('teacher_user');
    Route::get('user/regist', 'Teacher\UserController@registForm')->name('teacher_user_regist');
    Route::post('user/regist', 'Teacher\UserController@regist');
    Route::get('user/log/{id}', 'Teacher\UserController@log')->name('teacher_user_log');
    Route::get('user/log/{id}/{scenario}', 'Teacher\UserController@logScenario')->name('teacher_user_log_scenario');
    Route::get('user/log/{id}/{scenario}/download', 'Teacher\UserController@logDownload')->name('teacher_user_log_scenario_download');
    Route::post('user/enable/{id}', 'Teacher\UserController@enable')->name('teacher_user_enable');
    Route::post('user/disable/{id}', 'Teacher\UserController@disable')->name('disaacher_user_enable');
    Route::post('user/delete/{id}', 'Teacher\UserController@delete')->name('teacher_user_delete');

    Route::get('login', 'Teacher\LoginController@showLoginForm')->name('teacher_login');
    Route::post('login', 'Teacher\LoginController@login');
});

// admin
Route::prefix('admin')->group(function () {
    Route::get('/', 'Admin\AdminController@index')->name('admin_home');

    Route::get('user', 'Admin\UserController@index')->name('admin_user');
    Route::get('user/log/{id}', 'Admin\UserController@log')->name('admin_user_log');
    Route::get('user/log/{id}/{scenario}', 'Admin\UserController@logScenario')->name('admin_user_log_scenario');
    Route::get('user/log/{id}/{scenario}/download', 'Admin\UserController@logDownload')->name('admin_user_log_scenario_download');
    Route::get('user/delete/{id}', 'Admin\UserController@delete')->name('admin_user_delete');

    Route::get('teacher', 'Admin\TeacherController@index')->name('admin_teacher');
    Route::get('teacher/regist', 'Admin\TeacherController@registForm')->name('admin_teacher_regist');
    Route::post('teacher/regist', 'Admin\TeacherController@regist');
    Route::get('teacher/delete/{id}', 'Admin\TeacherController@delete')->name('admin_teacher_delete');

    Route::get('school', 'Admin\SchoolController@index')->name('admin_school');
    Route::get('school/regist', 'Admin\SchoolController@registForm')->name('admin_school_regist');
    Route::post('school/regist', 'Admin\SchoolController@regist');
    Route::get('school/delete/{id}', 'Admin\SchoolController@delete')->name('admin_school_delete');

    Route::get('talktag', 'Admin\TalktagController@index')->name('admin_talktagtype');
    Route::get('talktag/{type_id}', 'Admin\TalktagController@talktag')->name('admin_talktag');
    Route::get('talktag/{type_id}/regist', 'Admin\TalktagController@registForm')->name('admin_talktag_regist');
    Route::post('talktag/{type_id}/regist', 'Admin\TalktagController@regist');
    Route::get('talktag/{type_id}/delete/{id}', 'Admin\TalktagController@delete')->name('admin_talktag_delete');

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin_login');
    Route::post('login', 'Admin\LoginController@login');
});