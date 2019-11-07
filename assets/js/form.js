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
			$('body').html(result);
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
	$('.namePart1').change(function(){
		var name = $(this).val();
		var loopIndex = $(this).closest('tr').find('input[class="loopIndex1"]').val();

		changeSex(name, loopIndex);
	});

	$('.namePart2').change(function(){
		var name = $(this).val();
		var loopIndex = $(this).closest('tr').find('input[class="loopIndex2"]').val();

		changeSex(name, loopIndex);
	});
}

function changeSex(name, index)
{
	$('.gender1').change(function(){
		var sex = $(this).val();
		if (sex === 'F' || sex === 'f' || sex === 'M' || sex === 'm') {
			$(this).closest('td').removeAttr('data-tip', 'Invalid Input!');
			$(this).closest('td').removeClass('has-duplicate');
			$(this).removeClass('has-duplicate');
			$('input[name="saveform1"]').removeAttr('disabled', 'disabled');

			if (sex === 'M' || sex === 'm') {
				gender = 1;
			} else if (sex === 'F' || sex === 'f') {
				gender = 2;
			}

			getSex(name, sex, index);
			getDate(name, gender, index);
		} else {
			alert('Invalid Input!');

			$('input[name="saveform1"]').attr('disabled', 'disabled');
			$(this).closest('td').attr('data-tip', 'Invalid Input!');
			$(this).closest('td').addClass('has-duplicate');
			$(this).addClass('has-duplicate');
		}
	});
}

function getSex(name, sex1, index)
{
	$('.gender2').change(function() {
		var sex2 = $(this).val();
		if (sex1 === 'F' || sex1 === 'f') {
			if (sex2 === 'M' || sex2 === 'm') {
				gender = 1;
				$(this).closest('td').removeAttr('data-tip', 'Invalid Input!');
				$(this).closest('td').removeClass('has-duplicate');
				$(this).removeClass('has-duplicate');
				$('input[name="saveform1"]').removeAttr('disabled', 'disabled');

				getDate(name, gender, index);
			} else {
				alert('Input value must be "M"');

				$('input[name="saveform1"]').attr('disabled', 'disabled');
				$(this).closest('td').attr('data-tip', 'Invalid Input!');
				$(this).closest('td').addClass('has-duplicate');
				$(this).addClass('has-duplicate');
			}
		} else if (sex1 === 'M' || sex1 === 'm') {
			if (sex2 === 'F' || sex2 === 'f') {
				gender = 2;
				$(this).closest('td').removeAttr('data-tip', 'Invalid Input!');
				$(this).closest('td').removeClass('has-duplicate');
				$(this).removeClass('has-duplicate');
				$('input[name="saveform1"]').removeAttr('disabled', 'disabled');

				getDate(name, gender, index);
			} else {
				alert('Input value must be "F"');

				$('input[name="saveform1"]').attr('disabled', 'disabled');
				$(this).closest('td').attr('data-tip', 'Invalid Input!');
				$(this).closest('td').addClass('has-duplicate');
				$(this).addClass('has-duplicate');
			}
		} else {
			alert('Invalid Input!');

			$('input[name="saveform1"]').attr('disabled', 'disabled');
			$(this).closest('td').attr('data-tip', 'Invalid Input!');
			$(this).closest('td').addClass('has-duplicate');
			$(this).addClass('has-duplicate');
		}
	});
}

function getDate(name, sex, index)
{
	var name = name;
	var nameArr = name.split(',');

	var firstname = nameArr[0];
	var surname = $.trim(nameArr[1]);
	var extname = $.trim(nameArr[2]);

	$('.bday1').change(function(){
		var bday1 = $(this).val();
		dob = new Date(bday1);
		var today = new Date();
		var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

		var dateArr = bday1.split('-');

		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);

		var bday = year + '-' + month + '-' + day;

		$(this).closest('td').find('.getAge1').val(age);

		$.post(base_url + '/forms/checkCoupleDuplicate', {
			'firstname' : firstname, 
			'surname' 	: surname, 
			'extname' 	: extname, 
			'sex' 		: sex, 
			'bday' 		: bday
		}).done(function(result){
			if(result === '1'){
				$('.tr1' + index).addClass('has-duplicate');
				$('.tr1' + index + ' td input').addClass('has-duplicate');
				$('input[name="saveform1"]').attr('disabled', 'disabled');
			} else {
				$('.tr1' + index).removeClass('has-duplicate');
				$('.tr1' + index + ' td input').removeClass('has-duplicate');
				$('input[name="saveform1"]').removeAttr('disabled', 'disabled');
			}
		});
	});

	$('.bday2').change(function(){
		var bday2 = $(this).val();
		dob = new Date(bday2);
		var today = new Date();
		var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

		var dateArr = bday2.split('-');

		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);

		var bday = year + '-' + month + '-' + day;

		$(this).closest('td').find('.getAge2').val(age);

		$.post(base_url + '/forms/checkCoupleDuplicate', {
			'firstname' : firstname, 
			'surname' 	: surname, 
			'extname' 	: extname, 
			'sex' 		: sex, 
			'bday' 		: bday
		}).done(function(result){
			if(result === '1'){
				$('.tr2' + index).addClass('has-duplicate');
				$('.tr2' + index + ' td input').addClass('has-duplicate');
				$('input[name="saveform1"]').attr('disabled', 'disabled');
			} else {
				$('.tr2' + index).removeClass('has-duplicate');
				$('.tr2' + index + ' td input').removeClass('has-duplicate');
				$('input[name="saveform1"]').removeAttr('disabled', 'disabled');
			}
		});
	});
}