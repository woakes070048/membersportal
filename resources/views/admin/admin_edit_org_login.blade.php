@extends('layouts.master')

@section('content')

<div class="container">
	<h1 class="req">Edit Login Information</h1>
	<p class="text-center req"><span class="required">*</span> Required Field</p>
	<div class="row">
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xl-offset-1 edit_nav">
			@include('partials.admin_dash_nav', ['home' => '', 'login' => 'active', 'contact' => '', 'articles' => '', 'carousels' => '', 'events' => '', 'rfps' => '', 'users' => ''] )
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<div class="panel_form">
				<form method="POST" action="{{ action('AdminController@updateOrgLogin', ['id' => Auth::user()->id]) }}">
					{!! csrf_field() !!}
					{{ method_field('PUT') }}
					@include('partials.admin_edit_login_form')
					<button class="btn btn-primary pull-right" type="submit">Save</button>
					<a class="cancel_button pull-right" href="{{ action('AdminController@index') }}" alt="cancel">Cancel</a>
				</form>
			</div>
		</div>
	</div>
</div>

@stop
