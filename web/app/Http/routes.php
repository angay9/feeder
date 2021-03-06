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
	return redirect('/admin');
});
Route::get('/admin/login', 'Auth\AuthController@getLogin');

Route::controllers([
	'admin/auth' => 'Auth\AuthController',
	// 'password' => 'Auth\PasswordController',
	'admin'	=>	'AdminController',
	'users'	=>	'UsersController'
]);

Route::controller('services', 'ServicesController');
Route::controller('notifications', 'NotificationsController');

// Api
Route::group(['prefix' => 'api'], function () {
	// Users
	Route::get('users/services/{name?}', 'Api\UsersController@services');
	Route::post('users', 'Api\UsersController@store');

	// Payments
	Route::resource('payments', 'Api\PaymentsController', ['only' => ['store']]);
	
	// Feeds
	Route::get('feeds/{channel}/{type}/{limit?}/{offset?}', 'Api\FeedsController@index');
	// Feeds info
	Route::get('info', 'Api\InfoController@index');

});
