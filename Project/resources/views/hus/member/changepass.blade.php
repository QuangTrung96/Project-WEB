@extends('master')
@section('content')
  <h1 id="replyh">{{ $title }}</h1>
  <p class="bluey">Vui lòng nhập liệu các thông tin theo yêu cầu bên dưới.</p>
  {{ Form::open(['method' => 'POST', 'route' => 'changepass_post', 'role'=>'form']) }}
  	<p class="minihead">Mật khẩu cũ:</p>
  	{{ Form::password('old-password') }}
    <p class="minihead">Mật khẩu mới:</p>
    {{ Form::password('new-password') }}
  	<p class="minihead">Xác nhận mật khẩu mới:</p>
  	{{ Form::password('re-new-password') }}
  	<p></p>
  	{{ Form::submit('Thay đổi') }}
  {{ Form::close() }}
@endsection