@extends('master')
<style type='text/css'>
  #header {
    margin-bottom: 55px;
  }
  .pagination li.active {
    width: 12px;
    padding: 0px 0px;
    margin-left: 8px;
    margin-right: 19px;
  }
  .pagination li.active span {
    width: 12px;
    height: 1.799rem;
  }
  .pagination li.disabled {
    width: 12px;
    padding: 0px 0px;
    margin-left: 5px;
    margin-right: 15px;
  }
  .pagination li.disabled span {
    width: 12px;
    height: 1.799rem;
    padding-right: 12px;
  }
  .row a:visited {
    color: white !important;
  }
</style>
<link href='{{ asset('public/css/bootstrap.min.css') }}' rel='stylesheet' />
@section('content')
  <h1 id='replyh'>{{ $title }}</h1>
  <div class='row'>
    <div class='col-md-12'>
      <div>
        <div style="float: left;">
          <a href='{{ route('point.create') }}' class='btn btn-primary'>Thêm điểm</a>
        </div>
        <div style="float: right;">
          {!! Form::open(['method' => 'GET','route' => 'point.index']) !!}
            <input type="submit" value="Search" style="float: right;" />
            <input type="text" name="keyword" placeholder="Type you word ..." @if(Request::has('keyword')) value="{{ Request::get('keyword') }}" @endif() />
          {!! Form::close() !!}
        </div>
      </div>
      <div style="clear: both;"></div>
      <br />
      <br />
      <div class='panel panel-default'>
        <div class='panel-heading text-center'>
          <h4 style="color: #00cc00;">Danh sách điểm</h4>
        </div>
        <div class='panel-body'>
          <div class='table-responsive'>
            <table class='table table-bordered'>
              <thead>
                <tr>
                  <th>MSV</th>
                  <th>Mã môn học</th>
                  <th>Điểm</th>
                  <th>Ngày thi</th>
                  <th>Chức năng</th>
                </tr>
              </thead>
              <tbody>
                @forelse($points as $point)
                  <tr>
                    <td>{{ $point->student_code }}</td>
                    <td>{{ $point->subject_code }}</td>
                    <td>{{ $point->point }}</td>
                    <td>{{ $point->exam_day }}</td>
                    <td>
                      <a href="{{ route('point.show', ['id' => $point->id]) }}"
                      class="btn btn-primary">
                        <i class="glyphicon glyphicon-pencil"></i>
                      </a>
                      <a href="{{ route('point.delete', ['id' => $point->id]) }}"
                      class="btn btn-danger"
                      onclick="event.preventDefault();
                      window.confirm('Bạn đã chắc chắn xóa chưa ?') ?
                      document.getElementById('point-delete-{{ $point->id }}').submit() :
                      0;"><i class="glyphicon glyphicon-remove"></i></a>
                      <form action="{{ route('point.delete', ['id' => $point->id]) }}"
                        method="post" id="point-delete-{{ $point->id }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                      </form>
                    </td>
                  </tr>
                @empty
                  <br />
                  <tr class="text-center">
                    <td colspan="5">Không có dữ liệu nào</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('body_scripts_bottom')
<script src='{{ asset('public/js/bootstrap.min.js') }}'></script>
@endsection