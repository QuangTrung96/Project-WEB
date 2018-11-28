@if(count($errors))
	@if((Route::current()->getName() != 'student.create' && Route::current()->getName() != 'student.show'))
		<div class="centerfix" id="infobar">
			<div class="centercontent">{{ $errors->first() }}</div>
		</div>
	@endif
@endif

@if(!Sentinel::check())
<div class="centerfix" id="login">
	<div class="centercontent">
		{{ Form::open(['method' => 'POST', 'route' => 'login_post', 'role' => 'form']) }}
			{{ Form::text('username-or-email', '', ['class' => 'input', 'placeholder' => 'Username or Email']) }}				
			{{ Form::password('password', ['class' => 'input', 'placeholder' => 'Password']) }}
			<span>
				{{ Form::checkbox('remember-me', 'true', false) }}
				Remember me
			</span>
			{{ Form::submit('Login!') }}
			<a href="{{ route('forgot_get') }}" class="wybutton">Forgot password?</a>
		{{ Form::close() }}		
	</div>
</div>
@else
<div class="centerfix" id="login">
	<div class="centercontent">
		<div id="userblock">Xin chào, {{ Sentinel::getUser()->username }} (<a href="{{ route('logout_get') }}">Đăng xuất</a>) - <a href="{{ route('changepass_get') }}">Sửa mật khẩu</a></div>
		
	</div>
</div>
@endif