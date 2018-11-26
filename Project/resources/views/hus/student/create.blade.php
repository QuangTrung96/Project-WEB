@extends('master')
<style type='text/css'>
  #header {
    margin-bottom: 55px;
  }
</style>
<link href='{{ asset('public/css/bootstrap.min.css') }}' rel='stylesheet' />
@section('content')
  <h1 id='replyh'>{{ $title }}</h1>
  <div class="row">
    <div class="col-md-12">
      <div>
        <a href="{{ route('student.index') }}" class="btn btn-primary">Danh sách sinh viên</a>
      </div>
      <br />
      <div class="panel panel-default">
        <div class="panel-body">
          <form action="#" method="POST" enctype="multipart/form-data" target="_blank">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('student_code') ? 'has-error' : '' }}">
              <label for="student_code">Mã sinh viên</label>
              <input type="text" class="form-control" id="student_code" name="student_code" placeholder="Mã sinh viên"
                value="{{ old('student_code') }}">
              <span class="help-block">{{ $errors->first('student_code') }}</span>
            </div>

            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
              <label for="last_name">Họ đệm</label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Họ đệm"
                value="{{ old('last_name') }}">
              <span class="help-block">{{ $errors->first('last_name') }}</span>
            </div>

            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
              <label for="first_name">Tên</label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Tên"
                value="{{ old('first_name') }}">
              <span class="help-block">{{ $errors->first('first_name') }}</span>
            </div>

            <div class="form-group {{ $errors->has('birthday') ? 'has-error' : '' }}">
              <label for="birthday">Ngày sinh</label>
              <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh"
                value="{{ old('birthday') }}">
              <span class="help-block">{{ $errors->first('birthday') }}</span>
            </div>
            
            <div class="form-group">
              <label for="gender">Giới tính</label>
              <select name="gender" id="gender" class="form-control">
                  <option value="1">Nam</option>
                  <option value="2">Nữ</option>
              </select>
            </div>
            
            <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
              <label for="address">Địa chỉ</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ"
                value="{{ old('address') }}">
              <span class="help-block">{{ $errors->first('address') }}</span>
            </div>
            
            <div class="form-group" id="qh-app">
              <qh-attributes></qh-attributes>
            </div>
            <button type="submit" class="btn btn-success">Thêm sinh viên</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('body_scripts_bottom')
<script src='{{ asset('public/js/jquery.min.js') }}'></script>
<script src='{{ asset('public/js/bootstrap.min.js') }}'></script>
@endsection