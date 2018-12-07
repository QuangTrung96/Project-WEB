@extends('master')
<style type='text/css'>
  #header {
    margin-bottom: 55px;
  }
  .pagination li.active {
    width: 12px;
    padding: 0px 0px;
    margin-left: 8px;
    margin-right: 19px;
  }
  .pagination li.active span {
    width: 12px;
    height: 1.799rem;
  }
  .pagination li.disabled {
    width: 12px;
    padding: 0px 0px;
    margin-left: 5px;
    margin-right: 15px;
  }
  .pagination li.disabled span {
    width: 12px;
    height: 1.799rem;
    padding-right: 12px;
  }
  .row a:visited {
    color: white !important;
  }
</style>
<link href='{{ asset('public/css/jquery-ui.min.css') }}' rel='stylesheet' />
<link href='{{ asset('public/css/bootstrap.min.css') }}' rel='stylesheet' />
@section('content')
  <h1 id='replyh'>{{ $title }}</h1>
  <div class='row'>
    <div class='col-md-12'>
      <div>
        <div style="float: left;">
          @if (Sentinel::getUser()->hasAccess('student_add'))
            <a href='{{ route('student.create') }}' class='btn btn-primary'>Thêm sinh viên</a>
          @else
            <a href='javascript:void(0)' class='btn btn-primary'>Thêm sinh viên</a>
          @endif
        </div>
        <div style="float: right;">
          {!! Form::open(['method' => 'GET','route' => 'student.index']) !!}
            <input type="submit" value="Search" style="float: right;" />
            <input type="text" name="keyword" placeholder="Type you word ..." @if(Request::has('keyword')) value="{{ Request::get('keyword') }}" @endif() />
          {!! Form::close() !!}
        </div>
      </div>
      <div style="clear: both;"></div>
      <br />
      <br />
      <div class='panel panel-default'>
        <div class='panel-heading text-center'>
          <h4 style="color: #00cc00;">Danh sách sinh viên</h4>
        </div>
        <div class='panel-body'>
          <div class='table-responsive'>
            <div id='modal' class='modal' style='display: none; margin-left: 20px;'></div>
            <table class='table table-bordered'>
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
                    <td>
                      <a href="{{ route('student.detail', ['id' => $student->id]) }}" class="student-detail" style="color: red !important">{{ $student->student_code }}</a>
                    </td>
                    <td style='word-break: break-all'>{{ $full_name }}</td>
                    <td>{{ $student->birthday }}</td>
                    @if ($student->gender === 1)
                      <td>Nam</td>
                    @else
                      <td>Nữ</td>
                    @endif
                    <td>
                      @if (Sentinel::getUser()->hasAccess('student_edit'))
                      <a href="{{ route('student.show', ['id' => $student->id]) }}"
                      class="btn btn-primary">
                        <i class="glyphicon glyphicon-pencil"></i>
                      </a>
                      @else
                      <a href="javascript:void(0)"
                      class="btn btn-primary">
                        <i class="glyphicon glyphicon-pencil"></i>
                      </a>
                      @endif
                      @if (Sentinel::getUser()->hasAccess('student_delete'))
                      <a href="{{ route('student.delete', ['id' => $student->id]) }}"
                      class="btn btn-danger"
                      onclick="event.preventDefault();
                      window.confirm('Bạn đã chắc chắn xóa chưa ?') ?
                      document.getElementById('student-delete-{{ $student->id }}').submit() :
                      0;"><i class="glyphicon glyphicon-remove"></i></a>
                      @else
                      <a href="javascript:void(0)" class="btn btn-danger">
                        <i class="glyphicon glyphicon-remove"></i>
                      </a>
                      @endif
                      <form action="{{ route('student.delete', ['id' => $student->id]) }}"
                        method="post" id="student-delete-{{ $student->id }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                      </form>
                    </td>
                  </tr>
                @empty
                  <br />
                  <tr class="text-center">
                    <td colspan="6">Không có dữ liệu nào</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="text-center">
            {{ $students->links() }}
          </div>

          <div id="dialog-form" title="Loading..." style="display:none;margin-top: 12px;">
            <p id="dialog-add-content">My POPUP</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('body_scripts_bottom')
<script src='{{ asset('public/js/jquery-ui.min.js') }}'></script>
<script src='{{ asset('public/js/bootstrap.min.js') }}'></script>
<script>
  var isShowingLoading = false;
  function show_loading() {
    isShowingLoading = true;
    $('#modal').show();
  }

  function hide_loading() {
    isShowingLoading = false;
    $('#modal').hide();
  }

  $(document).ready(function () { 
    init_dialog_form();
  
    $(".student-detail").click(function(e) {
      e.preventDefault();
      $("#dialog-form").dialog("open");
      var url = $(this).attr('href');
      $.ajax(
        {
          url: url,
          type: 'GET',
          timeout: 10000,
          //async: false,
          //cache: false,
          beforeSend: function (xhr) {
            $('#dialog-form').html('');
            show_loading();
          },
          success: function (data) {
            if ($.trim(data) == 'Bạn không có quyền thực hiện hành động này !!!') {
              $('#dialog-form').dialog("close");
              alert('Bạn không có quyền thực hiện hành động này !!!');
              location.reload();
              return;
            }
            hide_loading();
            $('#dialog-form').html(data);
            $('#dialog-form').dialog('option', 'title', $('#dialog-form .h_title').text());
            $('#dialog-form').dialog('option', 'title', $('#dialog-form .h_title').text());
            $('#dialog-form').dialog('open');
            $('#btn_cancel').click(function (ev) {
              $('#dialog-form').dialog("close");
            });
          },
          error: function(jqXHR, textStatus){
            if(textStatus === 'timeout')
            {     
              alert('Access denied or session timeout');
              location.reload();
              return;
            }
          }
        }
      )
      return false;
    });
  });

  function init_dialog_form(width) {
    if (!width) {
      width = 1000;
    }
    $('#dialog-form').dialog(
      {
        autoOpen: false,
        cache: false,
        modal: true,
        autoResize: true,
        height: 'auto',
        width: width,
        draggable: true,
        open: function (event, ui) {
          $(this).closest(".ui-dialog")
          .find(".ui-dialog-titlebar-close")
          .html("<span class='ui-button-icon-primary ui-icon ui-icon-closethick'></span>");
          $(event.target).dialog('widget')
            .css({position: 'fixed'})
            .position({my: 'right-173 top+120', at: 'right top', of: window, collision: 'none'});
          $('.ui-widget-overlay').bind('click', function () {
            if (confirm('Close this form?'))
              jQuery('#dialog-form').dialog('close');
          })
        }

      }
    );
  }
</script>
@endsection