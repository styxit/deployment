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
Route::get('logout', 'AuthController@logout');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');

    Route::get('deployments', 'DeploymentController@index');
    Route::get('deployments/{repositoryLogin}/{repositoryName}/{deploymentId}', 'DeploymentController@show');

    Route::get('repositories', 'RepositoryController@index');
    Route::get('repositories/organization/{id}', 'RepositoryController@organization');
    Route::get('repositories/{repositoryLogin}/{repositoryName}', 'RepositoryController@show');
});

Route::get('/', function () {
    return view('welcome');
});
