@extends('master')
<style type='text/css'>
  #header {
    margin-bottom: 55px;
  }
  .row a:visited {
    color: white !important;
  }
</style>
<link href='{{ asset('public/css/bootstrap.min.css') }}' rel='stylesheet' />
@section('content')
  <h1 id='replyh'>{{ $title }}</h1>
  <div class="row">
    <div class="col-md-12">
      <div>
        <a href="{{ route('point.index') }}" class="btn btn-primary">Danh sách điểm</a>
      </div>
      <br />
      <div class="panel panel-default">
        <div class="panel-body">
          <form action="{{ route('point.update', ['id' => $point->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="form-group {{ $errors->has('student_code') ? 'has-error' : '' }}">
              <label for="student_code">Mã sinh viên</label>
              <input type="text" class="form-control" id="student_code" name="student_code" placeholder="Mã sinh viên"
                value="{{ $point->student_code }}">
              <span class="help-block">{{ $errors->first('student_code') }}</span>
            </div>

            <div class="form-group {{ $errors->has('subject_code') ? 'has-error' : '' }}">
              <label for="subject_code">Mã môn học</label>
              {{ Form::select('subject_code', $subjects, old('subject_code'), ['class' => 'form-control', 'id' => 'subject_code']) }}
              <span class="help-block">{{ $errors->first('subject_code') }}</span>
            </div>

            <div class="form-group {{ $errors->has('point') ? 'has-error' : '' }}">
              <label for="point">Điểm thi</label>
              <input type="text" class="form-control" id="point" name="point" placeholder="Điểm thi"
                value="{{ $point->point }}">
              <span class="help-block">{{ $errors->first('point') }}</span>
            </div>

            <div class="form-group {{ $errors->has('exam_day') ? 'has-error' : '' }}">
              <label for="exam_day">Ngày thi</label>
              <input type="date" class="form-control" id="exam_day" name="exam_day" placeholder="Ngày thi"
                value="{{ $point->exam_day }}">
              <span class="help-block">{{ $errors->first('exam_day') }}</span>
            </div>

            <button type="submit" class="btn btn-success">Sửa điểm</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
