function loadForm(id_form) {
	$idForm = $('#' + id_form);
	if ($idForm.is(':hidden')) {
		$idForm.fadeIn('fast');
	} else {
		if (id_form != 'edit_scho' && id_form != 'edit_seme') {
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
	$('#' + id_form).hide();
	return false;
}

var showGoToTop = 300;

$(window).scroll(function () {
	if ($(this).scrollTop() >= showGoToTop) {
		$('#go-to-top').fadeIn();
	} else {
		$('#go-to-top').fadeOut();
	}
});

$('#go-to-top').click(function () {
	$('html, body').animate({
		scrollTop: 0
	}, 'fast');
});