<?php # /app/views/projects/show.blade.php  ?>
@extends('templates/hud_wide_master')

@section('content')


<div class="row">
	<div class="col-xs-12">
		<div class="app-wrapper app-wrapper-wide">        
            
            <div>
                <h2 class="pull-left no-margin-top">{{ $project->name }} <span class="total animated tada">{{ $total_weight }}</span></h2>
                <ul class="list-inline pull-right">
                	<!-- <li><button class="btn btn-default" onclick="openCreateNewTaskModule()">New Task <i class="fa fa-plus"></i></button></li> -->
                    <li><a class="btn btn-default" href="/projects/{{ $project->id }}/edit">Edit</a></li>
                </ul>
                <div class="clearfix"></div>   
            </div>

            <div class="row">            	            
	            <div class="col-xs-12 col-md-8">
				  	
				  	<!-- info pills -->
				  	<ul class="list-inline">
				  		@if ($project->production)
				  			<li><a class="pill pill-primary" target="_blank" href="{{ $project->production }}">Production</a></li>
				  		@endif
				  		@if ($project->stage)
				  			<li><a class="pill pill-primary" target="_blank" href="{{ $project->stage }}">Staging</a></li>
				  		@endif
				  		@if ($project->dev)
				  			<li><a class="pill pill-primary" target="_blank" href="{{ $project->dev }}">Development</a></li>
				  		@endif
				  		@if ($project->github)
				  			<li><a class="pill pill-dark" target="_blank" href="{{ $project->github }}">Github</a></li>
				  		@endif
				  	</ul><br>
				  	<!-- info pills -->

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
					  <li class="active"><a href="#tasks" role="tab" data-toggle="tab">Remaining Tasks <i class="fa fa-tasks"></i></a></li>
					  <li><a href="#manage" role="tab" data-toggle="tab">Completed Tasks <i class="fa fa-check"></i></a></li>
					  <li><a href="#credentials" role="tab" data-toggle="tab">Credentials <i class="fa fa-lock"></i></a></li>
					</ul>			  	

					<!-- Tab panes -->
					<div class="tab-content">
					  
					  <!-- REMAINING TASKS -->
					  <div class="tab-pane active" id="tasks">					  	
					  	<section class="info">
					  		@if ($taskCount == 0)
					  			<p>This project does not contain any remaining tasks.</p>
					  		@else
						  		<table class="table">
						  			<thead>
						  				<tr><th>Task</th><th>Weight</th><th>Actions</th></tr>			  				
						  				<tbody>
						  					@foreach ($tasks as $task)
				  							<?php
				  								if ($task->weight == 1) {
				  									$weight = "level-easy";
				  								}else if($task->weight == 2){
				  									$weight = "level-medium";
				  								}else if($task->weight == 3){
				  									$weight = "level-hard";
				  								}
				  							?>					  					
						  					<tr>
						  						<td>					  							
						  							{{ Form::open(array('action' => 'TasksController@update', 'method' => 'put')) }}
						  								<input type="checkbox" onClick="this.form.submit()" name="task" value="{{ $task->id }}" />  			
							  							{{ $task->name }}
							  							<input type="hidden" name="task" value="{{ $task->id }}">
						  							{{ Form::close() }}
						  						</td>
						  						<td><span class="level {{ $weight }}">{{ $task->weight }}</span></td>
						  						<td>
						  							<ul class="list-style-none inline-list">
						  								<li>
							  								{{ Form::open(array('action' => 'TasksController@destroy', 'method' => 'delete')) }}
							  								<input type="hidden" name="id" value="{{ $task->id }}">
							  								<input type="submit" class="btn btn-default" value="delete">
						  									{{ Form::close() }}					  									
						  								</li>
						  							</ul>						  							
						  						</td>
						  					</tr>
						  					@endforeach				  		
						  				</tbody>
						  			</thead>
						  		</table>
					  		@endif
					  	</section>
					  </div>

					  <!-- COMEPLETED TASKS -->
					  <div class="tab-pane" id="manage">
					  	<section class="info">
					  		@if ($completedCount == 0)
					  			<p>No tasks has been completed for this project.</p>
					  		@else
						  		<table class="table">
						  			<thead>
						  				<tr><th>Task</th><th>Weight</th><th>Actions</th></tr>			  				
						  				<tbody>
						  					@foreach ($completedTasks as $task)
				  							<?php
				  								if ($task->weight == 1) {
				  									$weight = "level-easy";
				  								}else if($task->weight == 2){
				  									$weight = "level-medium";
				  								}else if($task->weight == 3){
				  									$weight = "level-hard";
				  								}
				  							?>					  					
						  					<tr>
						  						<td>					  							
						  							{{ Form::open(array('action' => 'TasksController@update', 'method' => 'put')) }}
						  								<input checked="checked" type="checkbox" onClick="this.form.submit()" name="task" value="{{ $task->id }}" /> 
							  							{{ $task->name }}
							  							<input type="hidden" name="task" value="{{ $task->id }}">
						  							{{ Form::close() }}
						  						</td>
						  						<td><span class="level {{ $weight }}">{{ $task->weight }}</span></td>
						  						<td>
						  							<ul class="list-style-none inline-list">
						  								<li>
							  								{{ Form::open(array('action' => 'TasksController@destroy', 'method' => 'delete')) }}
							  								<input type="hidden" name="id" value="{{ $task->id }}">
							  								<input type="submit" value="delete">
						  									{{ Form::close() }}					  							
						  								</li>
						  							</ul>						  							
						  						</td>					  						
						  					</tr>
						  					@endforeach				  		
						  				</tbody>
						  			</thead>
						  		</table>
					  		@endif
					  	</section>					  	
					  </div>

					  <!-- CREDENTIALS -->
					  <div class="tab-pane" id="credentials">
					  	<p class="pull-right"></p>
					  	<div class="clearfix"></div>

					  	<!-- server panel -->
						<div class="panel panel-default">
						  <div class="panel-heading">FTP & SSH Accounts</div>
						  <div class="panel-body ftp-panel-body">					    			            	
							
							<div class="row">
								<div class="col-xs-12 col-md-4 no-padding-left no-padding-right dynamic-form">
	  								{{ Form::open(array('action' => 'CredentialsController@create', 'method' => 'get')) }}
						         		<input class="form-control" type="text" name="name" placeholder="Name" autofocus>					            		
						         		<input class="form-control" type="text" name="hostname" placeholder="Hostname">
						         		<input class="form-control" type="text" name="username" placeholder="Username">
						         		<input class="form-control" type="text" name="password" placeholder="Password">
						         		<input type="hidden" name="project_id" value="{{ $project->id }}">
						         		<input type="hidden" name="type" value="server"
						         		<br>
						         		<div class="col-xs-4 no-padding-left">
						         			<input class="form-control" type="text" name="port" placeholder="Port">
						         		</div>
						         		<div class="col-xs-8 no-padding-right">
							         		<button type="submit" class="btn btn-default">
								                <i class="fa fa-plus-square-o fa-lg"></i> Save
								            </button>
						         			<!-- <input class="btn btn-primary" type="submit" value="Save">	 -->
						         		</div>					         		
						         		
						         		<div class="clearfix"></div>
									{{ Form::close() }}					         	
						     	</div>	
					     	</div>

					     	<div class="row">
					     		<hr>
						     	@foreach ($credentials as $credential)
						     		@if ($credential->type == true)
							     		<div class="col-xs-12 col-md-4 credential-wrap" id="credential-wrap-{{ $credential->id }}">
							     			<h4>{{ $credential->name }}</h4	>
							     			<p><strong>Hostname:</strong> {{ $credential->hostname }}</p>
							     			<p><strong>Username:</strong> {{ $credential->username }}</p>
							     			<p><strong>Password:</strong> {{ $credential->password }}</p>
							     			<p><strong>Port:</strong> {{ $credential->port }}</p>
							     			<div class="actions">
							     				<ul class="inline-list list-style-none">
							     					<li>
								     				{{ Form::open(array('action' => 'CredentialsController@destroy', 'method' => 'delete')) }}
								     					<input type="hidden" name="id" value="{{ $credential->id }}">
								     					<button title="delete" id="{{ $credential->id }}" type="submit" class="btn btn-default btn-delete"><i class="fa fa-trash"></i></button>
								     				{{ Form::close() }}							     						
							     					</li>
							     					<li>
							     						<button title="edit" class="btn btn-default"><a href=""><i class="fa fa-pencil"></i></a></button>				
							     					</li>
							     					<div class="clearfix"></div>
							     				</ul>
							     			</div>
							     		</div>
						     		@endif
						     	@endforeach
					     	</div>
					     	
						  </div>	         	
			            </div>

					  	<!-- other panel -->
						<div class="panel panel-default">
						  <div class="panel-heading">Other Credentials</div>
						  <div class="panel-body other--panel-body">					    
			            	<button id="other" class="btn btn-default"><i class="fa fa-plus-square-o fa-lg"></i> new</button>
						  </div>	         	
			            </div>

					  </div>

					</div>
	            </div>

	            <div class="col-xs-12 col-md-4">
					<div class="panel panel-default">
					  <div class="panel-heading">Create new task</div>
					  <div class="panel-body">					    
		            	<i class="dimmed">For the weight, enter a number from 1-3, the higher the number the harder the task.</i>
		            	<div class="form-group">
		            		<form action="/tasks/create" method="get">
		            			<div class="row">		            				
		            				<div class="col-xs-10 no-padding-left">
				            			<label>Name</label>
				            			<input type="text" name="name" class="form-control" value="{{ Input::old('name') }}">		            				
			            			</div>
			            			<div class="col-xs-2 no-padding-right">
			            				<label>Weight</label>
			            				<div>
			            					<input placeholder="1" type="text" name="weight" class="form-control" value="{{ Input::old('weight') }}">
			            				</div>
			            			</div>
			            			<input type="hidden" name="projectId" value="{{ $project->id }}">
			            		</div>
		            			<div class="form-group">
		            				<br>
		            				<input type="submit" class="pull-right btn btn-success btn-wide" value="add task">	
		            			</div>		            					            			
		            		</form>
		            	</div>
					  </div>
					</div>	         	
	            </div>
	            
            </div>

            <div class="row">
            	<div class="col-xs-12">
                    <section>
                        <hr>
                        <strong>Note:</strong>
                        <p class="dimmed">Deleting <i>{{ $project->name }}</i> will delete all tasks associated with this project.</p>
                        {{ Form::open(array('action' => 'ProjectsController@destroy', 'method' => 'delete')) }}
                            <input type="hidden" name="id" value="{{ $project->id }}">
                            <input type="submit" class="btn btn-danger" value="Delete Project" />  
                        {{ Form::close() }}
                    </section>              		
            	</div>
            </div>

		</div>
	</div>
</div>

@stop()


