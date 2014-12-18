@extends('templates.master')


@section('content')

	<div class="row main-row">
		<div class="col-xs-12">
			<div class="app-wrapper">
				<div class="row animated fadeIn">
					<div class="col-xs-4">						
						<a href="/clients" class="card">
							<center><i class="fa fa-book fa-3x"></i></center>
							<center>Clients</center>
						</a>
					</div>
					<div class="col-xs-4">
						<a href="/projects" class="card">
							<center><i class="fa fa-hdd-o fa-3x"></i></center>
							<center>Projects</center>
						</a>
					</div>
					<div class="col-xs-4">
						<a href="/profile" class="card">
							<center><i class="fa fa-user fa-3x"></i></center>
							<center>Account</center>
						</a>
					</div>
				</div>
			</div>
		</div>	
	</div>

	<div class="row hud-margin">
		<!-- Latest tasks -->
		<div class="col-xs-12 col-md-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Latest Tasks <span class="dot pull-right"></span></h3>
			  </div>
			  <div class="panel-body">

			  	@if (count($latestTasks) > 0)
				  	@foreach ($latestTasks as $task)
				  		<p>
				  			<a href="/projects/{{ $task->project_id }}">{{ $task->name }}</a> 
				  			<span class="level pull-right">{{ $task->weight}}</span>
				  			<span class="pull-right dimmed">{{ $task->updated_at->toFormattedDateString() }} <i class="fa fa-clock-o"></i></span>
				  		</p>
				  	@endforeach			  			  	
				@else
					<div class="alert alert-info" role="alert">
						<i class="fa fa-lightbulb-o"></i> 
						Once you start creating tasks for projects, your latest ones will show up here.
					</div> 
			  	@endif		  
			  </div>
			</div>			
		</div>

		<!-- Latest projects -->
		<div class="col-xs-12 col-md-6">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Latest Projects <span class="dot pull-right"></span></h3>
			  </div>
			  <div class="panel-body">
			  	@if ( count($latestProjects) > 0)
				  	@foreach ($latestProjects as $project)
				  		<p>
							<a href="/projects/{{ $project->id }}">{{ $project->name }}</a>
				  			<span class="pull-right dimmed">{{ $project->updated_at->toFormattedDateString() }} <i class="fa fa-clock-o"></i></span>		  			
				  		</p>				  		
				  	@endforeach			  			  	
				@else
					<div class="alert alert-info" role="alert">
						<i class="fa fa-lightbulb-o"></i> 
						Your latest projects will show up here, you will need to create <a href="/clients">clients</a> in order to create projects.
					</div> 
			  	@endif
			  </div>
			</div>			
		</div>
	</div>

@stop()