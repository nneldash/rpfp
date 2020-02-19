$(function(){
	genForm();
});

function genForm()
{
	var formName = $('.formName').val();

	$('.genFormSubmit').click(function() {
		$('.genFormSubmit').attr('hidden', true);
		$('.loading-form').removeAttr('hidden', false);

		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		var repData = $('form').serialize();

		$.ajax({
			type: 'POST',
			data: repData,
			url: base_url + 'FormGeneration/' + formName
		}).done(function(result){
			if(result.is_save == true) {
				Toast.fire({
					type: 'success',
					title: 'Report successfully saved!'
				});
				$('#generateReportModal').modal('hide');
				location.reload();
			} else {
				Toast.fire({
					type: 'error',
					title: 'An error occurred.'
				});
			}
		});

		return false;
	});

}