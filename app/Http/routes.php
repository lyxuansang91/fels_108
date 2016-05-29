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

        Route::resource('/grades', 'GradeController');

        Route::resource('/semesters', 'SemesterController');

        Route::resource('/subjects', 'SubjectController');

        Route::resource('/groups', 'GroupController');

        Route::resource('/levels', 'LevelController');
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
