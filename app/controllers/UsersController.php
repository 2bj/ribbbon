<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = User::find(Auth::id());
		$created = $user->tasks_created;
		$completed = $user->tasks_completed;

		if ($created == "") {
			$created = 0;
		}

		if ($completed == "") {
			$completed = 0;
		}
		return View::make('users.index')->with('user', $user)->with('created', $created)->with('completed', $completed);			
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}	

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Delete everything related to the user
		Task::where('user_id', Auth::id())->delete(); 
		Project::where('user_id', Auth::id())->delete();
		Client::where('user_id', Auth::id())->delete();		
		User::where('id', Auth::id())->delete();

		// Logout and redirect back to home page
		Auth::logout();
		return Redirect::to('/');
	}

	/**
	 * Logout the user from the application
	 */	
	public function logout(){
		Auth::logout();
		return Redirect::to('/');
	}

	/**
	 * Login the user and start a session
	 */
	public function login()
	{				
		$email 		=	Input::get('email');
		$password	=	Input::get('password');


		// lets validate the users input
		$validator = Validator::make(
			array(
					'email' 	=>	$email,
					'password' 	=> 	$password
			),
			array(
					'email'		=> 	'required|email',
					'password'	=>	'required'
			)
		);

		if ($validator->fails()){
		    return Redirect::back()->withErrors($validator)->withInput();
		}else{
			if( Auth::attempt(array('email' => $email, 'password' => $password)) ){				
				return Redirect::to('hud');
			}else{				
				$validator->getMessageBag()->add('input', 'Incorrect email or password');
				return Redirect::back()->withErrors($validator);
			}			
		}
	}	

	/**
	 * Register the user and start a session
	 */
	public function register()
	{	
		$fullName	=	Input::get('fullName');
		$email 		=	Input::get('email');
		$password	=	Input::get('password');	

		// lets validate the users input
		$validator = Validator::make(
			array(
					'fullName' 	=> 	$fullName,
					'email' 	=>	$email,
					'password' 	=> 	$password
			),
			array(
					'fullName' 	=> 	'required',
					'email'		=> 	'required|email|unique:users',
					'password'	=>	'required|min:8'
			)
		);

		if ($validator->fails()){
		    return Redirect::back()->withErrors($validator)->withInput();
		}

		$user 				=	new User;
		$user->full_name 	=	$fullName;
		$user->email 		=	$email;
		$user->password 	=	Hash::make($password);

		$user->save();	

		if ( Auth::attempt(array('email' => $email, 'password' => $password)) ) {
			sendWelcomeMail();
			return Redirect::to('hud');
		}else{
			return Redirect::back()->withErrors($validator);			
		}
	}	

	public function resetPassword($id)
	{		
		// ----------------------------------------
		$user = User::find(Auth::id());
		$created = $user->tasks_created;
		$completed = $user->tasks_completed;

		if ($created == "") {
			$created = 0;
		}

		if ($completed == "") {
			$completed = 0;
		}
		// ----------------------------------------


		$current_pwd	=	Input::get('current_pwd');
		$new_pwd		=	Input::get('new_pwd');


		// lets validate the users input
		$validator = Validator::make(
			array(
					'current_pwd' 	=>	$current_pwd,
					'new_pwd' 		=> 	$new_pwd
			),
			array(
					'current_pwd'	=> 	'required',
					'new_pwd'		=>	'required'
			)
		);

		if ($validator->fails()){
		    return Redirect::back()->withErrors($validator)->with('user', $user)->with('created', $created)->with('completed', $completed);
		}

		if ( !Auth::validate(array('email' => $user->email, 'password' => $current_pwd)) ) {
			$validator->getMessageBag()->add('password', 'That password is incorrect');
			return Redirect::back()->withErrors($validator)->with('user', $user)->with('created', $created)->with('completed', $completed);	
		}

		// Store the new password and redirect;
		$user->password = Hash::make($new_pwd);
		$user->save();

		return Redirect::back()
								->with('user', $user)
								->with('created', $created)->with('completed', $completed)
								->with('success', "Your password has been updated!");

	}

	/**
	 * Request for a beta invite
	 */
	public function request(){
		// lets validate the email
		$validator = Validator::make(
			array( 'email' 		=>	Input::get('email'), ),
			array( 'email'	=> 	'required|email|unique:beta' )
		);		

		if ($validator->fails()){
		    return Redirect::back()->withErrors($validator)->withInput();
		}		

		$beta_user 			= new Beta;
		$beta_user->email 	= Input::get('email');
		$beta_user->status 	= false;
		$beta_user->save(); 

		return Redirect::back()->with('success', "Your all set, your invitation will will arive soon.");
	}

}