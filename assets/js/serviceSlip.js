var base_url = window.location.origin + '/rpfp';
$(function() {
	  checkbox();
	  saveServiceSlip();
});

function checkbox()
{
	if ($('.no4-check').is(':checked')) {
		$('.no4-input').removeAttr('disabled');
		$('.no5-input').attr('disabled', 'disabled');
	} else {
		$('.no4-input').attr('disabled', 'disabled');
	}

	$('input[type=radio]').click(function(){
		if ($('.no4-check').is(':checked')) {
			$('.no4-input').removeAttr('disabled');
		} else {
			$('.no4-input').attr('disabled', 'disabled');
			$(".no4-input").val("");
		}
		
		$('.no5-input').attr('disabled', 'disabled');
		$(".no5-input").val("");
	});
}

function saveServiceSlip()
{
	$('.saveServiceSlip').click(function() {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		var formData = $('#service_slip').serialize();

		$.ajax({
			type: 'POST',
			data: formData,
			url: base_url + '/forms/saveServiceSlip'
		}).done(function(result){
			if(result.is_save == true) {
				Toast.fire({
					type: 'success',
					title: 'Service Slip successfully saved!'
				});
				// alert('Nixie, ayaw gumana nung Toast.fire');
			} else {
				Toast.fire({
					type: 'error',
					title: 'An error occurred.'
				});
				// alert('Nixie, ayaw gumana nung Toast.fire');
			}
		});
		return false;
	});

}