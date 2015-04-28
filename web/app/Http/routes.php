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

Route::get('/admin/login', 'Auth\AuthController@getLogin');

Route::controllers([
	'admin/auth' => 'Auth\AuthController',
	// 'password' => 'Auth\PasswordController',
	'admin'	=>	'AdminController',
	'users'	=>	'UsersController'
]);

// Api
Route::group(['prefix' => 'api'], function () {
	// Users
	Route::resource('users', 'Api\UsersController', ['only' => ['store', 'update']]);
	// Route::post('/users', 'UsersController@store');
});
