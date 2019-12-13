$(function(){
	genAccomp();
});

function genAccomp()
{
	$('.genAccompSubmit').click(function() {
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
			url: base_url + '/accomplishment/genAccompData'
		}).done(function(result){
			if(result.is_save == true) {
				Toast.fire({
					type: 'success',
					title: 'Accomplishment Report successfully saved!'
				});
				$('#generateReportModal').modal('hide');
			} else {
				Toast.fire({
					type: 'error',
					title: 'An error occurred.'
				});
			}
		});
		// ajax.reload();
		return false;
	});
}