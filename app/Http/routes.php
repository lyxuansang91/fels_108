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

Route::group(['prefix' => 'admin'], function () {
	
    Route::get('/', ['as'=>'index', 'uses'=>'HomeController@index']);

    Route::get('/members/create', ['as'=>'member.create', 'uses'=>'MemberController@create']);

    Route::post('/members/create', ['as'=>'member.store', 'uses'=>'MemberController@store']);

    Route::get('/members/list', ['as'=>'member.index', 'uses'=>'MemberController@index']);
});