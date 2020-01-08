/** PREVENT SAVE FORM UPON CLICK OF SERVICE SLIP */
$(document).ready(function(){
	$('#provinceList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var provinceId = $(this).find('option:selected').val();
		$('#muniList').find('option').remove();
		$('#muniList').selectpicker('refresh');
		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getMunicipalities(provinceId);
	});


	$('#muniList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var muniId = $(this).find('option:selected').val();
		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getBrgys(muniId);
	});
});


$(function() {
  	serviceModal();
  	importModal();
  	highlight();
	inputValid();
	saveForm1();
	checkBox();
	traditionalStatus();
	getDataDuplicate();
	getProvinces();

	Inputmask().mask(".birthAge");

	var isRDM = $('#rdm').val();
	var isFocal = $('#focal').val();

    $('.selectpicker').selectpicker({
    	container: 'body'
    });

    if(isFocal == 1){
    	$('td input').attr('disabled', true);
		$('td input').css('cursor', 'not-allowed');
		$('td textarea').attr('disabled', true);
		$('td textarea').css('cursor', 'not-allowed');
		$('td select').attr('disabled', true);
		$('td select').css('cursor', 'not-allowed');
		$('td input[class="check"]').attr('disabled', false);
		$('.saveForm1').attr('hidden', true);
    }

	if(isRDM == 1){
		$('td input').attr('disabled', true);
		$('td input').css('cursor', 'not-allowed');
		$('td textarea').attr('disabled', true);
		$('td textarea').css('cursor', 'not-allowed');
		$('td select').attr('disabled', true);
		$('td select').css('cursor', 'not-allowed');
		$('td input[class="check"]').attr('disabled', false);
	}
});

function getProvinces()
{
	$.ajax({
			type: 'POST',
			cache: true,
			url: base_url + 'location/getProvinces'
	}).done(function(result){
		var data = result.LOCATION_LIST;

		$.each(data, function(i, text){
			$('#provinceList').append(new Option(data[i].LOCATION_DESCRIPTION, data[i].PROVINCE));
		});

		$('#provinceList').selectpicker('render').selectpicker('refresh');
	});
}

function getMunicipalities(provinceId)
{
	$.ajax({
			type: 'POST',
			cache: true,
			url: base_url + 'location/getMunicipalities',
			data: { 'PROVINCE' : provinceId }
	}).done(function(result){
		var data = result.LOCATION_LIST;

		$.each(data, function(i, text){
			$('#muniList').append(new Option(data[i].LOCATION_DESCRIPTION, data[i].MUNICIPALITY));
		});

		$('#muniList').selectpicker('render').selectpicker('refresh');
	});
}

function getBrgys(muniId)
{
	$.ajax({
			type: 'POST',
			cache: true,
			url: base_url + 'location/getBarangays',
			data: { 'MUNICIPALITY' : muniId }
	}).done(function(result){
		var data = result.LOCATION_LIST;

		$.each(data, function(i, text){
			$('#brgyList').append(new Option(data[i].LOCATION_DESCRIPTION, data[i].MUNICIPALITY));
		});

		$('#brgyList').selectpicker('render').selectpicker('refresh');
	});
}

function traditionalStatus()
{
	$('.status-trad').keyup(function(){
		var stat = $(this).val();
		var stat = stat.toUpperCase();
		var index = $(this).closest('tr').find('input[name="slipIndex"]').val();

		if (stat === 'A') {
			$(this).closest('tr').find('input[name="status_intention['+ index +']"]').removeAttr('disabled', 'disabled');
		} else {
			$(this).closest('tr').find('input[name="status_intention['+ index +']"]').attr('disabled', 'disabled');
		}
	});
}

