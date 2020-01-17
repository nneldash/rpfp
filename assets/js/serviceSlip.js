var base_url = window.location.origin + '/rpfp';
$(function() {
	  checkbox();
	  saveServiceSlip();

	  var coupleId = $('input[name="couple_id"]').val();

	  if (coupleId == 0) {
		$('input').attr('disabled', 'disabled');
	  } else {
		$('input').removeAttr('disabled');
	  }
});

function checkbox()
{
	$('.no5-input').attr('disabled', 'disabled');
	
	$('input[type="radio"]').click(function(){
		var thisRadio = $(this);

		if (thisRadio.hasClass('imChecked')) {
			thisRadio.removeClass('imChecked');
			thisRadio.prop('checked', false);
		} else {
			thisRadio.prop('checked', true);
			thisRadio.addClass('imChecked');
		}

		if ($('.fp_method').is(':checked')) {
			$('.provided_method').prop('checked', true);
			$('.no4-check').prop('checked', false);
			$('.counseling').prop('checked', false);
			$('.other_concerns').prop('checked', false);
			$('.no5-check').prop('checked', false);
			$('.no4-check').attr('disabled', 'disabled');
			$('.counseling').attr('disabled', 'disabled');
			$('.other_concerns').attr('disabled', 'disabled');
			$('.no4-select').attr('disabled', 'disabled');
			$('.no5-check').attr('disabled', 'disabled');
			$('.no5-input').attr('disabled', 'disabled');
		} else {
			$('.provided_method').prop('checked', false);
			$('.provided_method').attr('disabled', 'disabled');
			$('.no4-check').removeAttr('disabled');
			$('.counseling').removeAttr('disabled');
			$('.other_concerns').removeAttr('disabled');
			$('.no5-check').removeAttr('disabled');
			$('.no5-input').removeAttr('disabled');
		}

		if ($('.counseling').is(':checked')) {
			$('.other_concerns').prop('checked', false);
			$('.other_concerns').attr('disabled', 'disabled');
			$('.no4-check').attr('disabled', 'disabled');
			$('.no5-check').attr('disabled', 'disabled');
			$('.no5-input').attr('disabled', 'disabled');
		} else {
			$('.other_concerns').removeAttr('disabled');
			$('.no4-check').removeAttr('disabled');
			$('.no5-check').removeAttr('disabled');
			$('.no5-input').removeAttr('disabled');
		}

		if ($('.no4-check').is(':checked')) {
			$('.no4-select').removeAttr('disabled');
			$('.counseling').attr('disabled', 'disabled');
			$('.no5-input').attr('disabled', 'disabled');
		} else {
			$('.no4-select').attr('disabled', 'disabled');
			$('.no4-select').val('');
		}

		if ($('.no5-check').is(':checked')) {
			$('.counseling').attr('disabled', 'disabled');
			$('.no5-input').removeAttr('disabled');
		} else {
			$('.no5-input').attr('disabled', 'disabled');
		}
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
			if(result.is_save == 'added') {
				Toast.fire({
					type: 'success',
					title: 'Service Slip successfully saved!'
				});
			} else if (result.is_save == 'existed'){
				Toast.fire({
					type: 'warning',
					title: 'Data Already Exist.'
				});
			} else {
				Toast.fire({
					type: 'warning',
					title: 'No input data.'
				});
			}
		});
		return false;
	});

}