@extends('master')
@section('content')
	<h1 id='replyh'>{{ $title }}</h1>
	<table width='450' id='seme_list'>
		<tr>
			<td class='title' colspan='3'>
				<a href='javascript:void(0)' onclick='loadForm("add_seme")'>Thêm học kỳ</a>
			</td>
		</tr>
		<tr>
			<td class='title'>Tên học kỳ</td>
			<td class='title'>Sửa</td>
			<td class='title'>Xóa</td>
		</tr>
		@forelse($semesters as $semester)
			<tr id='seme_{{ $semester->id }}'>
				<td>{{ $semester->semester_name }}</td>
				<td><a href='javascript:void(0)' onclick='editSeme({{ $semester->id }}, "{{ $semester->semester_name }}")'>Sửa</a></td>
				<td><a href='javascript:void(0)' onclick='deleteSeme({{ $semester->id }})'>Xóa</a></td>
			</tr>
		@empty
		@endforelse
	</table>
	{{ Form::open(['method' => 'POST', 'route' => 'semester_add_post', 'id' => 'add_seme', 'role'=>'form', 'style' => 'display:none']) }}
	<p class='minihead'>Tên học kỳ:</p>
	{{ Form::text('add_cate_title', '', ['id' => 'add_cate_title']) }}
	<p class='minihead'></p>
	{{ Form::submit(__('category.Add category')) }}
	{{ Form::close() }}

	<div class="cls"></div>

	{{ Form::open(['method' => 'POST', 'route' => 'category_edit_post', 'id' => 'edit_cate', 'role'=>'form', 'style' => 'display:none']) }}
	{{ Form::hidden('edit_cate_id', '', ['id' => 'edit_cate_id']) }}
	<p class='minihead'>{{ __('category.Category name') }}:</p>
	{{ Form::text('edit_cate_title', '', ['id' => 'edit_cate_title']) }}
	<p class='minihead'></p>
	{{ Form::submit(__('category.Edit category')) }}
	{{ Form::button(__('category.Cancel'), ['onclick' => 'hideForm("edit_cate")']) }}
	{{ Form::close() }}
@endsection
@section('code_js')
  	<script  type='text/javascript'>
  		function loadForm(id_form) {
	  		$idForm = $('#'+id_form);
	  		if($idForm.is(':hidden')) {
	  			$idForm.fadeIn('fast');
	  		} else {
	  			if(id_form != 'edit_cate') {
	  				$idForm.fadeOut('fast');	
	  			}
	  		}
  		}

  		function clearForm() {
  			$('input[type=text], input[type=hidden]').val('');
  			$('form').hide();
  		}

  		$(document).ready(function() {
  			$('#add_cate').on('submit', function(e) {
  				e.preventDefault();
  				$cateName = $('#add_cate_title').val();
  				if($cateName == '') {
  					alert('Vui lòng nhập tên cho chuyên mục.');
  				} else {
  					$url = $('#add_cate').attr('action');
  					$.ajax({
  						'url': $url,
  						'type': 'post',
  						'data': {'cateName': $cateName, '_token': '{{ csrf_token() }}'},
  						'async': true,
  						'success': function(data) {
  							if(typeof(data) == "object") {
  								alert(data.mess);
  							} else {
  								alert('Thêm chuyên mục thành công.');
  								$('#cate_list').append(data);
  								clearForm();
  							}
  						}
  					})
  				}
  			});

  			$('#edit_cate').on('submit', function(e) {
  				e.preventDefault();
  				$cateName = $('#edit_cate_title').val();
  				if($cateName == '') {
  					alert('Vui lòng nhập tên cho chuyên mục.');
  				} else {
  					$url = $('#edit_cate').attr('action');
  					$cateID = $('#edit_cate_id').val();
  					$.ajax({
  						'url': '{{ route('category_edit_post') }}',
  						'type': 'post',
  						'data': {'cateID': $cateID, 'cateName': $cateName, '_token': '{{ csrf_token() }}'},
  						'async': true,
  						'success': function(data) {
  							if(typeof data == 'object') {
  								alert(data.mess);
  							} else {
  								alert('Sửa chuyên mục thành công.');
  								clearForm();
  								$('tr#cate_'+$cateID).html(data);
  							}
  						}
  					})
  				}
  			});
  		});

  		function editCate(id, title) {
  			$('#edit_cate_id').val(id);
  			$('#edit_cate_title').val(title);
  			loadForm('edit_cate');
  		}

  		function hideForm(id_form) {
  			$('#'+id_form).hide();
  			return false;
  		}

  		function deleteCate(id) {
  			if(confirm('Bạn có chắc, muốn xóa chuyên mục này.')) {
  				$.get('{{ url("category/delete") }}/'+id, function(data){
  					if(typeof data == 'object') {
  						alert(data.mess);
  						$('tr#cate_'+id).remove();
  					}
  				});
  			}
  		}
	</script>
@endsection
