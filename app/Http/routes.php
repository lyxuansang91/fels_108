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

    Route::get('/login', ['as'=>'admin.login.index', 'uses'=>'SessionController@index']);

    Route::post('/login', ['as'=>'admin.login.store', 'uses'=>'SessionController@store']);

    Route::get('/logout', ['as'=>'admin.logout.index', 'uses'=>'SessionController@destroy']);

    Route::group(['middleware' => 'auth.admin'], function () {
    
        Route::get('/', ['as'=>'index', 'uses'=>'HomeController@index']);

        Route::resource('/members', 'MemberController');
        
        Route::resource('/words', 'WordController');

        Route::resource('/categories', 'CategoryController');
    });
});