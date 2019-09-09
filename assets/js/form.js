var base_url = window.location.origin + '/rpfp';
$(function() {
	$('.btn-slip').click(function(){
		$.post(base_url + '/forms/serviceSlip')
		.done(function(html){
			$('#menuModal').modal();
			$('#menuModal').find('.modal-body').html(html);
		});
	});

	saveForm1();
	saveServiceSlip();
	inputValid();

	

});

function inputValid() {
	if ($('#others').is(':checked')) {
		$('.disabled-others').removeAttr('disabled');
	} else {
		$('.disabled-others').attr('disabled', 'disabled');
	}

	$('input[type=radio]').click(function(){
		if ($('#others').is(':checked')) {
			$('.disabled-others').removeAttr('disabled');
		} else {
			$('.disabled-others').attr('disabled', 'disabled');
			$(".disabled-others").val("");
		}
	});
}

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
			if(result.is_save == true) {
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
	$('#service_slip').submit(function(){
		var formData = $(this).serialize();
		
		$.ajax({
			type: 'POST',
			data: formData,
			url: base_url + '/forms/saveServiceSlip'
		}).done(function(result){
			if(result.is_save == true) {
				alert('Nixie, ayaw gumana nung Toast.fire');
			} else {
				alert('Nixie, ayaw gumana nung Toast.fire');
			}
		});
		return false;
	})

}