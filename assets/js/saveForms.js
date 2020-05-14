function genForm()
{
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
			event.preventDefault();
			return false;
	    }
	});

	var formName = $('.formName').val();

	$('.genFormSubmit').click(function() {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		var repData = $('form').serialize();
		var validate = checkRequired();

		if (validate == 1) {
			$('.genFormSubmit').attr('hidden', true);
			$('.loading-form').removeAttr('hidden', false);
			$('.loading-form').removeAttr('disabled', false);

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