function getDataDuplicate()
{
	var row1 = 1;
	var row2 = 2;

	$('.fname1').keyup(function(){
		var fname = $(this).val();
		var lname = $(this).closest('tr').find('.lname1').val();
		var extname = $(this).closest('tr').find('.extname1').val();
		var sex = $(this).closest('tr').find('.gender1').val();
		var sex = sex.toUpperCase();
		
		var bday = $(this).closest('tr').find('.bday1').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname, lname, extname, sex, bday, index, row1);
	});

	$('.lname1').keyup(function(){
		var lname = $(this).val();
		var fname = $(this).closest('tr').find('.fname1').val();
		var extname = $(this).closest('tr').find('.extname1').val();
		var sex = $(this).closest('tr').find('.gender1').val();
		var sex = sex.toUpperCase();
		
		var bday = $(this).closest('tr').find('.bday1').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname, lname, extname, sex, bday, index, row1);
	});

	$('.extname1').keyup(function(){
		var extname = $(this).val();
		var fname = $(this).closest('tr').find('.fname1').val();
		var lname = $(this).closest('tr').find('.lname1').val();
		var sex = $(this).closest('tr').find('.gender1').val();
		var sex = sex.toUpperCase();
		
		var bday = $(this).closest('tr').find('.bday1').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname, lname, extname, sex, bday, index, row1);
	});

	$('.gender1').keyup(function(){
		var sex = $(this).val();
		var sex = sex.toUpperCase();
		var fname = $(this).closest('tr').find('.fname1').val();
		var lname = $(this).closest('tr').find('.lname1').val();
		var extname = $(this).closest('tr').find('.extname1').val();
		
		var bday = $(this).closest('tr').find('.bday1').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname, lname, extname, sex, bday, index, row1);
	});

	$('.bday1').keyup(function(){
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

		var index = $(this).closest('tr').find('.loopIndex1').val();
		var fname = $(this).closest('tr').find('.fname1').val();
		var lname = $(this).closest('tr').find('.lname1').val();
		var extname = $(this).closest('tr').find('.extname1').val();
		var sex = $(this).closest('tr').find('.gender1').val();
		var sex = sex.toUpperCase();
		
		autoGetData(fname, lname, extname, sex, bday, index, row1);
	});

	$('.fname2').keyup(function(){
		var fname = $(this).val();
		var lname = $(this).closest('tr').find('.lname2').val();
		var extname = $(this).closest('tr').find('.extname2').val();
		var sex = $(this).closest('tr').find('.gender2').val();
		var sex = sex.toUpperCase();
		
		var bday = $(this).closest('tr').find('.bday2').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;
		
		var index = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname, lname, extname, sex, bday, index, row2);
	});

	$('.lname2').keyup(function(){
		var lname = $(this).val();
		var fname = $(this).closest('tr').find('.fname2').val();
		var extname = $(this).closest('tr').find('.extname2').val();
		var sex = $(this).closest('tr').find('.gender2').val();
		var sex = sex.toUpperCase();
		
		var bday = $(this).closest('tr').find('.bday2').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;

		var index = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname, lname, extname, sex, bday, index, row2);
	});

	$('.extname2').keyup(function(){
		var extname = $(this).val();
		var fname = $(this).closest('tr').find('.fname2').val();
		var lname = $(this).closest('tr').find('.lname2').val();
		var sex = $(this).closest('tr').find('.gender2').val();
		var sex = sex.toUpperCase();
		
		var bday = $(this).closest('tr').find('.bday2').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;

		var index = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname, lname, extname, sex, bday, index, row2);
	});

	$('.gender2').keyup(function(){
		var sex = $(this).val();
		var sex = sex.toUpperCase();
		var fname = $(this).closest('tr').find('.fname2').val();
		var lname = $(this).closest('tr').find('.lname2').val();
		var extname = $(this).closest('tr').find('.extname2').val();
		
		var bday = $(this).closest('tr').find('.bday2').val();
		var dateArr = bday.split('-');
		var month = $.trim(dateArr[0]);
		var day = $.trim(dateArr[1]);
		var year = $.trim(dateArr[2]);
		var bday = year + '-' + month + '-' + day;

		var index = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname, lname, extname, sex, bday, index, row2);
	});

	$('.bday2').keyup(function(){
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

		var index = $(this).closest('tr').find('.loopIndex2').val();
		var fname = $(this).closest('tr').find('.fname2').val();
		var lname = $(this).closest('tr').find('.lname2').val();
		var extname = $(this).closest('tr').find('.extname2').val();
		var sex = $(this).closest('tr').find('.gender2').val();
		var sex = sex.toUpperCase();
		
		autoGetData(fname, lname, extname, sex, bday, index, row2);
	});
}

function autoGetData(fname, lname, extname, sex, bday, index, row)
{
	if (sex === 'F') {
		sex = 2;
	} else if(sex === 'M') {
		sex = 1;
	} else {
		sex = 0;
	}

	$.post(base_url + 'forms/checkCoupleDuplicate', {
		'firstname' : fname, 
		'surname' 	: lname, 
		'extname' 	: extname, 
		'sex' 		: sex, 
		'bday' 		: bday
	}).done(function(result){
		console.log(result);		
		if (result === '1') {
			$('.tr'+ row + + index + ' td').addClass('has-duplicate');
			$('.tr'+ row + + index + ' td input').addClass('has-duplicate');
			$('.tr'+ row + + index + ' td textarea').addClass('has-duplicate');
		} else {
			$('.tr'+ row + + index + ' td').removeClass('has-duplicate');
			$('.tr'+ row + + index + ' td input').removeClass('has-duplicate');
			$('.tr'+ row + + index + ' td textarea').removeClass('has-duplicate');
		}
	});
}

