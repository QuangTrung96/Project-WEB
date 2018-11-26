@extends('master')
<style type='text/css'>
  #header {
    margin-bottom: 55px;
  }
</style>
<link href='{{ asset('public/css/bootstrap.min.css') }}' rel='stylesheet' />
@section('content')
  <h1 id='replyh'>{{ $title }}</h1>
  <div class='row'>
    <div class='col-md-12'>
      <div>
        <a href='{{ route('student.create') }}' class='btn btn-primary'>Thêm sinh viên</a>
      </div>
      <br />
      <div class='panel panel-default'>
        <div class='panel-heading text-center'>
          <h4 class='text-info'>Danh sách sinh viên</h4>
        </div>
        <div class='panel-body'>
          <div class='table-responsive'>
            <table class='table'>
              <thead>
                <tr>
                  <th>MSV</th>
                  <th>Họ và tên</th>
                  <th>Ngày sinh</th>
                  <th>Giới tính</th>
                  <th>Chức năng</th>
                </tr>
              </thead>
              <tbody>
                @forelse($students as $student)
                  @php
                    $full_name = $student->last_name . ' ' . $student->first_name;
                  @endphp
                  <tr>
                    <td>{{ $student->student_code }}</td>
                    <td style='word-break: break-all'>{{ $full_name }}</td>
                    <td>{{ $student->birthday }}</td>
                    @if ($student->gender === 1)
                      <td>Nam</td>
                    @else
                      <td>Nữ</td>
                    @endif
                    <td>
                      <a href="#"
                        class="btn btn-primary">Sửa</a>
                      <a href="#"
                         class="btn btn-danger">Xóa</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6">Không có dữ liệu nào</td>
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
<script src='{{ asset('public/js/jquery.min.js') }}'></script>
<script src='{{ asset('public/js/bootstrap.min.js') }}'></script>
@endsection