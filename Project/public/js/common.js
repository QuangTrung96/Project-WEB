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

var isShowingLoading = false;
function show_loading() {
  isShowingLoading = true;
  $('#modal').show();
}

function hide_loading() {
  isShowingLoading = false;
  $('#modal').hide();
}

function hideForm(id_form) {
  $('#'+id_form).hide();
  return false;
}