@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 left_home">

    <form action="#" method="get">
      <label for="users_rsvps">My RSVPs</label>
      <select class="form-control" id="rsvp_id" name="rsvp_id">
        <option disabled selected label="Select"></option>



      </select>
      <button type="submit" class="btn btn-default">Edit</button>
    </form>

  </div>


  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 center_home">
    <form class="form-group" action="{{ action('EventsController@searchEvents') }}" method="get">
      {!! csrf_field() !!}
      <label for="name">Search Events by Company</label>
      <input type="text" name="search_field" value="" placeholder="company name">

      <select class="form-control search_form pull-right" id="industry_id" name="industry_id">
        <option disabled selected label="Select Industry"></option>
        @foreach ($industries as $industry)
          <option value="{{ $industry->id }}">{{ $industry->industry }}</option>
        @endforeach
      </select>

      <button type="Submit">Search</button>
    </form>
    @foreach($search_results as $event)
      <a href="{{ action('EventsController@show', $id = $event->id) }}"><h5>{{ $event->title }}</h5></a>
    @endforeach
  </div>


  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-xl-3 right_home">

    <div class="panel_white">
			<h3 class="text-center">My Events</h3>
			@foreach ($users_events as $key => $event)
				@if ($key < 3)
				<div id="accordion" role="tablist" aria-multiselectable="false">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading{{$key+1}}">
							<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key+1}}" aria-expanded="false" aria-controls="collapse{{$key+1}}">{{ $event->title }}
							</a>
							</h4>
							<p class="event_date_home">{{ $event->from_date->format('F j') }} - {{ $event->to_date->format('F j') }}</p>
						</div>
						<div id="collapse{{$key+1}}" class="panel-collapse collapse event_desc_home" role="tabpanel" aria-labelledby="heading{{$key+1}}">
						{{ str_limit($event->desc, 100) }}<a class="red_link" href="{{ action('EventsController@show', $id = $event->id) }}"> see event</a>
						</div>
					</div>
				</div>
				@endif
			@endforeach
      <a href="{{ action('EventsController@create') }}">Create New Event</a>
			<div class="panel_green">
				<a class="green_bg" href="{{ action('EventsController@index') }}" alt="View All Events">See All Events</a>
			</div>
		</div>


  <div class="panel_white">
    <h3 class="text-center">Connection Events</h3>
    @foreach ($connections_events as $key => $event)
      @if ($key < 3)
      <div id="accordion" role="tablist" aria-multiselectable="false">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading{{$key+1}}">
            <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key+1}}" aria-expanded="false" aria-controls="collapse{{$key+1}}">{{ $event->title }}
            </a>
            </h4>
            <p class="event_date_home">{{ $event->from_date->format('F j') }} - {{ $event->to_date->format('F j') }}</p>
          </div>
          <div id="collapse{{$key+1}}" class="panel-collapse collapse event_desc_home" role="tabpanel" aria-labelledby="heading{{$key+1}}">
          {{ str_limit($event->desc, 100) }}<a class="red_link" href="{{ $event->url }}" target="_blank"> see event</a>
          </div>
        </div>
      </div>
      @endif
    @endforeach
    <div class="panel_green">
      <a class="green_bg" href="{{ action('EventsController@index') }}" alt="View All Events">See All Events</a>
    </div>
  </div>

</div>
</div>

@stop