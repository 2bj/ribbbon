@extends('templates/ins/master')

@section('content')
	<div class="row">
		<div class="col-xs-12 page-title-section">
			<h1 class="pull-left">Clients</h1>
			<a onClick="showForm('.popup-form.new-client')" href="" class="btn btn-primary pull-right" title="Create new client">+ New Client</a>			
			<a onClick="showForm('.popup-form.new-project')" href="" class="btn btn-default pull-right" title="Create new project">New Project</a>			
			<div class="clearfix"></div>
		</div>
	</div>

<div id="client">
	<div class="row">
		<div class="col-xs-12">			
			
			<div class="mega-menu">			
				<div class="links">					
					<a v-for="client in clients" class="" data-id="client_@{{client.id}}" href="">
						@{{client.name}}
					</a>
				</div>
				<div class="content">
					<div v-for="client in clients" class="item" id="client_@{{client.id}}" title="Edit client">
						<header>
							<h2 class="pull-left">@{{client.name}}</h2>
							<p class="pull-right"><i class="ion-edit"></i></p>
							<div class="clearfix"></div>
							<p>@{{client.point_of_contact}}</p>
							<p>@{{client.phone_number}}</p>
							<p><a href="mailto:@{{client.email}}">@{{client.email}}</a></p>				
						</header>
						
						<div class="panel panel-default panel-list">
						  <div class="panel-heading">Projecs</div>
						  <div class="panel-body">
					  		<a v-for="project in client.projects" href="/projects/@{{ project.id }}">
					  			@{{ project.name }}
					  			<span class="weight pull-right">w.50</span>
					  		</a>
						    {{-- <section class="info">
								<i class="fa fa-lightbulb-o"></i>
								Your latest projects will show up here, you will need to create <a href="/clients">clients</a> in order to create projects.
						    </section> --}}
						  </div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="popup-form new-client">
		<header>
			<p class="pull-left">New Client</p>
			<div class="actions pull-right">
				<i title="Minimze "class="ion-minus-round"></i>
				<i title="Close" class="ion-close-round"></i>
			</div>
			<div class="clearfix"></div>
		</header>
		<section>
			<form>
				<span class="status-msg"></span>
				<input v-model="client.name" placeholder="Client Name" type="text" class="form-control">
				<input v-model="client.email" placeholder="Email" type="text" class="form-control">
				<input v-model="client.point_of_contact" placeholder="Point Of Contact" type="text" class="form-control">
				<input v-model="client.phone_number" placeholder="Contact Number" type="text"class="form-control">
			</form>
		</section>
		<footer>
			<a v-on:click="create(client,true)" href="" class="btn btn-primary pull-right">Save</a>
			<div class="clearfix"></div>
		</footer>
	</div>	
</div>


	<script src="{{ asset('assets/js/controllers/client.js') }}"></script>
@stop()