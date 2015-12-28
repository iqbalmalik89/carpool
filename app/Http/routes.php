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



// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/admin', 'App\AdminController@showLogin');

Route::get('/', function () {
	echo '<h2>Something awesome is in progress</h2>';
});

// API Routes
Route::group(['prefix' => 'api'], function () 
{
	Route::post('system_users', 'Auth\SystemUserController@save');
	Route::get('system_users/{id}', 'Auth\SystemUserController@get');
	Route::put('system_users/{id}', 'Auth\SystemUserController@update');
	Route::delete('system_users/{id}', 'Auth\SystemUserController@destroy');	
	Route::get('system_users', 'Auth\SystemUserController@listing');	
	Route::post('system_users/image', 'Auth\SystemUserController@upload');
	Route::post('auth/login', 'Auth\SystemUserController@login');
	Route::post('auth/password', 'Auth\SystemUserController@updatePassword');

	// Car Make
	Route::get('car/make', 'Car\MakeController@listing');
});

// Admin Routes
Route::get('/admin', 'App\AdminController@showLogin');
Route::get('/admin/logout', 'Auth\SystemUserController@logout');



// Admin auth required routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::get('profile', 'App\AdminController@showProfile');
	Route::get('dashboard', 'App\AdminController@showDashboard');
	Route::get('car/make', 'App\AdminController@showCarMake');	
	Route::get('users', 'App\AdminController@showUser');
});


