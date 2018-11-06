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
		<link rel="shortcut icon" href="http://www.hus.vnu.edu.vn/sites/default/files/favicon.ico" type="image/vnd.microsoft.icon" />
	</head>

	<body>

		@include('templates.top')

		<div class="centerfix" id="header">
			<div class="centercontent">
				<a href="#"><img src="{{ asset('public/bluesky/img/header/logo.png') }}" /></a>
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
					<div class="warningx wgreeny"> {{ Session::get('success') }} </div>
					@endif

					@yield('content')
					
				</div>
				
				@include('templates.menu')

			</div>
		</div>
		
		@include('templates.bottom')

		<script language="javascript" src="{{ asset('public/bluesky/js/libs.js') }}"></script>
		<script language="javascript" src="{{ asset('public/bluesky/js/plugins.js') }}"></script>

		@yield("code_js")

	</body>
</html>