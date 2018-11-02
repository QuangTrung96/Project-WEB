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

Route::get('/', 'MainController@index')->name('index');

// Member
Route::group(['prefix' => 'member'], function() {
	Route::post('login', 'AuthController@postLogin')
	           ->name('login_post');
	Route::get('login', 'AuthController@getLogin')
	          ->name('login_get')
	          ->middleware('is_login');
	Route::get('logout', 'AuthController@getLogout')
	          ->name('logout_get')
	          ->middleware('check_user');
	Route::get('changepass', 'AuthController@getChangePass')
	          ->name('changepass_get')
	          ->middleware('check_user');
	Route::post('changepass', 'AuthController@postChangePass')
	           ->name('changepass_post');
	Route::get('forgot', 'AuthController@getForgot')
	          ->name('forgot_get')
	          ->middleware('is_login');
	Route::post('forgot', 'AuthController@postForgot')
	           ->name('forgot_post');
	Route::get('active/{username}/{code}', 'AuthController@getActiveReset')
	          ->name('active_reset_get')
	          ->middleware('is_login');
});
	          
Route::get('create_user', function() {
	$user = Sentinel::getUserRepository()->create([
		'username' => 'admin',
		'email'    => 'admin@gmail.com',
		'password' => '123456',
		'last_name' => 'Trịnh Công',
		'first_name' => 'Sơn',
		'permissions' => [
			'admin' => true
		]
	]);

	return "Done";
});

Route::get('create_user_active', function() {
	$userActive = Sentinel::registerAndActivate([
		'username' => 'huynq6953',
		'email'    => 'trinhquangtrung_t59@hus.edu.vn',
		'password' => '123456',
		'last_name' => 'Nguyễn Quang',
		'first_name' => 'Huy',
		'permissions' => [
			'admin' => true
		]
	]);

	return "Done";
});
