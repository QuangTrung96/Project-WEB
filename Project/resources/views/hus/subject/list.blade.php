@extends('master')
@section('content')
	<h1 id='replyh'>{{ $title }}</h1>
	<table width='701' id='subj_list'>
		<tr>
			<td class='title' colspan='7'>
				<a href='javascript:void(0)' onclick='loadForm("add_subj")'>Thêm môn học</a>
			</td>
		</tr>
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
          <a href='javascript:void(0)' onclick='editSubj(
          {{ $subject->id }}, "{{ $subject->subject_code }}", "{{ $subject->subject_name }}", "{{ $full_name }}", {{ $subject->number_of_credits }}, "{{ $subject->semester->semester_name }}"
          )'>Sửa</a>
        </td>
				<td><a href='javascript:void(0)' onclick='deleteSubj({{ $subject->id }})'>Xóa</a></td>
			</tr>
		@empty
		@endforelse
	</table>
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

	<div class="cls"></div>

	{{ Form::open(['method' => 'POST', 'route' => 'subject_edit_post', 'id' => 'edit_subj', 'role'=>'form', 'style' => 'display:none']) }}
	{{ Form::hidden('edit_subj_id', '', ['id' => 'edit_subj_id']) }}
	<p class='minihead'>Mã môn học:</p>
  {{ Form::text('edit_subj_subject_code', '', ['id' => 'edit_subj_subject_code']) }}
  <p class='minihead'>Tên môn học:</p>
  {{ Form::text('edit_subj_subject_name', '', ['id' => 'edit_subj_subject_name']) }}
  <p class='minihead'>Tên giảng viên:</p>
  {{ Form::select('user', $users) }}
  <p class='minihead'>Số tín chỉ:</p>
  {{ Form::select('credit', $credits) }}
  <p class='minihead'>Tên học kỳ:</p>
  {{ Form::select('semester', $semesters) }}
  <p class='minihead'></p>
  {{ Form::submit('Sửa') }}
	{{ Form::button('Thoát', ['onclick' => 'hideForm("edit_subj")']) }}
	{{ Form::close() }}
@endsection
@section('code_js')
  	<script  type='text/javascript'>
  		function loadForm(id_form) {
	  		$idForm = $('#'+id_form);
	  		if ($idForm.is(':hidden')) {
	  			$idForm.fadeIn('fast');
	  		} else {
	  			if (id_form != 'edit_subj') {
	  				$idForm.fadeOut('fast');	
	  			}
	  		}
  		}

  		function clearForm() {
  			$('input[type=text], input[type=hidden]').val('');
  			$('form').hide();
  		}

  		$(document).ready(function() {
  			$('#add_subj').on('submit', function(e) {
  				e.preventDefault();
          $subjectCode = $('#add_subj_subject_code').val().trim();
  				$subjectName = $('#add_subj_subject_name').val().trim();
          $numberOfCredits = $('[name=credit]').val();
          $semesterID = $('[name=semester]').val();

          if ($subjectCode == '') {
            alert('Vui lòng nhập mã môn học.');
          } else if ($subjectName == '') {
            alert('Vui lòng nhập tên môn học.');
          } else if ($semesterID == '0') {
            alert('Bạn phải thêm học kỳ trước đã.');
          } else {
            $userID = $('[name=user]').val();
            $url = $('#add_subj').attr('action');
            $.ajax({
              'url': $url,
              'type': 'post',
              'data': {
                'subjectCode'    : $subjectCode,
                'subjectName'    : $subjectName,
                'userID'         : $userID,
                'numberOfCredits': $numberOfCredits,
                'semesterID'     : $semesterID,
                '_token'         : '{{ csrf_token() }}'},
              'async': true,
              'success': function(data) {
                if (typeof(data) == "object") {
                  alert(data.mess);
                } else {
                  alert('Thêm môn học thành công.');
                  $('#scho_list').append(data);
                  clearForm();
                }
              }
            });
          }
  			});

        $('#edit_scho').on('submit', function(e) {
          e.preventDefault();
          $schoYear = $('#edit_scho_year').val().trim();
          if ($schoYear == '') {
            alert('Vui lòng nhập năm cho năm học.');
          } else {
            var rules = /^[0-9]{4}$/;
            if (rules.test($schoYear)) { 
              $url = $('#edit_scho').attr('action');
              $schoID = $('#edit_scho_id').val();
              $.ajax({
                'url': '{{ route('scholastic_edit_post') }}',
                'type': 'post',
                'data': {'schoID': $schoID, 'schoYear': $schoYear, '_token': '{{ csrf_token() }}'},
                'async': true,
                'success': function(data) {
                  if (typeof data == 'object') {
                    alert(data.mess);
                  } else {
                    alert('Sửa năm học thành công.');
                    clearForm();
                    $('tr#scho_'+$schoID).html(data);
                  }
                }
              });
            } else {
              alert('Năm học nhập vào phải toàn là số và có độ dài là 4.');
            }
          }
        });
  		});

  		function editScho(id, year) {
  			$('#edit_scho_id').val(id);
  			$('#edit_scho_year').val(year);
  			loadForm('edit_scho');
  		}

  		function hideForm(id_form) {
  			$('#'+id_form).hide();
  			return false;
  		}

  		function deleteScho(id) {
  			if (confirm('Bạn có chắc, muốn xóa năm học này.')) {
  				$.get('{{ url("scholastic/delete") }}/'+id, function(data) {
  					if (typeof data == 'object') {
  						alert(data.mess);
              if (data.status == 'success') {
                $('tr#scho_'+id).remove();
              }
  					}
  				});
  			}
  		}
  	</script>
@endsection