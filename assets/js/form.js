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

	Inputmask().mask(".birthAge");
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
			$('body').html(result);return false;
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
		var bday1 = 'input[name="age1['+ i +']';

		var that2 = 'input[name="name_participant2['+ i +']';
		var bday2 = 'input[name="age2['+ i +']';

		// $(that1).change(function() {
		// 	var name = this.value;
		// 	var nameArr = name.split(',');
		// 	var bday = $(this).closest('td').find(bday1).val();

		// 	alert(nameArr[0]);
		// 	alert(nameArr[1]);
		// 	alert(nameArr[2]);
		// 	alert(bday);

		// 	$.post(base_url + 'forms/checkFemaleDuplicate')
		// 	.done(function(result) {
		// 		// alert(result);
		// 	});

		// 	$.post(base_url + 'forms/checkMaleDuplicate')
		// 	.done(function(result) {
		// 		// alert(result);
		// 	});
		// });

		$(bday1).change(function() {
			// var name = $(this).closest('tr').find(that1).text();
			// var name = $(this).closest('tr.approveCheck:nth-child(1)').find('input.firstTd');
			var name = $(this).find('tr:eq(1) ' + that1).val();
			// var nameArr = name.split(',');

			// var name = $(this);

			var bday = this.value;
			var dateArr = bday.split('/');

			alert(name.value);
			alert(dateArr[0]);
			// alert(nameArr[0]);
			// alert(nameArr[1]);
			// alert(nameArr[2]);
		});

		// $(that2).keydown(function() {
		// 	var fname = $('input[name="name_participant2['+ i +']"]').val();

		// 	$(this).closest('td').attr('data-tip', 'Duplicate Entry');
		// 	$(this).closest('td').addClass('has-duplicate');
		// 	$(this).addClass('has-duplicate');
			
		// 	$.post(base_url + 'forms/checkDuplicate')
		// 	.done(function(result){
		// 		// alert(result);
		// 	});
		// });

		// $(bday2).change(function() {
		// 	var bday = this.value;
		// 	var dateArr = bday.split('/');

		// 	alert(dateArr[0]);
		// });
	}
}