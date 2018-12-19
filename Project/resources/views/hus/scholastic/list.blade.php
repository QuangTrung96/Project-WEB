@extends('master')
@section('content')
	<h1 id='replyh'>{{ $title }}</h1>
  <div style='width: 456px'>
    <table width='450' id='scho_list'>
      <div id='form_mess' style='width: 450px'></div>
      <tr>
        <td class='title' colspan='3'>
          @if (Sentinel::getUser()->hasAccess('scholastic_add'))
            <a href='javascript:void(0)' onclick='loadForm("add_scho")'>Thêm năm học</a>
          @else
            <a href='javascript:void(0)'>Thêm năm học</a>
          @endif
        </td>
      </tr>
      <tr>
        <td class='title'>Năm học</td>
        <td class='title'>Sửa</td>
        <td class='title'>Xóa</td>
      </tr>
      @forelse($scholastics as $scholastic)
        <tr id='scho_{{ $scholastic->id }}'>
          <td>{{ $scholastic->year }}</td>
          <td>
            @if (Sentinel::getUser()->hasAccess('scholastic_edit'))
              <a href='javascript:void(0)' onclick='editScho({{ $scholastic->id }}, "{{ $scholastic->year }}")'>Sửa</a>
            @else
              <a href='javascript:void(0)'>Sửa</a>
            @endif
          </td>
          <td>
            @if (Sentinel::getUser()->hasAccess('scholastic_delete'))
              <a href='javascript:void(0)' onclick='deleteScho({{ $scholastic->id }})'>Xóa</a>
            @else
              <a href='javascript:void(0)'>Xóa</a>
            @endif
          </td>
        </tr>
      @empty
        <tr id='empty'>
          <td colspan="3">Không có dữ liệu nào</td>
        </tr>
      @endforelse
    </table>
    <div id='modal' class='modal' style='display: none; width: 850px'></div>
    <div class='cls'></div>
    {{ $scholastics->links() }}

    {{ Form::open(['method' => 'POST', 'route' => 'scholastic_add_post', 'id' => 'add_scho', 'role'=>'form', 'style' => 'display:none']) }}
      <p class='minihead'>Năm học:</p>
      {{ Form::text('add_scho_year', '', ['id' => 'add_scho_year']) }}
      <p class='minihead'></p>
      {{ Form::submit('Thêm năm') }}
    {{ Form::close() }} 

    <div class='cls'>&nbsp;</div>

    {{ Form::open(['method' => 'POST', 'route' => 'scholastic_edit_post', 'id' => 'edit_scho', 'role'=>'form', 'style' => 'display:none']) }}
      {{ Form::hidden('edit_scho_id', '', ['id' => 'edit_scho_id']) }}
      <p class='minihead'>Năm học:</p>
      {{ Form::text('edit_scho_year', '', ['id' => 'edit_scho_year']) }}
      <p class='minihead'></p>
      {{ Form::submit('Sửa') }}
      {{ Form::button('Thoát', ['onclick' => 'hideForm("edit_scho")']) }}
    {{ Form::close() }}
  </div>
