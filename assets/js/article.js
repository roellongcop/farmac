$('.btn-save-content').click(function() {
	$('#form-content').submit();
});


$('#tbl-contents').DataTable({
    // pageLength: {$pageLength},
    order: [[0, 'desc']]
});
