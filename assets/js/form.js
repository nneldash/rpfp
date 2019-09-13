var base_url = window.location.origin + '/rpfp';
$(function() {
  	serviceModal();
  	importModal();
  	highlight();
	saveForm1();
	saveServiceSlip();
	inputValid();
	inputValidations();
	checkBox();
});

function serviceModal()
{
	$('.btn-slip').click(function() {
		$.post(base_url + '/forms/serviceSlip')
		.done(function(html){
			$('#menuModal').modal();
			$('#menuModal').find('.modal-body').html(html);
		});
	});
}

function importModal() 
{
	$('.btn-import').click(function() {
		$.post(base_url + '/menu/importExcel')
		.done(function(html){
			$('#importModal').modal();
			$('#importModal').find('.modal-body').html();
		});
	});
}

function highlight()
{
	$('td:first-child input[value="aproveCouple"]').change(function() {
    	$(this).closest('tr').toggleClass("highlight", this.checked);
    	$(this).closest('tr').next('tr').toggleClass("highlight", this.checked);
  	});
}

function inputValid() 
{
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
	$('#form_validation').submit(function() {
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
	$('#service_slip').submit(function() {
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
	});

}

function inputValidations()
{
	$('.sexValid').keyup(function(){
		var input = this.value;
		// console.log(input);
		if(input != 'm' || input != 'f' || input != 'M' || input != 'F') {
			alert('huhu');
		} else {
			alert('okay');
		}
	});
}

function checkBox()
{
	$('#checkAll').click(function() {
        var checked = $(this).prop('checked');
        $('.approveCheck').find('.check').prop('checked', checked);
    	$('td:first-child input[value="aproveCouple"]').closest('tr').toggleClass("highlight", this.checked);
    	$('td:first-child input[value="aproveCouple"]').closest('tr').next('tr').toggleClass("highlight", this.checked);
    });
}