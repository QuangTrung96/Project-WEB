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

$(document).ready(function () {

	$('#add_form').on('submit', function(e) {
    e.preventDefault();
    $subject_code = $('#subject_code').val();
    $student_code = $('student_code').val();
    $point = $('point').val();
    $exam_day = $('exam_day').val();

    $url = $('#add_form').attr('action');
    $.ajax({
      'url': $url,
      'type': 'post',
      'data': {
        'subject_code': $subject_code,
        '_token': '{{ csrf_token() }}'
      },
      'async': true,
      'timeout': 10000,
      'success': function(data) {
        if (typeof(data) == 'object') {
          alert('111');
        } else {
            alert('222');
          }
      }
    });
  });
});