function genAccomp()
{
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
			event.preventDefault();
			return false;
	    }
	});

	$('.genAccompSubmit').click(function() {
		$('.genAccompSubmit').attr('hidden', true);
		$('.loading').removeAttr('hidden', false);
		$('.loading').removeAttr('disabled', false);
		
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		var accompData = $('form').serialize();

		$.ajax({
			type: 'POST',
			data: accompData,
			url: base_url + 'accomplishment/genAccompData'
		}).done(function(result){
			if(result.is_save == true) {
				Toast.fire({
					type: 'success',
					title: 'Accomplishment Report successfully saved!'
				});
				$('#generateReportModal').modal('hide');
				location.reload();
			} else {
				Toast.fire({
					type: 'error',
					title: 'No data to generate.'
				});
				$('#generateReportModal').modal('hide');
			}
		});
		return false;
	});
}