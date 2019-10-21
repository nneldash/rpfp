/** PREVENT SAVE FORM UPON CLICK OF SERVICE SLIP */
var base_url = window.location.origin + '/rpfp';

$(function() {
  	serviceModal();
  	importModal();
  	highlight();
	inputValid();
	saveForm1();
	checkBox();

	checkDuplicate();
});

function serviceModal()
{
	$('.btn-slip').click(function(event) {
		event.preventDefault();
		$('#menuModal').modal();
		$.post(base_url + '/forms/serviceSlip')
		.done(function(html){
			$('#menuModal .modal-body').html(html);
		});
	});
}

function importModal() 
{
	$('.btn-import').click(function(event) {
		event.preventDefault();
		$('#importModal').modal();
		$.post(base_url + '/menu/importExcel')
		.done(function(html){
			$('#importModal .modal-body').html(html);
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
	$('.saveForm1').click(function() {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});
		
		var formData = $('#form_validation').serialize();
		
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

function checkBox()
{
	$('#checkAll').click(function() {
        var checked = $(this).prop('checked');
        $('.approveCheck').find('.check').prop('checked', checked);
    	$('td:first-child input[value="aproveCouple"]').closest('tr').toggleClass("highlight", this.checked);
    	$('td:first-child input[value="aproveCouple"]').closest('tr').next('tr').toggleClass("highlight", this.checked);
    });
}

function checkDuplicate()
{
	var i;
	for (i = 0; i < 10; i++) {
		var that1 = 'input[name="name_participant1['+ i +']';
		var that2 = 'input[name="name_participant2['+ i +']';
		$(that1).keydown(function(){
			var fname = $('input[name="name_participant1['+ i +']"]').val();

			$(this).closest('td').attr('data-tip', 'Duplicate Entry');
			$(this).closest('td').addClass('has-duplicate');
			$(this).addClass('has-duplicate');
			
			$.post(base_url + 'forms/checkDuplicate')
			.done(function(result){
				// alert(result);
			});
		});

		$(that2).keydown(function(){
			var fname = $('input[name="name_participant2['+ i +']"]').val();

			$(this).closest('td').attr('data-tip', 'Duplicate Entry');
			$(this).closest('td').addClass('has-duplicate');
			$(this).addClass('has-duplicate');
			
			$.post(base_url + 'forms/checkDuplicate')
			.done(function(result){
				// alert(result);
			});
		});
	}
}