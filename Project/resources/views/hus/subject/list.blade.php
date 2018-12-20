@extends('master')
@section('content')
	<h1 id='replyh'>{{ $title }}</h1>
	<table width='701' id='subj_list'>
    <div id='form_mess' style='width: 701px'></div>
		<tr>
			<td class='title' colspan='7'>
        @if (Sentinel::getUser()->hasAccess('subject_add'))
				  <a href='javascript:void(0)' onclick='loadForm("add_subj")'>Thêm môn học</a>
        @else
          <a href='javascript:void(0)'>Thêm môn học</a>
        @endif
			</td>
		</tr>
    <div id='modal' class='modal' style='display: none; width: 1080px'></div>
		<tr>
			<td class='title'>Mã môn học</td>
			<td class='title'>Tên môn học</td>
			<td class='title'>Giảng viên</td>
			<td class='title'>Số tín chỉ</td>
			<td class='title'>Học kỳ</td>
			<td class='title'>Sửa</td>
			<td class='title'>Xóa</td>
		</tr>
		@forelse($subjects as $subject)
			<tr id='subj_{{ $subject->id }}'>
        @php
          $full_name = $subject->user->last_name . ' ' . $subject->user->first_name
        @endphp
				<td>{{ $subject->subject_code }}</td>
				<td>{{ $subject->subject_name }}</td>
				<td>{{ $full_name }}</td>
        <td>{{ $subject->number_of_credits }}</td>
				<td>{{ $subject->semester->semester_name }}</td>
				<td>
          @if (Sentinel::getUser()->hasAccess('subject_edit'))
            <a href='javascript:void(0)' onclick='editSubj(
            {{ $subject->id }}, "{{ $subject->subject_code }}", "{{ $subject->subject_name }}", {{ $subject->user_id }}, {{ $subject->number_of_credits }}, {{ $subject->semester_id }}
            )'>Sửa</a>
          @else
            <a href='javascript:void(0)'>Sửa</a>
          @endif
        </td>
				<td>
          @if (Sentinel::getUser()->hasAccess('subject_delete'))
            <a href='javascript:void(0)' onclick='deleteSubj({{ $subject->id }})'>Xóa</a>
          @else
            <a href='javascript:void(0)'>Xóa</a>
          @endif
        </td>
			</tr>
		@empty
      <tr id="empty">
        <td colspan="7">Không có dữ liệu nào</td>
      </tr>
		@endforelse
	</table>
  <div class='cls'></div>
  {{ $subjects->links() }} 

	{{ Form::open(['method' => 'POST', 'route' => 'subject_add_post', 'id' => 'add_subj', 'role'=>'form', 'style' => 'display:none']) }}
  	<p class='minihead'>Mã môn học:</p>
  	{{ Form::text('add_subj_subject_code', '', ['id' => 'add_subj_subject_code']) }}
    <p class='minihead'>Tên môn học:</p>
    {{ Form::text('add_subj_subject_name', '', ['id' => 'add_subj_subject_name']) }}
    <p class='minihead'>Tên giảng viên:</p>
    {{ Form::select('user', $users) }}
    <p class='minihead'>Số tín chỉ:</p>
    {{ Form::select('credit', $credits) }}
    <p class='minihead'>Tên học kỳ:</p>
    {{ Form::select('semester', $semesters) }}
  	<p class='minihead'></p>
  	{{ Form::submit('Thêm môn học') }}
	{{ Form::close() }} 

	<div class='cls'>&nbsp;</div>

	{{ Form::open(['method' => 'POST', 'route' => 'subject_edit_post', 'id' => 'edit_subj', 'role'=>'form', 'style' => 'display:none']) }}
  	{{ Form::hidden('edit_subj_id', '', ['id' => 'edit_subj_id']) }}
  	<p class='minihead'>Mã môn học:</p>
    {{ Form::text('edit_subj_subject_code', '', ['id' => 'edit_subj_subject_code']) }}
    <p class='minihead'>Tên môn học:</p>
    {{ Form::text('edit_subj_subject_name', '', ['id' => 'edit_subj_subject_name']) }}
    <p class='minihead'>Tên giảng viên:</p>
    {{ Form::select('user_select', $users) }}
    <p class='minihead'>Số tín chỉ:</p>
    {{ Form::select('credit_select', $credits) }}
    <p class='minihead'>Tên học kỳ:</p>
    {{ Form::select('semester_select', $semesters) }}
    <p class='minihead'></p>
    {{ Form::submit('Sửa') }}
  	{{ Form::button('Thoát', ['onclick' => 'hideForm("edit_subj")']) }}
	{{ Form::close() }}