@endsection
@section('code_js')
	<script  type='text/javascript'>
    $(document).ready(function () {
      $('#add_scho').on('submit', function (e) {
        e.preventDefault();
        $schoYear = $('#add_scho_year').val().trim();
        if ($schoYear == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập năm học !!!</li></ul>')
            .removeClass('warningx wgreeny')
            .addClass('warningx wredy');
        } else {
          $('#form_mess').html(' ')
            .removeClass('warningx wredy');
          var rules = /^[0-9]{4}$/;
          if (rules.test($schoYear)) {
            $url = $('#add_scho').attr('action');
            $.ajax({
              'url': $url,
              'type': 'post',
              'data': {
                'schoYear': $schoYear,
                '_token': '{{ csrf_token() }}'
              },
              'async': true,
              'timeout': 10000,
              'beforeSend': function (xhr) {
                show_loading();
              },
              'complete': function (xhr) {
                hide_loading();
              },
              'success': function (data) {
                if (typeof (data) == 'object') {
                  $('#form_mess').removeClass('warningx wgreeny')
                    .addClass('warningx wredy')
                    .html(function () {
                      var $mess = '<ul><li>' + data.mess + '</li></ul>';
                      return $mess;
                    });
                } else {
                  $('#empty').hide();
                  $('#form_mess').html('<ul><li>Thêm năm học thành công !!!</li></ul>')
                    .removeClass('warningx wredy')
                    .addClass('warningx wgreeny');
                  $('#scho_list').append(data);
                  clearForm();
                }
              },
              'error': function (e) {
                console.log(e);
              }
            });
          } else {
            $('#form_mess').html('<ul><li>Năm học nhập vào phải là số và có độ dài là 4 !!!</li></ul>')
              .removeClass('warningx wgreeny')
              .addClass('warningx wredy');
          }
        }
      });

      $('#edit_scho').on('submit', function (e) {
        e.preventDefault();
        $schoYear = $('#edit_scho_year').val().trim();
        if ($schoYear == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập năm học !!!</li></ul>')
            .removeClass('warningx wgreeny')
            .addClass('warningx wredy');
        } else {
          $('#form_mess').html(' ')
            .removeClass('warningx wredy');
          var rules = /^[0-9]{4}$/;
          if (rules.test($schoYear)) {
            $url = $('#edit_scho').attr('action');
            $schoID = $('#edit_scho_id').val();
            $.ajax({
              'url': "{{ route('scholastic_edit_post') }}",
              'type': 'post',
              'data': {
                'schoID': $schoID,
                'schoYear': $schoYear,
                '_token': '{{ csrf_token() }}'
              },
              'async': true,
              'timeout': 10000,
              'beforeSend': function (xhr) {
                show_loading();
              },
              'complete': function (xhr) {
                hide_loading();
              },
              'success': function (data) {
                if (typeof data == 'object') {
                  $('#form_mess').removeClass('warningx wgreeny')
                    .addClass('warningx wredy')
                    .html(function () {
                      var $mess = '<ul><li>' + data.mess + '</li></ul>';
                      return $mess;
                    });
                } else {
                  $('#form_mess').html('<ul><li>Sửa năm học thành công !!!</li></ul>')
                    .removeClass('warningx wredy')
                    .addClass('warningx wgreeny');
                  clearForm();
                  $('tr#scho_' + $schoID).html(data);
                }
              },
              'error': function (e) {
                console.log(e);
              }
            });
          } else {
            $('#form_mess').html('<ul><li>Năm học nhập vào phải toàn là số và có độ dài là 4 !!!</li></ul>')
              .removeClass('warningx wgreeny')
              .addClass('warningx wredy');
          }
        }
      });
    });

    function editScho(id, year) {
      $('#edit_scho_id').val(id);
      $('#edit_scho_year').val(year);
      loadForm('edit_scho');
    }

    function deleteScho(id) {
      if (confirm('Bạn có chắc, muốn xóa năm học này ?')) {
        $.get('{{ url("scholastic/delete") }}/' + id, function (data) {
          if (typeof data == 'object') {
            $('#form_mess').removeClass('warningx wgreeny')
              .addClass('warningx wredy')
              .html(function () {
                var $mess = '<ul><li>' + data.mess + '</li></ul>';
                return $mess;
              });

            if (data.status == 'success') {
              $('#form_mess').removeClass('warningx wredy')
                .addClass('warningx wgreeny')
                .html(function () {
                  var $mess = '<ul><li>' + data.mess + '</li></ul>';
                  return $mess;
                });
              hideForm('add_scho');
              hideForm('edit_scho');
              $('tr#scho_' + id).remove();
            }
          }
        });
      }
    }
	</script>
@endsection