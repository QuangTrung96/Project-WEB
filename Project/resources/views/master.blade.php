<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

	<head>
		<meta charset="utf-8" />
		<title>{{ $title }}</title>
		<link media="all" type="text/css" rel="stylesheet" href="{{ asset('public/bluesky/css/style.css') }}" />
		<link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/vnd.microsoft.icon" />
	</head>

	<body>

		@include('templates.top')

		<div class="centerfix" id="header">
			<div class="centercontent">
				<a href="{{ route('index') }}"><img src="{{ asset('public/bluesky/img/header/logo.png') }}" /></a>
				<img src="{{ asset('public/bluesky/img/header/bannertxt_vi.png') }}" />
				<img src="{{ asset('public/bluesky/img/header/medals.png') }}" />
			</div>
		</div>

		<div class="centerfix" id="main" role="main">
			<div class="centercontent clearfix">
				<div id="contentblock">
					@if(Session::has('error'))
					<div class="warningx wredy"> {{ Session::get('error') }} </div>
					@endif
					
					@if(Session::has('success'))
					<div class="warningx wgreeny"> {{ Session::get('success') }} 
						@if(Session::has('link'))
							<a href="{{ Session::get('link') }}" style="color: #bace18">xem lại tại đây.</a>
						@endif
					</div>
					@endif

					@yield('content')
					
				</div>
				
				@include('templates.menu')

			</div>
		</div>
		
		@include('templates.bottom')

		<script type="text/javascript" src='{{ asset('public/js/jquery.min.js') }}'></script>
		
		@yield("code_js")
		
		@yield('body_scripts_bottom')

	</body>
</html>