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
    <style type="text/css">
      #page_not_found {
        width: 400px;
        margin: 90px auto;
        margin-left: 330px;
      }

      #page_not_found img {
        width: 40px;
        height: 40px;
      }
    </style>
  </head>

  <body>
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

          <div id="page_not_found">
            <h2><img src="{{ asset('public/img/warning.png') }}" />Không tìm thấy đường dẫn này</h2>
            <h2>Vui lòng quay trở lại <a href="{{ route('index') }}">trang chủ</a></h2>
          </div>
          
        </div>
      </div>
      <div id="go-to-top"></div>
    </div>
    
    @include('templates.bottom')

    <script type="text/javascript" src='{{ asset('public/js/jquery.min.js') }}'></script>
    <script src='{{ asset('public/js/common.js') }}'></script>
    
    @yield("code_js")
    
    @yield('body_scripts_bottom')

  </body>
</html>