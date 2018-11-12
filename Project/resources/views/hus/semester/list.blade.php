@extends('master')
@section('content')
	<h1 id='replyh'>{{ $title }}</h1>
	<table width='450' id='seme_list'>
		<tr>
			<td class='title' colspan='4'>
				<a href='javascript:void(0)' onclick='loadForm("add_seme")'>Thêm học kỳ</a>
			</td>
		</tr>
		<tr>
      <td class='title'>Tên học kỳ</td>
			<td class='title'>Năm học</td>
			<td class='title'>Sửa</td>
			<td class='title'>Xóa</td>
		</tr>
		@forelse($semesters as $semester)
			<tr id='seme_{{ $semester->id }}'>
        <td>{{ $semester->semester_name }}</td>
				<td>{{ $semester->scholastic->year }}</td>
				<td><a href='javascript:void(0)' onclick='editSeme({{ $semester->id }}, "{{ $semester->semester_name }}", {{ $semester->scholastic_id }})'>Sửa</a></td>
				<td><a href='javascript:void(0)' onclick='deleteSeme({{ $semester->id }})'>Xóa</a></td>
			</tr>
		@empty
		@endforelse
	</table>
	{{ Form::open(['method' => 'POST', 'route' => 'semester_add_post', 'id' => 'add_seme', 'role'=>'form', 'style' => 'display:none']) }}
	<p class='minihead'>Tên học kỳ:</p>
	{{ Form::text('add_seme_semester_name', '', ['id' => 'add_seme_semester_name']) }}
  <p class="minihead">Năm học:</p>
  {{ Form::select('scholastic', $scholastics, ['class' => 'scholastic']) }}
	<p class='minihead'></p>
	{{ Form::submit('Thêm học kỳ') }}
	{{ Form::close() }}

	<div class="cls"></div>

	{{ Form::open(['method' => 'POST', 'route' => 'semester_edit_post', 'id' => 'edit_seme', 'role'=>'form', 'style' => 'display:none']) }}
	{{ Form::hidden('edit_seme_id', '', ['id' => 'edit_seme_id']) }}
	<p class='minihead'>Tên học kỳ:</p>
	{{ Form::text('edit_seme_semester_name', '', ['id' => 'edit_seme_semester_name']) }}
  <p class="minihead">Năm học:</p>
  {{ Form::select('scholastic', $scholastics, ['class' => 'scholastic']) }}
	<p class='minihead'></p>
	{{ Form::submit('Sửa học kỳ') }}
	{{ Form::button('Thoát', ['onclick' => 'hideForm("edit_seme")']) }}
	{{ Form::close() }}
@endsection
@section('code_js')
    <script  type='text/javascript'>
      function loadForm(id_form) {
        $idForm = $('#'+id_form);
        if ($idForm.is(':hidden')) {
          $idForm.fadeIn('fast');
        } else {
          if (id_form != 'edit_seme') {
            $idForm.fadeOut('fast');  
          }
        }
      }

      function clearForm() {
        $('input[type=text], input[type=hidden]').val('');
        $('form').hide();
      }

      $(document).ready(function() {
        $('#add_seme').on('submit', function(e) {
          e.preventDefault();
          $semesterName = $('#add_seme_semester_name').val().trim();
          if ($semesterName == '') {
            alert('Vui lòng nhập tên cho học kỳ.');
          } else {
              $scholasticID = $('[name=scholastic]').val();
              $url = $('#add_seme').attr('action');
              $.ajax({
                'url': $url,
                'type': 'post',
                'data': {'semesterName': $semesterName, 'scholasticID': $scholasticID, '_token': '{{ csrf_token() }}'},
                'async': true,
                'success': function(data) {
                  if (typeof(data) == "object") {
                    alert(data.mess);
                  } else {
                    alert('Thêm học kỳ thành công.');
                    $('#seme_list').append(data);
                    clearForm();
                  }
                }
              }); 
            }
        });

        $('#edit_seme').on('submit', function(e) {
          e.preventDefault();
          $semesterName = $('#edit_seme_semester_name').val().trim();
          if ($semesterName == '') {
            alert('Vui lòng nhập tên cho học kỳ.');
          } else {
            $semeID = $('#edit_seme_id').val();
            $scholasticID = $('[name=scholastic]').val();
            $url = $('#edit_seme').attr('action');
            $.ajax({
              'url': '{{ route('semester_edit_post') }}',
              'type': 'post',
              'data': {'semeID': $semeID, 'semesterName': $semesterName, 'scholasticID': $scholasticID , '_token': '{{ csrf_token() }}'},
              'async': true,
              'success': function(data) {
                if (typeof data == 'object') {
                  alert(data.mess);
                } else {
                  alert('Sửa học kỳ thành công.');
                  clearForm();
                  $('tr#seme_'+$semeID).html(data);
                }
              }
            });
          }
        });
      });

      function editSeme(id, semesterName, scholasticID) {
        $('#edit_seme_id').val(id);
        $('#edit_seme_semester_name').val(semesterName);
        $("select option[value="+scholasticID+"]").attr("selected","selected");
        loadForm('edit_seme');
        $("select").change(function(){
          var selectedCountry = $(this).children("option:selected").val();
          $("select option[value="+selectedCountry+"]").attr("selected","selected");
        });
      }

      function hideForm(id_form) {
        $('#'+id_form).hide();
        return false;
      }

      function deleteSeme(id) {
        if (confirm('Bạn có chắc, muốn xóa học kỳ này.')) {
          $.get('{{ url("semester/delete") }}/'+id, function(data) {
            if (typeof data == 'object') {
              alert(data.mess);
              $('tr#seme_'+id).remove();
            }
          });
        }
      }
    </script>
@endsection