@endsection
@section('code_js')
  <script  type='text/javascript'>
    function loadForm(id_form) {
      $('#add_subj').fadeOut('fast');
      $idForm = $('#' + id_form);
      if ($idForm.is(':hidden')) {
        $idForm.fadeIn('fast');
      } else {
        if (id_form != 'edit_subj') {
          $('#edit_subj').fadeOut('fast');
        } else {
            $('#add_subj').fadeOut('fast');
        }
      }
    }

    $(document).ready(function () {
      $('#add_subj').on('submit', function (e) {
        e.preventDefault();
        $subjectCode = $('#add_subj_subject_code').val().trim();
        $subjectName = $('#add_subj_subject_name').val().trim();
        $semesterID = $('[name=semester]').val();

        if ($subjectCode == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập mã môn học !!!</li></ul>')
            .removeClass('warningx wgreeny')
            .addClass('warningx wredy');
        } else if ($subjectName == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập tên môn học !!!</li></ul>')
            .removeClass('warningx wgreeny')
            .addClass('warningx wredy');
        } else if ($semesterID == '0') {
          $('#form_mess').html('<ul><li>Bạn phải thêm học kỳ trước đã !!!</li></ul>')
            .removeClass('warningx wgreeny')
            .addClass('warningx wredy');
        } else {
          $('#form_mess').html(' ')
            .removeClass('warningx wredy');
          $userID = $('[name=user]').val();
          $numberOfCredits = $('[name=credit]').val();
          $url = $('#add_subj').attr('action');
          $.ajax({
            'url': $url,
            'type': 'post',
            'data': {
              'subjectCode': $subjectCode,
              'subjectName': $subjectName,
              'userID': $userID,
              'numberOfCredits': $numberOfCredits,
              'semesterID': $semesterID,
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
                $('#form_mess').html('<ul><li>Thêm môn học thành công !!!</li></ul>')
                  .removeClass('warningx wredy')
                  .addClass('warningx wgreeny');
                $('#subj_list').append(data);
                clearForm();
              }
            },
            'error': function (e) {
              console.log(e);
            }
          });
        }
      });

      $('#edit_subj').on('submit', function (e) {
        e.preventDefault();
        $subjectCode = $('#edit_subj_subject_code').val().trim();
        $subjectName = $('#edit_subj_subject_name').val().trim();

        if ($subjectCode == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập mã môn học !!!</li></ul>')
            .removeClass('warningx wgreeny')
            .addClass('warningx wredy');
        } else if ($subjectName == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập tên môn học !!!</li></ul>')
            .removeClass('warningx wgreeny')
            .addClass('warningx wredy');
        } else {
          $('#form_mess').html(' ')
            .removeClass('warningx wredy');
          $subjID = $('#edit_subj_id').val();
          $userID = $('[name=user_select]').val();
          $numberOfCredits = $('[name=credit_select]').val();
          $semesterID = $('[name=semester_select]').val();
          $url = $('#edit_subj').attr('action');
          $.ajax({
            'url': $url,
            'type': 'post',
            'data': {
              'subjID': $subjID,
              'subjectCode': $subjectCode,
              'subjectName': $subjectName,
              'userID': $userID,
              'numberOfCredits': $numberOfCredits,
              'semesterID': $semesterID,
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
                $('#form_mess').html('<ul><li>Sửa môn học thành công !!!</li></ul>')
                  .removeClass('warningx wredy')
                  .addClass('warningx wgreeny');
                clearForm();
                $('tr#subj_' + $subjID).html(data);
              }
            },
            'error': function (e) {
              console.log(e);
            }
          });
        }
      });
    });

    function editSubj(id, subject_code, subject_name, user_id, credit, semester_id) {
      $('#edit_subj_id').val(id);
      $('#edit_subj_subject_code').val(subject_code);
      $('#edit_subj_subject_name').val(subject_name);
      $('select[name=user_select] option[value=' + user_id + ']').prop('selected', true);
      $('select[name=credit_select] option[value=' + credit + ']').prop('selected', true);
      $('select[name=semester_select] option[value=' + semester_id + ']').prop('selected', true);
      loadForm('edit_subj');
    }

    function deleteSubj(id) {
      if (confirm('Bạn có chắc, muốn xóa môn học này ?')) {
        $.get('{{ url("subject/delete") }}/' + id, function (data) {
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
              hideForm('add_subj');
              hideForm('edit_subj');
              $('tr#subj_' + id).remove();
            }
          }
        });
      }
    }
  </script>
@endsection