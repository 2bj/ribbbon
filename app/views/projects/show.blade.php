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
		</div>
	</div>
</div>

@stop()


