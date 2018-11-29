$(document).ready(function () {
	$('#form_action').hide();

	$('#add_point').click(function() {
		$("#form_action").slideToggle();
	});

	$('#form_action #add').click(function() {
		point = $('#point').val();
		exam_day = $('#exam_day').val();
		student_code = $('#student_code').val();
		subject_code = $('#subject_code').val();
		
		if (subject_code == '0') {
			$('#subject_code').next().html('<span style="color: red">Vui lòng thêm môn học trước đã</span>');
		} else {
			$url = $('#form_add').attr('action');
			$.ajax({
                'url': $url,
                'type': 'post',
                'data': {
                  'point': point,
                  'exam_day': exam_day,
                  'subject_code': subject_code,
                  'student_code': student_code,
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
                  if (typeof(data) == 'object') {
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
		}

		return false;

	});
});