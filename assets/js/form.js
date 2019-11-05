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

	// for (i = 0; i < 10; i++) {
	// 	var sex1 = 'input[name="sex1['+ i +']';
	// 	var sex2 = 'input[name="sex2['+ i +']';
	// 	var bday1 = 'input[name="age1['+ i +']';
	// 	var bday2 = 'input[name="age2['+ i +']';

	// 	$(sex1).change(function() {
	// 		changeSex();
	// 	});

	// 	$(sex2).change(function() {
	// 		getSex();
	// 	});

	// 	$(bday1).change(function() {
	// 		getDate();
	// 	});

	// 	$(bday2).change(function() {
	// 		getDate();
	// 	});
	// }

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
	var i;
	for (i = 0; i < 10; i++) {
		var that1 = 'input[name="name_participant1['+ i +']';
		var that2 = 'input[name="name_participant2['+ i +']';

		$(that1).change(function() {
			var name = this.value;
			changeSex(name);
		});		

		$(that2).change(function() {
			var name = this.value;
			getSex(name);
		});
	}
}

function changeSex(name)
{
	var i;
	for (i = 0; i < 10; i++) {
		var sex1 = 'input[name="sex1['+ i +']';	

		$(sex1).change(function() {
			var sex = this.value;
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

				getSex(name, sex);
				getDate(name, gender);
			} else {
				alert('Invalid Input!');

				$('input[name="saveform1"]').attr('disabled', 'disabled');
				$(this).closest('td').attr('data-tip', 'Invalid Input!');
				$(this).closest('td').addClass('has-duplicate');
				$(this).addClass('has-duplicate');
			}
		});
	}
}

function getSex(name, sex1)
{
	var i;
	for (i = 0; i < 10; i++) {
		var sex2 = 'input[name="sex2['+ i +']';

		$(sex2).change(function() {
			var sex2 = this.value;
			if (sex1 === 'F' || sex1 === 'f') {
				if (sex2 === 'M' || sex2 === 'm') {
					gender = 1;
					$(this).closest('td').removeAttr('data-tip', 'Invalid Input!');
					$(this).closest('td').removeClass('has-duplicate');
					$(this).removeClass('has-duplicate');
					$('input[name="saveform1"]').removeAttr('disabled', 'disabled');

					getDate(name, gender);
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

					getDate(name, gender);
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
}

function getDate(nameArr1, sex)
{
	var i;
	for (i = 0; i < 10; i++) {
		var bday1 = 'input[name="age1['+ i +']';
		var bday2 = 'input[name="age2['+ i +']';

		var name = nameArr1;
		var nameArr = name.split(',');

		var firstname = nameArr[0];
		var surname = $.trim(nameArr[1]);
		var extname = $.trim(nameArr[2]);

		$(bday1).change(function() {
			var bday = this.value;
			var bdayAge = bday.split('/');
			var dateArr = bdayAge[0].split('-');

			var month = $.trim(dateArr[0]);
			var day = $.trim(dateArr[1]);
			var year = $.trim(dateArr[2]);

			var bday = dateArr[2] + '-' +dateArr[0] + '-' + dateArr[1];

			$.post(base_url + '/forms/checkCoupleDuplicate', {
				'firstname' : firstname, 
				'surname' : surname, 
				'extname' : extname, 
				'sex' : sex, 
				'bday' : bday
			}).done(function(result){
				duplicate(result, bday1);
			});
		});
	}
}

function duplicate(result, thisProp)
{
	$('#isDuplicate').val(result);
	var val = $('#isDuplicate').val();

	alert(thisProp);

	if(val === 1){
		$(this).closest('.approveCheck').attr('data-tip', 'Duplicate Entry');
		$(this).closest('.approveCheck').addClass('has-duplicate');
		$(this).addClass('has-duplicate');
		$('input[name="saveform1"]').removeAttr('disabled', 'disabled');
	} else {
		$('#isDuplicate').closest('tr').removeAttr('data-tip', 'Duplicate Entry');
		$('#isDuplicate').closest('tr').removeClass('has-duplicate');
		$('#isDuplicate').removeClass('has-duplicate');
	}
}