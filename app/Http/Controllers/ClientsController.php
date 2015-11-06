<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Client;
use App\Project;
use App\Task;
use App\Credential;

class ClientsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /clients
	 *
	 * @return Response
	 */
	public function index()
	{	
		$pTitle		= "Clients";

		$id 		= Auth::id();
		$user		= User::find($id);
		$clients 	= $user->clients()->orderBy('created_at', 'desc')->take(5)->get();

		$counter 	= 0;		
		return View::make('clients.index', compact([ 'clients', 'counter', 'pTitle']));
	}

	// Get all clients for the logged in user
	public function getAllUserClients(){
		$clients = Client::where('user_id',Auth::id())->get();
		
		if (count($clients) === 0) {			
			return Response::json([
				'status' => 'error',
				'message' => 'No clients found'
			],404);
		}

		return Response::json([
				'status' => 'success',
				'message' => 'Clients retrived successfully',
				'data' => $clients->toArray()
			],200);
	}

	// create a new client
	public function store(){		
		if (!Input::all()) {
			return Response::json([
				'status' => 'error',
				'message' => 'No information provided to create client'
			],406);			
		}

		Input::merge(array('user_id' => Auth::id()));
		Client::create(Input::all());			
		$id = \DB::getPdo()->lastInsertId();

	    return Response::json([
			'status' => 'success',
			'message' => 'Client created successfully',
			'data' => Client::find($id)
		],200);			
	}

	// get a specific client 
	public function getClient($id){
		if (!Client::find($id)) {
			return Response::json([
				'status' => 'error',
				'message' => 'The client was not found'
			],404);			
		}
	    return Response::json([
			'status' => 'success',
			'message' => 'Client was successfully found',
			'data' => Client::find($id)
		],200);		
	}
	
	/**
	 * Show the form for creating a new resource.
	 * GET /clients/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$pTitle		= "Clients";

        $name 		= Input::get('name');
        $user_id 	= Auth::id();

        // Validation
        $validator = Validator::make(
            array('name' =>	$name),
            array('name' => 'required')
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
	 * Display the specified resource.
	 * GET /clients/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{		
		$client_id  =   $id;
		$client 	= 	Client::find($id);

		// TODO: refactor as provider
		if($client == null) {
			return Redirect::to('/hud');
		}

		// TODO: refactor as provider
		if ( $client->user_id != Auth::id() ) {
			return Redirect::to('/hud');
		}

		$projects	=	$client->projects()->get();

		$pTitle		=   $client->name;

		return View::make('clients.show', compact([ 'client', 'projects', 'client_id', 'pTitle' ]));
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
		$client 	= 	Client::find($id);
		$pTitle		=   "Edit " . $client->name;

		return View::make('clients.edit', compact([ 'client', 'pTitle' ]));
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
		$pTitle		= "Clients";

		$c_id 		= 	Input::get('id');
		$client 	= 	Client::find($c_id);

		// delete all related tasks and credentials
		foreach ($client->projects as $p) {
					Task::where('project_id', $p->id)->delete();
					Credential::where('project_id', $p->id)->delete();
					$p->members()->detach();
				}		
		
		// delete related projects
		Project::where("client_id", $c_id)->delete(); 
		
		// delete client
		$client->delete();
			
		// ----------------------------------------------------	
		$user		= User::find(Auth::id());
		$clients 	= $user->clients()->orderBy('created_at', 'desc')->get();
		$counter 	= 0;

		return View::make('clients.index', compact([ 'clients','counter','pTitle' ]));
	}

}