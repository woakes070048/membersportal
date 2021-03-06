@extends('layouts.master')

@section('content')
<div class="container">

	<div class="image_container">
		<div class="company_header_img">
			@if ($company->header_img)
			<img class="company_header" src="{{ '/img/uploads/headers/' . $company->header_img }}" alt="{{ $company->name }}">
			@else
			<img class="company_header" src="/img/uploads/headers/header_photo_template.jpg" alt="{{ $company->name }}">
			@endif
		</div>
		<div class="company_profile_img">
			@if ($company->profile_img)
			<img class="company_profile img-thumbnail" src="{{ '/img/uploads/avatars/' . $company->profile_img }}" alt="{{ $company->name }}">
			@else
			<img class="company_profile img-thumbnail" src="/img/uploads/avatars/profile_photo_template.png" alt="{{ $company->name }}">
			@endif
		</div></div>

	<h1 class="text-center company_name_profile">{{ $company->name }}</h1>
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 left">
	@if (Auth::user()->id != $company->id)
		@if (!Auth::user()->is_admin && !in_array(Auth::user()->id, $connections_ids))
		<div class="connect">
			<form method="POST" action="{{ action('ConnectionsController@store', ['id' => $company->id]) }}">
				{!! csrf_field() !!}
				<button type="submit" class="btn btn-primary connect">Connect</button>
			</form>
		</div>
		@elseif ($existing_connection)
		<div class="connect">
			<form method="POST" action="{{ action('ConnectionsController@destroy', $existing_connection) }}">
				{!! csrf_field() !!}
				{!! method_field('DELETE') !!}
				<button type="submit" class="btn btn-info connect">Remove Connection</button>
			</form>
		</div>
		@endif
	@endif

		<div class="panel_white">
			<h3 class="text-center">Contact</h3>
			<ul class="contact">
				<li>{{ $contact->address_line_1 }}</li>
				<li>{{ $contact->city }}, {{ $contact->state }} {{ $contact->zip }}</li>
				<li><a class="red_link small_caps" href="{{ 'https://www.google.com/maps/search/' . $contact->address_line_1 . '+' . $contact->city . '+' . $contact->state . '+' . $contact->zip }}" target="_blank">Directions</a></li>
			</ul>
			<p class="strong">{{ '(' . substr($contact->phone_no, 0, 3) . ') ' . substr($contact->phone_no, 3, 3) . '-' . substr($contact->phone_no, 6, 4) }}</p>
			<p><a class="red_link" href="{{ $contact->website }}" target="_blank" alt="{{ $company->name }}">{{ $company_url }}</a></p>
		</div>

		<div class="panel_white">
			@include('partials.rfps_box', ['rfps' => $rfps])
		</div>

	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 center">
		<div class="about_panel_red bottom15">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<ul class="company_stats">
						@if($company->industry_id)
							<li><span class="strong">Industry: </span>{{ $company->industry->industry }}</li>
						@endif
						@if($company->contractor)
							<li><span class="strong">Business type:</span> Contractor</li>
						@endif
						@if($company->organization)
							<li><span class="strong">Business type:</span> Organization</li>
						@endif
						@if ($company->organization)
							<li><span class="strong">Company size: </span>{{ $company->size }}</li>
						@endif
					</ul>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<ul class="company_stats">
						<li><span class="strong">Date established:</span> {{ $company->date_established }}</li>
						@if($company->woman_owned)
							<li><span class="glyphicon glyphicon-ok"></span>Woman-owned</li>
						@endif
						@if($company->family_owned)
							<li><span class="glyphicon glyphicon-ok"></span>Family-owned</li>
						@endif
					</ul>
				</div>
			</div>
		</div>

		<div class="panel_white">
			<h3 class="text-center">About</h3>
			<p>{!! nl2br(e($company->desc)) !!}</p>
		</div>

		<img class="img-responsive project_showcase" src="/img/codeup_class.jpg">
		<div class="main_panel project_showcase">
			<h3 class="text-center">Project Showcase</h3>
			<h4 class="text-center project_showcase">Codeup Learn to Code Workshop (HTML &amp; CSS)</h4>
			<p>Back by popular demand, we decided to host another Learn to Code workshop in August! The Learn to Code workshop covers the basics of HTML and CSS.</p>
			<div class="text-center">
				<a class="red_link project" href="http://www.meetup.com/Codeup/events/233267909/" alt="Read full project" target="_blank">See Full Project </a>
			</div>
		</div>

		<div class="panel_white">
			<h3 class="text-center">Leadership</h3>
				<div class="row">
					@foreach ($leaders as $leader)
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center">
						<a href="{{ $leader->linkedin_url }}" target="_blank">
							<div class="leader_headshot">
								<img class="img-circle img-thumbnail center-block" src="{{ '/img/uploads/leaders/' . $leader->img }}">
							</div>
						</a>
						<h5 class="leader_name">{{ $leader->full_name }}</h5>
						<p class="leader_title">{{ $leader->title }}</p>
					</div>
					@endforeach
				</div>
		</div>

	</div>

	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 right">
		<div class="social_media panel_white text-center">
			<h3>Follow {{ $company->name }}</h3>
			@if ($contact->facebook)
				<a href="http://www.facebook.com/{{ $contact->facebook }}"><img class="social_media_icon" src="/img/facebook-dreamstale25.png" alt="facebook" /></a>
			@endif
			@if ($contact->instagram)
				<a href="http://www.instagram.com/{{ $contact->instagram }}"><img class="social_media_icon" src="/img/instagram-dreamstale43.png" alt="instagram" /></a>
			@endif
			@if ($contact->linkedin)
				<a href="http://www.linkedin.com/in/{{ $contact->linkedin }}"><img class="social_media_icon" src="/img/linkedin-dreamstale45.png" alt="linkedin" /></a>
			@endif
			@if ($contact->google_plus)
				<a href="http://plus.google.com/{{ $contact->google_plus }}"><img class="social_media_icon" src="/img/google+-dreamstale37.png" alt="google+" /></a>
			@endif
		</div>

		<div class="panel_white">
			@include ('partials.events_box', ['events' => $events])
		</div>

			<div class="panel_white">
				<a class="twitter-timeline" href="https://twitter.com/search?q=from%3A{{ $contact->twitter }}" data-widget-id="771057747718582272" data-screen-name="{{ $contact->twitter }}">Tweets about </a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					<a href="https://twitter.com/{{ $contact->twitter }}" class=" twitter-follow-button" data-show-count="false">Follow @{{ $contact-> }}</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			</div>

			@if($company->id > 1)
			<div class="panel_white">
				<h3 class="text-center">Connections</h3>
				@foreach($connections as $connection)
					@foreach ($connection as $company)
					<a href="{{ action('CompaniesController@show', $company->id) }}"><img class="img-thumbnail connection_thumb" src="{{ '/img/uploads/avatars/' . $company->profile_img }}" alt="{{ $company->name }}"></a>
					@endforeach
				@endforeach
				<div class="panel_green">
					<a class="green_bg" href="{{ action('CompaniesController@viewConnections', ['id' => $company->id]) }}" alt="View All Connections">All Connections</a>
				</div>
			</div>
			@endif
		</div>

</div>
@stop
