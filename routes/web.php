<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('auth/github', 'AuthController@redirectToProvider');
Route::get('auth/github/callback', 'AuthController@handleProviderCallback');

Route::group(['middleware' => 'auth'], function () {
    Route::get('deployments', 'DeploymentController@index');
    
    Route::get('repositories', 'RepositoryController@index');
    Route::get('repositories/organization/{id}', 'RepositoryController@organization');
});

Route::get('/', function () {
    return view('welcome');
});
