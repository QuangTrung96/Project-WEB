@extends('master')
@section('content')
  <h1 id="replyh">{{ $title }}</h1>
  <p class="bluey">Please enter the information requested below.</p>
  {{ Form::open(['method' => 'POST', 'route' => 'forgot_post', 'role'=>'form']) }}
  	<p class="minihead">Username or Email:</p>
  	{{ Form::text('username-or-email', '', ['class' => 'fullinput']) }}
  	{{ Form::submit('Reset Password') }}
  {{ Form::close() }}
@endsection