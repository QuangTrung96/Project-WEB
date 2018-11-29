@extends('master')
@section('content')
  @php
    dd($points->subject->subject_name);
  @endphp
	<h1 id='replyh'>{{ $title }}</h1>
  <div style='width: 456px'>
    <table width='450' id='scho_list'>
      <div id='form_mess' style='width: 450px'></div>
      <tr>
        <td class='title' colspan='3'>
          <a href='javascript:void(0)' onclick='loadForm("add_scho")'>Thêm năm học</a>
        </td>
      </tr>
      <tr>
        <td class='title'>Năm học</td>
        <td class='title'>Sửa</td>
        <td class='title'>Xóa</td>
      </tr>
      @forelse($points as $point)
        dd($point);
      @empty
        <tr>
          <td colspan="3">Không có dữ liệu nào</td>
        </tr>
      @endforelse
    </table>
  </div>
@endsection
