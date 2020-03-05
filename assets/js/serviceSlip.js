var base_url = window.location.origin + '/rpfp';
$(function() {
	var FromEndDate = new Date();
    $('.date_visit').datepicker({
    	dateFormat: "mm/dd/yy",
    	maxDate: FromEndDate,
		changeYear: true
    });

	checkbox();
	saveServiceSlip();

	$(document).ready(function(){
		var coupleId = $('input[name="couple_id"]').val();
		var fpId = $('input[name="slip_id"]').val();

		if (coupleId == 0) {
			$('#service_slip input:not(.saveServiceSlip)').attr('disabled', 'disabled');
			$('.saveServiceSlip').css('display', 'none');

			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000
			});

			Toast.fire({
				type: 'warning',
				title: 'Save Form 1 before providing\nFP Service details.'
			});			
		} else {
			$('#service_slip input').removeAttr('disabled');
		}

		if (fpId != '') {
			$('.saveServiceSlip').css('display', 'none');
		}
	});
	  
});

function checkbox()
{
	$('.no5-input').attr('disabled', 'disabled');
	$('.date_method').prop('readonly', true);
	$('.no4-select').attr('disabled', 'disabled');
	
	$('.date_visit').change(function(){
		var dateVisit = $('.date_visit').val();
		$('.date_method').val(dateVisit);
	})

	
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

function checkRequired()
{
	var validate = 0;
	$.each($('#service_slip input').filter('[required]'), function(key, value) {
		var item = $(value).val();

		if (item == '') {
			validate = 0;
			$(value).addClass('required-field');
		} else {
			validate = 1;
			$(value).removeClass('required-field');
		}
	});

	if (validate == 1) {
		return validate;
	} else {
		validate = 0;
	}
}

function saveServiceSlip()
{
	var coupleId = $('input[name="couple_id"]').val();
	var fp_id = $('input[name="slip_id"]').val();

	$('.saveServiceSlip').click(function(event) {
		event.preventDefault();
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});
		
		var formData = $('#service_slip').serialize();
		var validate = checkRequired();

		if (validate != 1) {
			Toast.fire({
				type: 'error',
				title: 'Fill the required fields'
			});
		} else {
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
				} else if (fp_id != ''){
					Toast.fire({
						type: 'warning',
						title: 'Data Already Exist.'
					});
				} else if (coupleId == 0) {
					Toast.fire({
						type: 'warning',
						title: 'Save Form 1 before providing\nFP Service details.'
					});
				} else {
					Toast.fire({
						type: 'warning',
						title: 'No input data.'
					});
				}
			});
		}
	});

}