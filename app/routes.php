<?php

Route::get('/', function()
{
	if( Auth::check() ) {
		return View::make('/hud')->with('pTitle', "Your Hud");	
	}else{
		return View::make('index')->with('pTitle', "Project Management For System Artisans");
	}	
});

Route::get('register', function(){ return View::make('register')->with('pTitle', "Register"); });
Route::get('signin', function(){ return View::make('signin')->with('pTitle', "Login"); });
Route::get('beta', function(){ return View::make('beta')->with('pTitle', "Beta email request"); });
Route::get('about', function(){ return View::make('about')->with('pTitle', "About Ribbbon"); });
Route::get('faq', function(){ return View::make('faq')->with('pTitle', "FAQ"); });

//----------------- User routes
Route::resource('users', 'UsersController');
Route::post('login', 'UsersController@login');
Route::post('make', 'UsersController@register');
Route::get('logout', 'UsersController@logout');
Route::post('request', 'UsersController@request');
Route::post('resetPassword/{id}','UsersController@resetPassword');

//----------------- Admin routes
Route::group(array('before' => 'admin'), function()
{	
	Route::get('confirm','AdminController@confirm');
	Route::get('invite','AdminController@invite');
});

//----------------- Auth routes
Route::group(array('before' => 'auth'), function()
{	
	Route::resource('clients', 'ClientsController');
	Route::resource('projects', 'ProjectsController');
	Route::resource('credentials', 'CredentialsController');
	Route::resource('tasks', 'TasksController');
	
	Route::get('hud', array('as' => 'hud', function(){
		return View::make('hud')->with('pTitle', "Your Hud");
	}));

	Route::get('profile', 'UsersController@index');
});

// Route::get('mail',function(){			
// 	sendBetaFollowUpMail("jefrycruz88@gmail.com");
// 	return "mail sent";
// });