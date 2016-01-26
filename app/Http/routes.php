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
    });
});

Route::group(['prefix' => 'user', 'namespace' => 'User'], function() {
    
    Route::get('/profiles/create', ['as' => 'user.profile.create', 'UserController@create']);

    Route::post('/profiles', ['as' => 'user.profile.store', 'UserController@store']);

    Route::get('/login', ['as' => 'user.login.index', 'uses' => 'SessionController@index']);

    Route::post('/login', ['as' => 'user.login.store', 'uses' => 'SessionController@store']);

    Route::get('/logout', ['as' => 'user.logout.index', 'uses' => 'SessionController@destroy']);

    Route::group(['middleware' => 'auth.user'], function () {

        Route::get('/', ['as' => 'user.index', 'uses' => 'HomeController@index']);

        Route::get('/profiles', ['as' => 'user.profile.index', 'uses' => 'UserController@index']);

        Route::get('/profiles/{id}', ['as' => 'user.profile.show', 'uses' => 'UserController@show']);

        Route::get('/profiles/{id}/edit', ['as' => 'user.profile.edit', 'uses' => 'UserController@edit']);

        Route::put('/profiles/{id}', ['as' => 'user.profile.update', 'uses' => 'UserController@update']);

        Route::put('/follows/{id}', ['as' => 'user.follow.update', 'uses' => 'FollowController@update']);

        Route::delete('/follows/{id}', ['as' => 'user.follow.destroy', 'uses' => 'FollowController@destroy']);

        Route::resource('/words', 'WordController');

        Route::get('/categories', ['as' => 'user.categories.index', 'uses' => 'CategoryController@index']);

        Route::resource('/lessons', 'LessonController');
    });
});