@extends('layouts.master')

@section('content')

<form method="POST" action="{{ action('AuthController@postRegister') }}">
	{!!csrf_field()!!}
@include(admin_create_login.blade.php)
<button type="submit">Submit</button>
</form>

@stop