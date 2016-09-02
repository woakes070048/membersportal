@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 left_home">
		<div class="home_panel">
			<h3 class="text-center">Navigation</h3>
			<a href="{{ action('UsersController@editUsers') }}" alt="Manage User">Manage Users</a>
			<a href="{{ action('UsersController@create') }}" alt="Create User">Create User</a>
			<a href="{{ action('CarouselsController@create') }}" alt="Add Carousel">Add Carousel</a>
			
			<a href="{{ action('EventsController@create') }}" alt="Add Event">Add Event</a>
					
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 center_home">
		<div class="home_panel">
			<h3 class="text-center">Manage Users</h3>
			<div>
				<form class="navbar-form navbar-left">
					<div class="form-group">
		 				<input type="text" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
	  			</form>
			</div>
		</div>
	</div>
</div>

@stop