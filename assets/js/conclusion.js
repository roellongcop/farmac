$('#conclusion-concern_id').change(function(e) {
	KTApp.block('.conditions-container', {
		overlayColor: '#000000',
		message: 'Please wait...',
		state: 'primary'
	})

	const id = $(this).val();

	$.ajax({
		url: app.baseUrl + 'concern/view',
		data: {
			slug: id,
			attribute: 'id'
		},
		dataType: 'json',
		success: (s) => {
			if (s.status == 'success') {
				$('.conditions-container').html(s.conclusion_input);
			}
			else {
				Swal.fire('Error', s.errorSummary, 'error');
			}
			KTApp.unblock('.conditions-container');
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
			KTApp.unblock('.conditions-container');
		}
	})
})

autosize($('textarea'));
