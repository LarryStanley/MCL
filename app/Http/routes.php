<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/home', function () {
	return redirect('/dashboard');
});

Route::get('/fresh', "FreshController@index");
Route::get('/fresh/currentStatus', "FreshController@returnStatus");
Route::post('/fresh/signUp', "FreshController@signUp");

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function() {

	Route::group(['middleware' => 'admin'], function() {
		Route::get('/announcement/new', "DashboardController@newDocument");
		Route::get('/announcement', "DashboardController@showAnnouncement");
		Route::post('/announcement', "DashboardController@postAnnouncement");
		Route::get('/changeUserGroup', "DashboardController@changeUserGroup");
		Route::get('/changeUserGroup/{id}', "DashboardController@changeUserGroupById");
		Route::post('/changeUserGroup', "DashboardController@postUserGroup");
	});
	Route::get('/', "DashboardController@index");
	Route::get('/workerDiary', "DashboardController@showAllWorkerDiary");
	Route::get('/workerDiary/new', "DashboardController@showNewDiary");
	Route::post('/workerDiary/new', "DashboardController@postNewDiary");
	Route::get('/workerDiary/{id}', "DashboardController@showDiary");
	Route::get('/workerDiary/edit/{id}', "DashboardController@showEditDiary");

	Route::get('/documents/{id}', "DashboardController@showDocument");
	Route::get('/documents/edit/{id}', "DashboardController@editDocument");
	Route::post('/documents/edit', "DashboardController@postDocument");

	Route::get('/driver', "DashboardController@showDrivers");
	Route::get('/software', "DashboardController@showSoftware");
	Route::get('/os', "DashboardController@showOS");
	Route::get('/newComputer', "DashboardController@showNewComputer");
	Route::post('/newComputer', "DashboardController@newComputer");
	Route::get('/uploadDriver', "DashboardController@showUploadDriver");
	Route::post('/uploadDriver', "DashboardController@uploadDriver");

	Route::get('/result', "DashboardController@freshResult");
	Route::get('/time', "DashboardController@freshTime");

});

// 認證路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 註冊路由...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');