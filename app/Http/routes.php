<?php
Route::get('/', 'HomeController@index');
Route::get('register', function(){ return View::make('register')->with('pTitle', "Register"); });
Route::get('signin', function(){ return View::make('signin')->with('pTitle', "Login"); });
Route::get('about', 'HomeController@index');
Route::get('faq', function(){ return View::make('faq')->with('pTitle', "FAQ"); });

//----------------- User routes
Route::resource('users', 'UsersController', array('except' => array('create', 'store', 'show','edit','update')));
Route::post('login', 'UsersController@login');
Route::post('make', 'UsersController@register');
Route::get('logout', 'UsersController@logout');
Route::post('request', 'UsersController@request');
Route::post('resetPassword/{id}','UsersController@resetPassword');

//----------------- Auth routes
Route::group(array('before' => 'auth'), function()
{	
	Route::get('hud', 'HomeController@index');
	Route::get('search', 'HomeController@search');	
	Route::get('profile', 'UsersController@index');	

	Route::get('clients', 'ClientsController@index');
	Route::delete('clients/{id}', 'ClientsController@destroy');

	Route::resource('projects', 'ProjectsController', array('only' => array('index','show')));	
	Route::post('projects/{id}/invite', array('uses' => 'ProjectsController@invite', 'as' => 'projects.invite' ));
	Route::delete('projects/{id}/remove', array('uses' => 'ProjectsController@remove', 'as' => 'projects.remove') );
	Route::get('projects/{id}/credentials', array('uses' => 'ProjectsController@credentials', 'as' => 'projects.credentials' ));
    Route::get('projects/{id}/files', array('uses' => 'ProjectsController@files', 'as' => 'projects.files' ));
    Route::post('projects/{id}/files', array('uses' => 'FilesController@store', 'as' => 'files.store' ));
    Route::delete('projects/{id}/files', array('uses' => 'FilesController@destroy', 'as' => 'files.remove' ));

	Route::resource('credentials', 'CredentialsController', array('only' => array('create', 'destroy')));
});

//----------------- API routes
Route::group(['prefix' => '/api/'], function()
{	
	// USER 
	Route::get('{key}/authId', 'ApiController@authId');
    Route::get('user', 'ApiController@getUser');

	// CLIENT
	Route::get('clients/{withWeight?}', 'ApiController@getAllUserClients');
	Route::get('clients/{id}', 'ApiController@getClient');
	Route::put('clients/{id}', 'ApiController@updateClient');
	Route::post('clients', 'ApiController@storeClient');
	Route::delete('clients/{id}', 'ApiController@removeClient');

	// PROJECT
	Route::put('projects/{id}', 'ApiController@updateProject');
	Route::post('projects', 'ApiController@storeProject');

	// TASK
    Route::post('tasks', 'ApiController@storeTask');
    Route::delete('tasks/{id}', 'ApiController@removeTask');
    Route::put('tasks/{id}', 'ApiController@updateTask');

	// CREDENTIALS
    Route::get('credentials/{id}','ApiController@getProjectCredentials');
    Route::post('credentials', 'ApiController@storeCredential');
    Route::put('credentials/{id}', 'ApiController@updateCredential');
    Route::delete('credentials/{id}', 'ApiController@removeCredential');

});

//----------------- Admin routes
Route::group(array('before' => 'admin'), function()
{
    Route::get('invite','AdminController@invite');
});