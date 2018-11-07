@extends('master')
@section('content')
	<h1 id='replyh'>{{ $title }}</h1>
	<table width='450' id='scho_list'>
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
		@forelse($scholastics as $scholastic)
			<tr id='scho_{{ $scholastic->id }}'>
				<td>{{ $scholastic->year }}</td>
				<td><a href='javascript:void(0)' onclick='editScho({{ $scholastic->id }}, "{{ $scholastic->year }}")'>Sửa</a></td>
				<td><a href='javascript:void(0)' onclick='deleteScho({{ $scholastic->id }})'>Xóa</a></td>
			</tr>
		@empty
		@endforelse
	</table>
	{{ Form::open(['method' => 'POST', 'route' => 'scholastic_add_post', 'id' => 'add_scho', 'role'=>'form', 'style' => 'display:none']) }}
	<p class='minihead'>Năm học:</p>
	{{ Form::text('add_scho_year', '', ['id' => 'add_scho_year']) }}
	<p class='minihead'></p>
	{{ Form::submit('Thêm năm') }}
	{{ Form::close() }} 

	<div class="cls"></div>

	{{ Form::open(['method' => 'POST', 'route' => 'scholastic_edit_post', 'id' => 'edit_scho', 'role'=>'form', 'style' => 'display:none']) }}
	{{ Form::hidden('edit_scho_id', '', ['id' => 'edit_scho_id']) }}
	<p class='minihead'>Năm học:</p>
	{{ Form::text('edit_scho_year', '', ['id' => 'edit_scho_year']) }}
	<p class='minihead'></p>
	{{ Form::submit('Sửa') }}
	{{ Form::button('Thoát', ['onclick' => 'hideForm("edit_scho")']) }}
	{{ Form::close() }}
@endsection
@section('code_js')
  	<script  type='text/javascript'>
  		function loadForm(id_form) {
	  		$idForm = $('#'+id_form);
	  		if ($idForm.is(':hidden')) {
	  			$idForm.fadeIn('fast');
	  		} else {
	  			if (id_form != 'edit_scho') {
	  				$idForm.fadeOut('fast');	
	  			}
	  		}
  		}

  		function clearForm() {
  			$('input[type=text], input[type=hidden]').val('');
  			$('form').hide();
  		}

  		$(document).ready(function() {
  			$('#add_scho').on('submit', function(e) {
  				e.preventDefault();
  				$schoYear = $('#add_scho_year').val().trim();
  				if ($schoYear == '') {
  					alert('Vui lòng nhập năm cho năm học.');
  				} else {
              var rules = /^[0-9]{4}$/;
              if (rules.test($schoYear)) {
                $url = $('#add_scho').attr('action');
                $.ajax({
                  'url': $url,
                  'type': 'post',
                  'data': {'schoYear': $schoYear, '_token': '{{ csrf_token() }}'},
                  'async': true,
                  'success': function(data) {
                    if (typeof(data) == "object") {
                      alert(data.mess);
                    } else {
                      alert('Thêm năm học thành công.');
                      $('#scho_list').append(data);
                      clearForm();
                    }
                  }
                });
              } else {
                alert('Năm học nhập vào phải toàn là số và có độ dài là 4.');
              }
            }
  			});

        $('#edit_scho').on('submit', function(e) {
          e.preventDefault();
          var schoYear = $('#edit_scho_year').val().trim();
          if (schoYear)
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
  						$('tr#scho_'+id).remove();
  					}
  				});
  			}
  		}
  	</script>
@endsection