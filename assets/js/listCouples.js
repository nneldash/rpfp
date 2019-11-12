loadJs(base_url + 'NewAssets/templateJs', function() {
	loadJs(base_url + 'NewAssets/bootstrapJs', function() {
		listCoupleModal();
	});
});

function listCoupleModal()
{
	$('.btn-pending-listing').click(function(event) {
		event.preventDefault();

		var classNo = $(this).parent().siblings(':first').text();
		$('.modal-title').text(classNo);

		$('#coupleModal').modal();

		$.post(base_url + 'menu/pendingCoupleModal', {'classId' : classNo})
		.done(function(html){
			$('.modal-body').html(html);
		});
	});

	$('.btn-approve-listing').click(function(event) {
		event.preventDefault();

		var classNo = $(this).parent().siblings(':first').text();
		$('.modal-title').text(classNo);

		$('#coupleModal').modal();

		$.post(base_url + '/menu/approveCoupleModal', {'classId' : classNo})
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}