var base_url = window.location.origin + '/rpfp';
$(function() {
	  checkbox();
	  saveServiceSlip();
});

function checkbox()
{
	if ($('.no4-check').is(':checked')) {
		$('.no4-select').removeAttr('disabled');
		$('.no5-input').attr('disabled', 'disabled');
	} else {
		$('.no4-select').attr('disabled', 'disabled');
	}

	$('input[type=radio]').click(function(){
		if ($('.no4-check').is(':checked')) {
			$('.no4-select').removeAttr('disabled');
		} else {
			$('.no4-select').attr('disabled', 'disabled');
			$(".no4-select").val("");
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
			} else {
				Toast.fire({
					type: 'error',
					title: 'Data Already Exist.'
				});
			}
		});
		return false;
	});

}