var base_url = window.location.origin + '/rpfp';
$(function() {
	saveForm1();
	saveServiceSlip();
});

function saveForm1()
{
	$('#form_validation').submit(function(){
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});
		
		var formData = $(this).serialize();
		
		$.ajax({
			type: 'POST',
			data: formData,
			url: base_url + '/forms/saveForm1'
		}).done(function(result){
			if(result == '1') {
				Toast.fire({
					type: 'success',
					title: 'Form 1 successfully saved!'
				});
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

function saveServiceSlip()
{
	$('.saveServiceSlip').click(function(){
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		Toast.fire({
			type: 'success',
			title: 'Service Slip successfully saved!'
		});

		return false;
	});

}