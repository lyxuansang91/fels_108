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

Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {

    Route::get('/login', ['as' => 'admin.login.index', 'uses' => 'SessionController@index']);

    Route::post('/login', ['as' => 'admin.login.store', 'uses' => 'SessionController@store']);

    Route::get('/logout', ['as' => 'admin.logout.index', 'uses' => 'SessionController@destroy']);

    Route::group(['middleware' => 'auth.admin'], function () {

        Route::get('/', ['as' => 'admin.index', 'uses' => 'HomeController@index']);

        Route::resource('/members', 'MemberController');

        Route::resource('/words', 'WordController');

        Route::resource('/categories', 'CategoryController');

        Route::resource('/grades', 'GradeController'); //resource, đủ 7 chức năng thêm mới, sửa, xóa, hiển thị 1, hiển thị nhiều, ...

        Route::resource('/semesters', 'SemesterController');

        Route::resource('/subjects', 'SubjectController');

        Route::resource('/groups', 'GroupController');

        Route::resource('/levels', 'LevelController');

        Route::resource('/conducts', 'ConductController');

        Route::post('students/importExcel', ['as' => 'students.importExcel', 'uses' => 'StudentController@importExcel']);
        Route::get('students/exportExcel', ['as' => 'students.exportExcel', 'uses'=> 'StudentController@exportExcel']);
        Route::get('students/upgradeStudent', ['as' => 'students.upgradeStudent', 'uses'=> 'StudentController@upgradeStudent']);

        Route::resource('/students', 'StudentController');

        Route::post('teachers/importExcel', ['as' => 'teachers.importExcel', 'uses' => 'TeacherController@importExcel']);
        Route::get('teachers/exportExcel', ['as' => 'teachers.exportExcel', 'uses'=> 'TeacherController@exportExcel']);

        Route::resource('/teachers', 'TeacherController');

        Route::resource('/messages', 'MessageController');


        Route::post('points/updatePoint', ['as'=>'points.updatePoint', 'uses'=>'PointController@updatePoint']);
        Route::post('conducts/updateConduct', ['as'=>'conducts.updateConduct', 'uses'=>'ConductController@updateConduct']);
        Route::post('points/calculatePoint', ['as'=>'points.calculatePoint', 'uses'=>'PointController@calculatePoint']);
        Route::post('points/importExcel', ['as' => 'points.importExcel', 'uses' => 'PointController@importExcel']);
        Route::get('points/exportExcel', ['as' => 'points.exportExcel', 'uses'=> 'PointController@exportExcel']);
        Route::get('semester_classes/calculate', ['as' => 'admin.semester_classes.calculate', 'uses'=> 'SemesterClassController@calculate']);
        Route::resource('/points', 'PointController');


        Route::get('/teacher_subjects', ['as' => 'admin.teacher_subjects', 'uses' => 'TeacherSubjectController@index']);
        Route::post('/teacher_subjects/calculate', ['as' => 'admin.teacher_subjects.calculate', 'uses' => 'TeacherSubjectController@calculate']);
        Route::get('/semester_classes', ['as' => 'admin.semester_classes', 'uses' => 'SemesterClassController@index']);
        Route::get('/year_classes', ['as' => 'admin.year_classes', 'uses' => 'YearClassController@index']);


        Route::resource('/absences', 'AbsenceController');

    });
});

Route::group(['prefix' => 'user', 'namespace' => 'User'], function() {

    Route::get('/profiles/create', ['as' => 'user.profiles.create', 'uses' => 'UserController@create']);

    Route::post('/profiles', ['as' => 'user.profiles.store', 'uses' => 'UserController@store']);

    Route::get('/login', ['as' => 'user.login.index', 'uses' => 'SessionController@index']);

    Route::post('/login', ['as' => 'user.login.store', 'uses' => 'SessionController@store']);

    Route::get('/logout', ['as' => 'user.logout.index', 'uses' => 'SessionController@destroy']);

    Route::group(['middleware' => 'auth.user'], function () {

        Route::get('/', ['as' => 'user.index', 'uses' => 'HomeController@index']);

        Route::get('/profiles', ['as' => 'user.profiles.index', 'uses' => 'UserController@index']);

        Route::get('/profiles/{id}', ['as' => 'user.profiles.show', 'uses' => 'UserController@show']);

        Route::get('/profiles/{id}/edit', ['as' => 'user.profiles.edit', 'uses' => 'UserController@edit']);

        Route::put('/profiles/{id}', ['as' => 'user.profiles.update', 'uses' => 'UserController@update']);

        Route::get('/follows/{id}', ['as' => 'user.follows.show', 'uses' => 'FollowController@show']);

        Route::post('/follows', ['as' => 'user.follows.store', 'uses' => 'FollowController@store']);

        Route::delete('/follows/{id}', ['as' => 'user.follows.destroy', 'uses' => 'FollowController@destroy']);

        Route::resource('/words', 'WordController');

        Route::get('/categories', ['as' => 'user.categories.index', 'uses' => 'CategoryController@index']);

        Route::resource('/lessons', 'LessonController');

        Route::get('/results/{id}', ['as' => 'user.results.show', 'uses' => 'ResultController@show']);

        Route::put('/passwords/{id}', ['as' => 'user.passwords.update', 'uses' => 'PasswordController@update']);

        Route::get('/learned-words/{id}', ['as' => 'user.learned-words.show', 'uses' => 'LearnedWordController@show']);

        Route::post('/learned-words', ['as' => 'user.learned-words.store', 'uses' => 'LearnedWordController@store']);

        Route::get('/list', ['as' => 'user.list.index', 'uses' => 'UserController@index']);
    });
});
