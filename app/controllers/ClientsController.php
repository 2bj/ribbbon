<?php

class ClientsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /clients
	 *
	 * @return Response
	 */
	public function index()
	{	
		$id 		= Auth::id();
		$user		= User::find($id);
		$clients 	= $user->clients()->get();

		$counter 	= 0;

		return View::make('clients.index')->with('clients', $clients)->with('counter', $counter);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /clients/create
	 *
	 * @return Response
	 */
	public function create()
	{
        $name 		= Input::get('name');
        $user_id 	= Auth::id();

        // Validation
        $validator = Validator::make(
            array('name' =>	$name),
            array('name' => 'required|unique:clients')
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $client         	= new Client;
        $client->name   	= $name;
        $client->user_id 	= $user_id;
        $client->save();


        return Redirect::back()->with('success', $name ." is now a new client.");
	}


	/**
	 * Store a newly created resource in storage.
	 * POST /clients
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$client 	= 	Client::find($id);
		$projects	=	$client->projects()->get();

		return View::make('clients.show')->with('client', $client)->with('projects', $projects);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /clients/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = Client::find($id);

		return View::make('clients.edit')->with('client',$client);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
       $name 				= 	Input::get('name');
       $point_of_contact	=	Input::get('point_of_contact');
       $phone_number		=	Input::get('phone_number');
       $email				=	Input::get('email');

       // Validation
        $validator = Validator::make(
            array(
            	'name' 				=>	$name,
            	'email'				=>	$email
            	),
            array(
            	'name' 				=> 'required',
            	'email'				=> 'email'
            	)
        );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $client = Client::find($id);

        $client->name 				= $name;
        $client->point_of_contact 	= $point_of_contact;
        $client->phone_number 		= $phone_number;
        $client->email 				= $email;
        $client->save();

        return Redirect::back()->with('success', $name ." has been updated.");

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}