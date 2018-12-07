@extends('master')
@section('content')
	<h1 id='replyh'>{{ $title }}</h1>
	<div style='width: 456px'>
    <table width='450' id='seme_list'>
      <div id='form_mess' style='width: 450px'></div>
      <tr>
        <td class='title' colspan='4'>
          @if (Sentinel::getUser()->hasAccess('semester_add'))
            <a href='javascript:void(0)' onclick='loadForm("add_seme")'>Thêm học kỳ</a>
          @else
            <a href='javascript:void(0)'>Thêm học kỳ</a>
          @endif
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
          <td>
            @if (Sentinel::getUser()->hasAccess('semester_edit'))
              <a href='javascript:void(0)' onclick='editSeme({{ $semester->id }}, "{{ $semester->semester_name }}", {{ $semester->scholastic_id }})'>Sửa</a>
            @else
              <a href='javascript:void(0)'>Sửa</a>
            @endif
          </td>
          <td>
            @if (Sentinel::getUser()->hasAccess('semester_delete'))
              <a href='javascript:void(0)' onclick='deleteSeme({{ $semester->id }})'>Xóa</a>
            @else
              <a href='javascript:void(0)'>Xóa</a>
            @endif
          </td>
        </tr>
      @empty
        <tr id="empty">
          <td colspan="4">Không có dữ liệu nào</td>
        </tr>
      @endforelse
    </table>
    <div id='modal' class='modal' style='display: none; width: 850px'></div>
    <div class='cls'></div>
    {{ $semesters->links() }} 

    {{ Form::open(['method' => 'POST', 'route' => 'semester_add_post', 'id' => 'add_seme', 'role'=>'form', 'style' => 'display:none']) }}
      <p class='minihead'>Tên học kỳ:</p>
      {{ Form::text('add_seme_semester_name', '', ['id' => 'add_seme_semester_name']) }}
      <p class="minihead">Năm học:</p>
      {{ Form::select('scholastic', $scholastics) }}
      <p class='minihead'></p>
      {{ Form::submit('Thêm học kỳ') }}
    {{ Form::close() }}

    <div class='cls'>&nbsp;</div>

    {{ Form::open(['method' => 'POST', 'route' => 'semester_edit_post', 'id' => 'edit_seme', 'role'=>'form', 'style' => 'display:none']) }}
      {{ Form::hidden('edit_seme_id', '', ['id' => 'edit_seme_id']) }}
      <p class='minihead'>Tên học kỳ:</p>
      {{ Form::text('edit_seme_semester_name', '', ['id' => 'edit_seme_semester_name']) }}
      <p class="minihead">Năm học:</p>
      {{ Form::select('scholastic_edit', $scholastics) }}
      <p class='minihead'></p>
      {{ Form::submit('Sửa học kỳ') }}
      {{ Form::button('Thoát', ['onclick' => 'hideForm("edit_seme")']) }}
    {{ Form::close() }}
  </div>
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

    var isShowingLoading = false;
    function show_loading() {
      isShowingLoading = true;
      $('#modal').show();
    }

    function hide_loading() {
      isShowingLoading = false;
      $('#modal').hide();
    }

    $(document).ready(function() {
      $('#add_seme').on('submit', function(e) {
        e.preventDefault();
        $semesterName = $('#add_seme_semester_name').val().trim();
        $scholasticID = $('[name=scholastic]').val();

        if ($semesterName == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập tên cho học kỳ !!!</li></ul>')
                         .removeClass('warningx wgreeny')
                         .addClass('warningx wredy');
        } else if ($scholasticID == '0') { 
            $('#form_mess').html('<ul><li>Bạn phải thêm năm học trước đã !!!</li></ul>')
                           .removeClass('warningx wgreeny')
                           .addClass('warningx wredy');
          } else {
              $('#form_mess').html('&nbsp;')
                             .removeClass('warningx wredy');
              $url = $('#add_seme').attr('action');
              $.ajax({
                'url': $url,
                'type': 'post',
                'data': {
                  'semesterName': $semesterName,
                  'scholasticID': $scholasticID,
                  '_token': '{{ csrf_token() }}'
                },
                'async': true,
                'timeout': 10000,
                'beforeSend' : function(xhr) {
                  show_loading();
                },
                'complete': function(xhr) {
                  hide_loading();
                },
                'success': function(data) {
                  if (typeof(data) == "object") {
                    $('#form_mess').removeClass('warningx wgreeny')
                                   .addClass('warningx wredy')
                                   .html(function () {
                                      var $mess = '<ul><li>' + data.mess + '</li></ul>';
                                      return $mess;
                                    });
                  } else {
                      $('#empty').hide();
                      $('#form_mess').html('<ul><li>Thêm học kỳ thành công !!!</li></ul>')
                                     .removeClass('warningx wredy')
                                     .addClass('warningx wgreeny');
                      $('#seme_list').append(data);
                      clearForm();
                    }
                },
                'error': function (e) {
                  console.log(e);
                }
              }); 
            }
      });

      $('#edit_seme').on('submit', function(e) {
        e.preventDefault();
        $semesterName = $('#edit_seme_semester_name').val().trim();
        if ($semesterName == '') {
          $('#form_mess').html('<ul><li>Vui lòng nhập tên cho học kỳ !!!</li></ul>')
                         .removeClass('warningx wgreeny')
                         .addClass('warningx wredy');
        } else {
          $('#form_mess').html('&nbsp;')
                         .removeClass('warningx wredy');
          $semeID = $('#edit_seme_id').val();
          $scholasticID = $('[name=scholastic_edit]').val();
          $url = $('#edit_seme').attr('action');
          $.ajax({
            'url': '{{ route('semester_edit_post') }}',
            'type': 'post',
            'data': {
              'semeID': $semeID,
              'semesterName': $semesterName,
              'scholasticID': $scholasticID ,
              '_token': '{{ csrf_token() }}'
            },
            'async': true,
            'timeout': 10000,
            'beforeSend' : function(xhr) {
              show_loading();
            },
            'complete': function(xhr) {
              hide_loading();
            },
            'success': function(data) {
              if (typeof data == 'object') {
                $('#form_mess').removeClass('warningx wgreeny')
                               .addClass('warningx wredy')
                               .html(function () {
                                  var $mess = '<ul><li>' + data.mess + '</li></ul>';
                                  return $mess;
                                });
              } else {
                $('#form_mess').html('<ul><li>Sửa học kỳ thành công !!!</li></ul>')
                               .removeClass('warningx wredy')
                               .addClass('warningx wgreeny');
                clearForm();
                $('tr#seme_'+$semeID).html(data);
              }
            },
            'error': function (e) {
              console.log(e);
            }
          });
        }
      });
    });

    function editSeme(id, semesterName, scholasticID) {
      $('#edit_seme_id').val(id);
      $('#edit_seme_semester_name').val(semesterName);
      $('select[name=scholastic_edit] option[value='+scholasticID+']').attr('selected', 'selected');
      loadForm('edit_seme');
    }

    function hideForm(id_form) {
      $('#'+id_form).hide();
      return false;
    }

    function deleteSeme(id) {
      if (confirm('Bạn có chắc, muốn xóa học kỳ này ?')) {
        $.get('{{ url("semester/delete") }}/'+id, function(data) {
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
              hideForm('add_seme');
              hideForm('edit_seme');
              $('tr#seme_'+id).remove();
            }
          }
        });
      }
    }
  </script>
@endsection

