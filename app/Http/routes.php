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
	//system users
	Route::post('system_users', 'Auth\SystemUserController@save');
	Route::get('system_users/{id}', 'Auth\SystemUserController@get');
	Route::put('system_users/{id}', 'Auth\SystemUserController@update');
	Route::delete('system_users/{id}', 'Auth\SystemUserController@destroy');	
	Route::get('system_users', 'Auth\SystemUserController@listing');	
	Route::post('system_users/image', 'Auth\SystemUserController@upload');

	// auth Routes
	Route::post('auth/login', 'Auth\SystemUserController@login');
	Route::post('auth/password', 'Auth\SystemUserController@updatePassword');
	Route::post('auth/forgot', 'Auth\SystemUserController@resetPasswordEmail');
	Route::post('auth/update_password', 'Auth\SystemUserController@resetPassword');

	//Country
	Route::post('country', 'Location\CountryController@save');
 	Route::get('country', 'Location\CountryController@listing');
 	Route::get('country/{id}', 'Location\CountryController@get');
 	Route::put('country/{id}', 'Location\CountryController@update');
 	Route::delete('country/{id}', 'Location\CountryController@destroy');

 	//Currency
 	Route::post('currency', 'Currency\CurrencyController@save');
 	Route::get('currency/{id}', 'Currency\CurrencyController@get');
 	Route::put('currency/{id}', 'Currency\CurrencyController@update');
 	Route::delete('currency/{id}', 'Currency\CurrencyController@destroy');

 	//Language
 	Route::post('language', 'Language\LanguageController@save');
 	Route::get('language/{id}', 'Language\LanguageController@get');
 	Route::put('language/{id}', 'Language\LanguageController@update');
 	Route::delete('language/{id}', 'Language\LanguageController@destroy');
	
	// Car Make
	Route::get('car/make', 'Car\MakeController@listing');
});

// Admin Routes
Route::get('/admin', 'App\AdminController@showLogin');
Route::get('/admin/logout', 'Auth\SystemUserController@logout');
Route::get('/admin/reset_password/{code}', 'App\AdminController@showResetPassword');

// Admin auth required routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::get('profile', 'App\AdminController@showProfile');
	Route::get('dashboard', 'App\AdminController@showDashboard');
	Route::get('car/make', 'App\AdminController@showCarMake');	
	Route::get('users', 'App\AdminController@showUser');

	Route::get('country', 'App\AdminController@showCountry');


});


