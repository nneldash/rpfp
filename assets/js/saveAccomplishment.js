function genAccomp()
{
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
			event.preventDefault();
			return false;
	    }
	});

	$('.genAccompSubmit').click(function() {	
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		var accompData = $('form').serialize();
		var validate = checkRequired();

		if (validate == 1) {
			$('.genAccompSubmit').attr('hidden', true);
			$('.loading-accomp').removeAttr('hidden', false);
			$('.loading-accomp').removeAttr('disabled', false);

			$.ajax({
				type: 'POST',
				data: accompData,
				url: base_url + 'accomplishment/genAccompData'
			}).done(function(result){
				if(result.is_save == true) {
					Swal.fire({
						type: 'success',
						text: 'Accomplishment Report successfully saved!',
						showCancelButton: false,
						showConfirmButton: false
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
		} else {
			Toast.fire({
				type: 'error',
				title: 'Fill the required fields'
			}); 
		}
	});
}

function checkRequired()
{
	var validate = 0;

	$.each($('input').filter('[required]'), function(key, value) {
		var item = $(value).val();

		if (item == '') {
			validate = 0;	
		} else {
			validate = 1;
		}
	});
	
	return validate;
}
