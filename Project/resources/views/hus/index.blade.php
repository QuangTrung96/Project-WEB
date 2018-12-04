@extends('master')
<style type='text/css'>
  #header {
    height: 180px;
    background-color: #e7e7e7;
  }
  #main {
    background-color: #e7e7e7;
  }
</style>
@section('content')
<link href='{{ asset('public/css/bootstrap.min.css') }}' rel='stylesheet' />
<div>&nbsp;</div>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="{{ asset('public/img/VNU_lethanhtong_900x600.jpg') }}" alt="..." style="height: 466.66px">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img src="{{ asset('public/img/5555.jpg') }}" alt="..." style="height: 466.66px">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img src="{{ asset('public/img/555.jpg') }}" alt="..." style="height: 466.66px">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img src="{{ asset('public/img/22.jpg') }}" alt="..." style="height: 466.66px">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img src="{{ asset('public/img/1234.JPG') }}" alt="..." style="height: 466.66px">
      <div class="carousel-caption">
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div> <!-- Carousel -->
@endsection
@section('body_scripts_bottom')
<script src='{{ asset('public/js/bootstrap.min.js') }}'></script>
@endsection