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
	Route::get('/', 'ScholasticController@getList');
	Route::get('list', 'ScholasticController@getList')
	          ->name('scholastic_list_get');
	Route::post('add', 'ScholasticController@postAdd')
	           ->name('scholastic_add_post');
	Route::post('edit', 'ScholasticController@postEdit')
	           ->name('scholastic_edit_post');
	Route::get('delete/{id}', 'ScholasticController@getDelete')
	          ->where(['id' => '[0-9]+'])
	          ->name('scholastic_delete_get');
});

// Semester
Route::group(['prefix' => 'semester', 'middleware' => 'check_access:admin'], function() {
	Route::get('/', 'SemesterController@getList');
	Route::get('list', 'SemesterController@getList')
	          ->name('semester_list_get');
	Route::post('add', 'SemesterController@postAdd')
	           ->name('semester_add_post');
	Route::post('edit', 'SemesterController@postEdit')
	           ->name('semester_edit_post');
	Route::get('delete/{id}', 'SemesterController@getDelete')
	          ->where(['id' => '[0-9]+'])
	          ->name('semester_delete_get');
});

// Subject
Route::group(['prefix' => 'subject', 'middleware' => 'check_access:admin'], function() {
	Route::get('/', 'SubjectController@getList');
	Route::get('list', 'SubjectController@getList')
	          ->name('subject_list_get');
	Route::post('add', 'SubjectController@postAdd')
	           ->name('subject_add_post');
	Route::post('edit', 'SubjectController@postEdit')
	           ->name('subject_edit_post');
	Route::get('delete/{id}', 'SubjectController@getDelete')
	          ->where(['id' => '[0-9]+'])
	          ->name('subject_delete_get');
});

// Point
Route::group(['prefix' => 'point', 'middleware' => 'check_access:admin'], function() {
	Route::get('/', 'PointController@index');
	Route::get('index', 'PointController@index')
	          ->name('point.index');
	Route::get('add', 'PointController@create')
	           ->name('point.create');
	Route::post('add', 'PointController@store')
	           ->name('point.store');
	Route::get('/edit/{id}', 'PointController@show')
	          ->where(['id' => '[0-9]+'])
	          ->name('point.show');
    Route::put('/edit/{id}', 'PointController@update')
              ->name('point.update');
	Route::delete('delete/{id}', 'PointController@delete')
	             ->where(['id' => '[0-9]+'])
	             ->name('point.delete');
});

// Student
Route::group(['prefix' => 'student', 'middleware' => 'check_access:admin'], function() {
	Route::get('/', 'StudentController@index');
	Route::get('index', 'StudentController@index')
	          ->name('student.index');
	Route::get('add', 'StudentController@create')
	           ->name('student.create');
	Route::post('add', 'StudentController@store')
	           ->name('student.store');
	Route::get('/edit/{id}', 'StudentController@show')
	          ->where(['id' => '[0-9]+'])
	          ->name('student.show');
    Route::put('/edit/{id}', 'StudentController@update')
              ->name('student.update');
	Route::delete('delete/{id}', 'StudentController@delete')
	             ->where(['id' => '[0-9]+'])
	             ->name('student.delete');
	Route::get('/detail/{id}', 'StudentController@detail')
	          ->where(['id' => '[0-9]+'])
	          ->name('student.detail');
});
	          
Route::get('create_user_not_active', function() {
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

Route::get('create_user', function() {
	$userActive = Sentinel::registerAndActivate([
		'username' => 'huynq6953',
		'email'    => 'trinhquangtrung1b@gmail.com',
		'password' => '123456',
		'last_name' => 'Nguyễn Quang',
		'first_name' => 'Huy',
		'permissions' => [

		]
	]);

	return "Done";
});