function serviceModal()
{
	$('.btn-slip').click(function(event) {
		event.preventDefault();
		$('#menuModal').modal();
		
		var coupleId = $(this).attr('data-couple');
		var index =  $(this).closest('tr').find('input[name="slipIndex"]').val();
		var lastName = $(this).closest('tr').find('textarea[name="lastname1['+index+']"]').val();

		if(lastName != '') {
			lastName = $(this).closest('tr').find('textarea[name="lastname1['+index+']"]').val() + ',';
		}

		var firstName = $(this).closest('tr').find('textarea[name="firstname1['+index+']"]').val();
		var middleName = $(this).closest('tr').find('textarea[name="middlename1['+index+']"]').val();
		var coupleName = lastName + ' ' + firstName + ' ' + middleName;

		var house_no_st = $(this).closest('tr').find('input[name="house_no_st['+index+']"]').val();
		var brgy = $(this).closest('tr').find('input[name="brgy['+index+']"]').val();
		var city = $(this).closest('tr').find('input[name="city['+index+']"]').val();
		var address =  house_no_st + ' ' + brgy + ' ' + city;

		$.post(base_url + '/forms/serviceSlip', {'couple_id' : coupleId, 'couple_name' : coupleName, 'address' : address})
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

// change the codes

// function changeSex(name, index)
// {
// 	$('.gender1').change(function(){
// 		var sex = $(this).val();
// 		var sex = sex.toUpperCase();

// 		if (sex === 'F' || sex === 'M') {
// 			$('.tr2' + index + ' td .getSex1').val(sex);

// 			$(this).closest('td').removeAttr('data-tip', 'Invalid Input!');
// 			$(this).closest('td').removeClass('has-duplicate');
// 			$(this).removeClass('has-duplicate');
			
// 			if (sex === 'M') {
// 				gender = 1;
// 			} else if (sex === 'F') {
// 				gender = 2;
// 			}

// 			getDate1(name, gender, index);
// 		} else {
// 			alert('Invalid Input!');

// 			$(this).closest('td').attr('data-tip', 'Invalid Input!');
// 			$(this).closest('td').addClass('has-duplicate');
// 			$(this).addClass('has-duplicate');
// 		}
// 	});
// }

// function getSex(name, index)
// {
// 	var sex1 = $('.tr2' + index + ' td .getSex1').val();

// 	$('.gender2').keyup(function() {
// 		var sex2 = $(this).val();
// 		var sex2 = sex2.toUpperCase();
// 		if (sex1 === 'F') {
// 			if (sex2 === 'M') {
// 				gender = 1;
// 				$(this).closest('td').removeAttr('data-tip', 'Invalid Data!');
// 				$(this).closest('td').removeClass('has-duplicate');
// 				$(this).removeClass('has-duplicate');

// 				getDate2(name, gender, index);
// 			} else {
// 				alert('Data value must be "M"');

// 				$(this).closest('td').attr('data-tip', 'Invalid Data!');
// 				$(this).closest('td').addClass('has-duplicate');
// 				$(this).addClass('has-duplicate');
// 			}
// 		} else if (sex1 === 'M') {
// 			if (sex2 === 'F') {
// 				gender = 2;
// 				$(this).closest('td').removeAttr('data-tip', 'Invalid Data!');
// 				$(this).closest('td').removeClass('has-duplicate');
// 				$(this).removeClass('has-duplicate');

// 				getDate2(name, gender, index);
// 			} else {
// 				alert('Data value must be "F"');

// 				$(this).closest('td').attr('data-tip', 'Invalid Data!');
// 				$(this).closest('td').addClass('has-duplicate');
// 				$(this).addClass('has-duplicate');
// 			}
// 		} else {
// 			alert('Invalid Data!');

// 			$(this).closest('td').attr('data-tip', 'Invalid Data!');
// 			$(this).closest('td').addClass('has-duplicate');
// 			$(this).addClass('has-duplicate');
// 		}
// 	});
// }