@extends('master')
@section('content')
  <h1 id='replyh'>{{ $title }}</h1>
  <div style='width: 701px;'>
    <table width='701' id='point_list'>
      <div id='form_mess' style='width: 701'></div>
      <tr>
        <td class='title' colspan='6'>
          <a href='javascript:void(0)' onclick='loadForm("add_point")'>Thêm điểm</a>
        </td>
      </tr>
      <tr>
        <td class='title'>MSV</td>
        <td class='title'>Mã môn học</td>
        <td class='title'>Điểm</td>
        <td class='title'>Ngày thi</td>
        <td class='title'>Sửa</td>
        <td class='title'>Xóa</td>
      </tr>
      @forelse($points as $point)
        <tr id='point_{{ $point->id }}'>
          <td>{{ $point->student_code }}</td>
          <td>{{ $point->subject_code }}</td>
          <td>{{ $point->point }}</td>
          <td>{{ $point->exam_day }}</td>
          <td>
            <a href='javascript:void(0)' onclick='editPoint({{ $point->id }}, "{{ $point->student_code }}")'>Sửa</a>
          </td>
          <td>
            <a href='javascript:void(0)' onclick='deletePoint({{ $point->id }})'>Xóa</a>
          </td>
        </tr>
      @empty
        <tr id='empty'>
          <td colspan="6">Không có dữ liệu nào</td>
        </tr>
      @endforelse
    </table>
    <div id='modal' class='modal' style='display: none; width: 850px'></div>
    <div class='cls'></div>

    {{ Form::open(['method' => 'POST', 'route' => 'point_add_post', 'id' => 'add_point', 'role'=>'form', 'style' => 'display:none']) }}
      <p class="minihead">Mã môn học:</p>
      {{ Form::select('subject_code', $subjects) }}
      <p class='minihead'>Mã sinh viên:</p>
      {{ Form::text('student_code', '', ['id' => 'student_code']) }}
      <p class='minihead'>Điểm thi:</p>
      {{ Form::text('point', '', ['id' => 'point']) }}
      <p class='minihead'>Ngày thi:</p>
      {{ Form::date('exam_day', '', ['id' => 'exam_day']) }}
      <p class='minihead'></p>
      {{ Form::submit('Thêm') }}
    {{ Form::close() }} 

    <div class='cls'>&nbsp;</div>
    {{ Form::open(['method' => 'POST', 'route' => 'point_edit_post', 'id' => 'edit_point', 'role'=>'form', 'style' => 'display:none']) }}
      {{ Form::hidden('edit_point_id', '', ['id' => 'edit_point_id']) }}
      <p class="minihead">Mã môn học:</p>
      {{ Form::select('subject_code', $subjects) }}
      <p class='minihead'>Mã sinh viên:</p>
      {{ Form::text('student_code', '', ['id' => 'student_code']) }}
      <p class='minihead'>Điểm thi:</p>
      {{ Form::text('point', '', ['id' => 'point']) }}
      <p class='minihead'>Ngày thi:</p>
      {{ Form::date('exam_day', '', ['id' => 'exam_day']) }}
      <p class='minihead'></p>
      {{ Form::submit('Sửa') }}
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
          if (id_form != 'edit_point') {
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
      $('#add_point').on('submit', function(e) {
        e.preventDefault();
        $subject_code = $('#subject_code').val();
        $student_code = $('#student_code').val().trim();
        $point = $('#point').val().trim();
        $exam_day = $('#exam_day').val();
        $url = $('#add_point').attr('action');
        $.ajax({
          'url': $url,
          'type': 'post',
          'data': {
            'subject_code': $subject_code,
            'student_code': $student_code,
            'point': $point ,
            'exam_day': $exam_day ,
            '_token': '{{ csrf_token() }}'
          },
          'async': true,
          'timeout': 10000,
          'beforeSend' : function(xhr) {
            show_loading();
            alert(xhr.status);
          },
          'complete': function(xhr, status) {
            hide_loading();
          },
          'success': function(data) {
            if (typeof data == 'object') {
              alert('1');
            } else {
              alert('2');
            }
          },
           error: function(jqXhr, json, errorThrown){// this are default for ajax errors 
        var errors = jqXhr.responseJSON;
        var errorsHtml = '';
        $.each(errors['errors'], function (index, value) {
            errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
        });

    }
        });

  
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