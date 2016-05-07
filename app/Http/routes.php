<?php
Route::get('/', 'HomeController@index');
Route::get('register', function(){ return View::make('register')->with('pTitle', "Register"); });
Route::get('signin', function(){ return View::make('signin')->with('pTitle', "Login"); });
Route::get('faq', function(){ return View::make('faq')->with('pTitle', "FAQ"); });

//----------------- User routes
Route::resource('users', 'UsersController', array('only' => array('show')));
Route::post('login', 'UsersController@login');
Route::post('make', 'UsersController@register');
Route::get('logout', 'UsersController@logout');
Route::post('resetPassword/{id}','UsersController@resetPassword');

//----------------- Auth routes
Route::group(array('before' => 'auth'), function()
{	
	Route::get('hud', 'HomeController@index');
	Route::get('search', 'HomeController@search');	
	Route::get('profile', 'UsersController@index');
	Route::get('clients', 'ClientsController@index');
	Route::delete('clients/{id}', 'ClientsController@destroy');
    Route::resource('projects', 'ProjectsController', array('only' => array('show')));

//    Route::post('projects/{id}/invite', array('uses' => 'ProjectsController@invite', 'as' => 'projects.invite' ));
//	Route::delete('projects/{id}/remove', array('uses' => 'ProjectsController@remove', 'as' => 'projects.remove') );
//    Route::get('projects/{id}/files', array('uses' => 'ProjectsController@files', 'as' => 'projects.files' ));
//    Route::post('projects/{id}/files', array('uses' => 'FilesController@store', 'as' => 'files.store' ));
//    Route::delete('projects/{id}/files', array('uses' => 'FilesController@destroy', 'as' => 'files.remove' ));
});

//----------------- API routes
Route::group(['prefix' => '/api/'], function()
{	
	// USER 
    Route::get('user', 'ApiController@getUser');
    Route::post('user/{id}', 'ApiController@updateUser');
	Route::delete('user/', 'ApiController@deleteUser');

	// CLIENT
	Route::get('clients/{withWeight?}', 'ClientsController@getAllUserClients');
	Route::put('clients/{id}', 'ClientsController@updateClient');
	Route::post('clients', 'ClientsController@storeClient');
	Route::delete('clients/{id}', 'ClientsController@removeClient');

	// PROJECT
    Route::get('projects/', 'ProjectsController@getAllUserProjects');
    Route::get('projects/{id}','ProjectsController@getProject');
	Route::post('projects', 'ProjectsController@storeProject');
    Route::put('projects/{id}', 'ProjectsController@updateProject');

	// TASK
    Route::get('tasks', 'TasksController@getAllUserOpenTasks');
    Route::post('tasks/{client_id}/{project_id}', 'TasksController@storeTask');
    Route::delete('tasks/{id}', 'TasksController@removeTask');
    Route::put('tasks/{id}', 'TasksController@updateTask');

	// CREDENTIALS
    Route::get('credentials/{id}','CredentialsController@getProjectCredentials');
    Route::post('credentials', 'CredentialsController@storeCredential');
    Route::put('credentials/{id}', 'CredentialsController@updateCredential');
    Route::delete('credentials/{id}', 'CredentialsController@removeCredential');
});

//----------------- Admin routes
