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

// Scholastic
Route::group(['prefix' => 'scholastic', 'middleware' => 'check_access:admin'], function() {
	Route::get('list', 'ScholasticController@getList')
	          ->name('scholastic_list_get');
	Route::post('add', 'ScholasticController@postAdd')
	           ->name('scholastic_add_post');
	Route::post('edit', 'ScholasticController@postEdit')
	           ->name('scholastic_edit_post');
	Route::get('delete/{id}', 'ScholasticController@getDelete')
	          ->name('scholastic_delete_get')
	          ->where(['id' => '[0-9]+']);
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
		'username' => 'trungtq6985',
		'email'    => 'trinhquangtrung_t59@hus.edu.vn',
		'password' => '123456',
		'last_name' => 'Trịnh Quang',
		'first_name' => 'Trung',
		'permissions' => [
			'admin' => true
		]
	]);

	return "Done";
});
