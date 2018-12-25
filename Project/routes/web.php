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

Route::group(['middleware'=>'web'], function() {
    Route::get('/', [
        'as' => 'index',
        'uses' => 'MainController@index'
    ]);

    // Member
    Route::group([
        'prefix' => 'member'
    ], function() {
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
});

Route::group(['middlewareGroups' => ['web'], 'middleware' => ['check_user', 'hasAccess', 'inRole']], function () 
{ 
	// Scholastic
    Route::group([
        'prefix' => 'scholastic',
        'as' => 'scholastic_'
    ], function () { 
    	Route::get('/', [
            'hasAccess' => ['scholastic_view'],
            'uses' => 'ScholasticController@getList'
        ]);
        Route::get('list', [
            'as' => 'list_get',
            'hasAccess' => ['scholastic_view'],
            'uses' => 'ScholasticController@getList'
        ]);
        Route::post('add', [
            'as' => 'add_post',
            'hasAccess' => ['scholastic_add'],
            'uses' => 'ScholasticController@postAdd'
        ]);
        Route::post('edit', [
            'as' => 'edit_post',
            'hasAccess' => ['scholastic_edit'],
            'uses' => 'ScholasticController@postEdit'
        ]);
        Route::get('delete/{id}', [
            'as' => 'delete_get',
            'hasAccess' => ['scholastic_delete'],
            'uses' => 'ScholasticController@getDelete',
            'where' => ['id' => '[0-9]+']
        ]);
    });

    // Semester
    Route::group([
        'prefix' => 'semester',
        'as' => 'semester_'
    ], function () { 
    	Route::get('/', [
            'hasAccess' => ['semester_view'],
            'uses' => 'SemesterController@getList'
        ]);
        Route::get('list', [
            'as' => 'list_get',
            'hasAccess' => ['semester_view'],
            'uses' => 'SemesterController@getList'
        ]);
        Route::post('add', [
            'as' => 'add_post',
            'hasAccess' => ['semester_add'],
            'uses' => 'SemesterController@postAdd'
        ]);
        Route::post('edit', [
            'as' => 'edit_post',
            'hasAccess' => ['semester_edit'],
            'uses' => 'SemesterController@postEdit'
        ]);
        Route::get('delete/{id}', [
            'as' => 'delete_get',
            'hasAccess' => ['semester_delete'],
            'uses' => 'SemesterController@getDelete',
            'where' => ['id' => '[0-9]+']
        ]);
    });

    // Subject
    Route::group([
        'prefix' => 'subject',
        'as' => 'subject_'
    ], function () { 
    	Route::get('/', [
            'hasAccess' => ['subject_view'],
            'uses' => 'SubjectController@getList'
        ]);
        Route::get('list', [
            'as' => 'list_get',
            'hasAccess' => ['subject_view'],
            'uses' => 'SubjectController@getList'
        ]);
        Route::post('add', [
            'as' => 'add_post',
            'hasAccess' => ['subject_add'],
            'uses' => 'SubjectController@postAdd'
        ]);
        Route::post('edit', [
            'as' => 'edit_post',
            'hasAccess' => ['subject_edit'],
            'uses' => 'SubjectController@postEdit'
        ]);
        Route::get('delete/{id}', [
            'as' => 'delete_get',
            'hasAccess' => ['subject_delete'],
            'uses' => 'SubjectController@getDelete',
            'where' => ['id' => '[0-9]+']
        ]);
    });

    // Point
    Route::group([
        'prefix' => 'point',
        'as' => 'point.'
    ], function () { 
    	Route::get('/', [
            'hasAccess' => ['point_view'],
            'uses' => 'PointController@index'
        ]);
        Route::get('index', [
            'as' => 'index',
            'hasAccess' => ['point_view'],
            'uses' => 'PointController@index'
        ]);
        Route::get('add', [
            'as' => 'create',
            'hasAccess' => ['point_add'],
            'uses' => 'PointController@create'
        ]);
        Route::post('add', [
            'as' => 'store',
            'hasAccess' => ['point_add'],
            'uses' => 'PointController@store'
        ]);
        Route::get('edit/{id}', [
            'as' => 'show',
            'hasAccess' => ['point_edit'],
            'uses' => 'PointController@show',
            'where' => ['id' => '[0-9]+']
        ]);
        Route::put('edit/{id}', [
            'as' => 'update',
            'hasAccess' => ['point_edit'],
            'uses' => 'PointController@update',
            'where' => ['id' => '[0-9]+']
        ]);
        Route::delete('delete/{id}', [
            'as' => 'delete',
            'hasAccess' => ['point_delete'],
            'uses' => 'PointController@delete',
            'where' => ['id' => '[0-9]+']
        ]);
    });

    // Student
    Route::group([
        'prefix' => 'student',
        'as' => 'student.'
    ], function () { 
    	Route::get('/', [
            'hasAccess' => ['student_view'],
            'uses' => 'StudentController@index'
        ]);
        Route::get('index', [
            'as' => 'index',
            'hasAccess' => ['student_view'],
            'uses' => 'StudentController@index'
        ]);
        Route::get('add', [
            'as' => 'create',
            'hasAccess' => ['student_add'],
            'uses' => 'StudentController@create'
        ]);
        Route::post('add', [
            'as' => 'store',
            'hasAccess' => ['student_add'],
            'uses' => 'StudentController@store'
        ]);
        Route::get('edit/{id}', [
            'as' => 'show',
            'hasAccess' => ['student_edit'],
            'uses' => 'StudentController@show',
            'where' => ['id' => '[0-9]+']
        ]);
        Route::put('edit/{id}', [
            'as' => 'update',
            'hasAccess' => ['student_edit'],
            'uses' => 'StudentController@update',
            'where' => ['id' => '[0-9]+']
        ]);
        Route::delete('delete/{id}', [
            'as' => 'delete',
            'hasAccess' => ['student_delete'],
            'uses' => 'StudentController@delete',
            'where' => ['id' => '[0-9]+']
        ]);
        Route::get('detail/{id}', [
            'as' => 'detail',
            'hasAccess' => ['student_detail'],
            'uses' => 'StudentController@detail',
            'where' => ['id' => '[0-9]+']
        ]);
    });
});

Route::get('create_user_not_active', function() {
	$user = Sentinel::getUserRepository()->create([
		'username' => 'admin',
		'email'    => 'admin@gmail.com',
		'password' => '123456',
		'last_name' => 'Trịnh Công',
		'first_name' => 'Sơn',
        'permissions' => [
            "student_view" => true,
            "student_detail" => true
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
		    "scholastic_view" => true,
            "scholastic_add" => true,
            "scholastic_edit" => true,
            "scholastic_delete" => true,
            "semester_view" => true,
            "semester_add" => true,
            "semester_edit" => true,
            "semester_delete" => true,
            "subject_view" => true,
            "subject_add" => true,
            "subject_edit" => true,
            "subject_delete" => true,
            "point_view" => true,
            "point_add" => true,
            "point_edit" => true,
            "point_delete" => true,
            "student_view" => true,
            "student_add" => true,
            "student_edit" => true,
            "student_delete" => true,
            "student_detail" => true
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
            "student_view" => true,
            "student_detail" => true
		]
	]);

	return "Done";
});

Route::any('{query}', function() {
    return view('welcome')->with('title', 'Không tìm thấy đường dẫn này !');
})->where('query', '.*');