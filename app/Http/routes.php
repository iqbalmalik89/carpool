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



Route::get('/cache', function () {
	\Cache::flush();
});

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

	//system users
	Route::post('users', 'Users\UserController@save');
	Route::get('users/{id}', 'Users\UserController@get');
	Route::put('users/{id}', 'Users\UserController@update');
	Route::delete('users/{id}', 'Users\UserController@destroy');	
	Route::get('users', 'Users\UserController@listing');	
	Route::post('users/image', 'Users\UserController@upload');
	
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
 	Route::post('currency', 'Location\CurrencyController@save');
 	Route::get('currency/{id}', 'Location\CurrencyController@get');
 	Route::get('currency', 'Location\CurrencyController@listing'); 	
 	Route::put('currency/{id}', 'Location\CurrencyController@update');
 	Route::delete('currency/{id}', 'Location\CurrencyController@destroy');

 	//Language
 	Route::post('language', 'Location\LanguageController@save');
 	Route::get('language/{id}', 'Location\LanguageController@get');
 	Route::get('language', 'Location\LanguageController@listing'); 	
 	Route::put('language/{id}', 'Location\LanguageController@update');
 	Route::delete('language/{id}', 'Location\LanguageController@destroy');
	
	//Testimonial
 	Route::post('testimonial', 'Testimonial\TestimonialController@save');
 	Route::get('testimonial/{id}', 'Testimonial\TestimonialController@get');
 	Route::get('testimonial', 'Testimonial\TestimonialController@listing'); 	
 	Route::put('testimonial/{id}', 'Testimonial\TestimonialController@update');
 	Route::delete('testimonial/{id}', 'Testimonial\TestimonialController@destroy');
	Route::post('testimonial/image', 'Testimonial\TestimonialController@upload');
	
 	//Radius
 	Route::post('radius', 'Location\RadiusController@save');
 	Route::get('radius/{id}', 'Location\RadiusController@get');
 	Route::get('radius', 'Location\RadiusController@listing'); 	
 	Route::put('radius/{id}', 'Location\RadiusController@update');
 	Route::delete('radius/{id}', 'Location\RadiusController@destroy');

	//Vehicle Category
	Route::post('vehicle_category', 'Vehicle\VehicleCategoryController@save');
 	Route::get('vehicle_category/{id}', 'Vehicle\VehicleCategoryController@get');
 	Route::get('vehicle_category', 'Vehicle\VehicleCategoryController@listing'); 	
 	Route::put('vehicle_category/{id}', 'Vehicle\VehicleCategoryController@update');
 	Route::delete('vehicle_category/{id}', 'Vehicle\VehicleCategoryController@destroy');

 	//Subscriber
 	Route::post('subscriber', 'Email\SubscriberController@save');
 	Route::get('subscriber/{id}', 'Email\SubscriberController@get');
 	Route::get('subscriber', 'Email\SubscriberController@listing'); 	
 	Route::put('subscriber/{id}', 'Email\SubscriberController@update');
 	Route::delete('subscriber/{id}', 'Email\SubscriberController@destroy');

 	//Email
 	Route::post('email', 'Email\EmailController@save');
 	Route::get('email/{id}', 'Email\EmailController@get');
 	Route::get('email', 'Email\EmailController@listing'); 	
 	Route::put('email/{id}', 'Email\EmailController@update');
 	Route::delete('email/{id}', 'Email\EmailController@destroy');

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
	Route::get('vehicle-brands', 'App\AdminController@showVehicleCat');	
	Route::get('system-users', 'App\AdminController@showSystemUser');
	Route::get('users', 'App\AdminController@showUser');
	Route::get('testimonial', 'App\AdminController@showTestimonial');	
	Route::get('radius', 'App\AdminController@showRadius');	
	Route::get('subscriber', 'App\AdminController@showSubscriber');
	Route::get('country', 'App\AdminController@showCountry');
	Route::get('language', 'App\AdminController@showLanguage');
	Route::get('currency', 'App\AdminController@showCurrency');

});


