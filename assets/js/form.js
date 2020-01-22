/** PREVENT SAVE FORM UPON CLICK OF SERVICE SLIP */
$(document).ready(function(){
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
			event.preventDefault();
			return false;
	    }
	});

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

var getProv = $('input[name="province"]').val();
var getCity = $('input[name="city"]').val();
var getBrgy = $('input[name="barangay"]').val();
var isRDM = $('#rdm').val();
var isFocal = $('#focal').val();

$(function() {
  	serviceModal();
  	importModal();
  	highlight();
	inputValid();
	saveForm1();
	checkBox();
	getDataDuplicate();
	getProvinces();
	isApprove();
	sexValidation();
	civilStatusValidation();
	educationValidation();
	methodValidation();
	typeValidation();
	statusValidation();
	intentionStatusValidation();
	reasonValidation();

	Inputmask().mask(".birthAge");	

    $('.selectpicker').selectpicker({
    	container: 'body'
    });

	if(isRDM == 1 || isFocal == 1){
		$('td input').attr('disabled', true);
		$('td input').css('cursor', 'not-allowed');
		$('td textarea').attr('disabled', true);
		$('td textarea').css('cursor', 'not-allowed');
		$('td select').attr('disabled', true);
		$('td select').css('cursor', 'not-allowed');
		$('td input[class="check"]').attr('disabled', false);
	}
});

function sexValidation()
{
	$('.gender1').keydown(function(event){
		if(!(event.keyCode == 70 || event.keyCode == 77 || event.keyCode == 8 || event.keyCode == 9) ) {
			event.preventDefault();
			return false;
	    }
	});

	$('.gender2').keydown(function(event){
		if(!(event.keyCode == 70 || event.keyCode == 77 || event.keyCode == 8 || event.keyCode == 9) ) {
			event.preventDefault();
			return false;
	    }
	});
}

function civilStatusValidation()
{
	$('.civil1').keydown(function(event){
		if(!(event.keyCode == 49 || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});

	$('.civil2').keydown(function(event){
		if(!(event.keyCode == 49 || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});
}

function educationValidation()
{
	$('.education1').keydown(function(event){
		if(!(event.keyCode == 49 || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 54  ||
			event.keyCode == 55  ||
			event.keyCode == 56  ||
			event.keyCode == 57  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 102 ||
			event.keyCode == 103 ||
			event.keyCode == 104 ||
			event.keyCode == 105 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});

	$('.education2').keydown(function(event){
		if(!(event.keyCode == 49 || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 54  ||
			event.keyCode == 55  ||
			event.keyCode == 56  ||
			event.keyCode == 57  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 102 ||
			event.keyCode == 103 ||
			event.keyCode == 104 ||
			event.keyCode == 105 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});
}

function methodValidation()
{
	$('.method8').keydown(function(event){
		if(!(event.keyCode == 48 ||
			event.keyCode == 49  || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 54  ||
			event.keyCode == 55  ||
			event.keyCode == 56  ||
			event.keyCode == 57  ||
			event.keyCode == 96  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 102 ||
			event.keyCode == 103 ||
			event.keyCode == 104 ||
			event.keyCode == 105 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});

	$('.method9').keydown(function(event){
		if(!(event.keyCode == 48 ||
			event.keyCode == 49  || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 54  ||
			event.keyCode == 55  ||
			event.keyCode == 56  ||
			event.keyCode == 57  ||
			event.keyCode == 96  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 102 ||
			event.keyCode == 103 ||
			event.keyCode == 104 ||
			event.keyCode == 105 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});
}

function typeValidation()
{
	$('.typeFp').keydown(function(event){
		if(!(event.keyCode == 49 || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 54  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 102 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});
}

function statusValidation()
{
	$('.status-trad').keydown(function(event){
		var index = $(this).closest('tr').find('input[name="slipIndex"]').val();

		if(!(event.keyCode == 65 || 
			event.keyCode == 66  ||
			event.keyCode == 67  ||
			event.keyCode == 68  ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(event.keyCode == 65) {
	    	$(this).closest('tr').find('input[name="intention_use['+index+']"]').removeAttr('disabled', 'disabled');
	    }
	});
}

function intentionStatusValidation()
{
	$('.intention_use').keydown(function(event){
		console.log('pressed');
		if(!(event.keyCode == 49 || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 52  ||
			event.keyCode == 53  ||
			event.keyCode == 54  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 100 ||
			event.keyCode == 101 ||
			event.keyCode == 102 ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});
}

function reasonValidation()
{
	$('.reasonFp').keydown(function(event){
		if(!(event.keyCode == 49 || 
			event.keyCode == 50  ||
			event.keyCode == 51  ||
			event.keyCode == 97  || 
			event.keyCode == 98  ||
			event.keyCode == 99  ||
			event.keyCode == 8 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }
	});
}

function isApprove()
{
	var count = $('tr:last-child').find('.loopIndex2').val();
	var i = 0;

	for (i = 0; i <= count; i ++) {
		var hasClass = $('.tr1' + i).hasClass('isApprove');
		if (hasClass) {
			$('.tr1' + i).find('td input').attr('disabled', true);
			$('.tr1' + i).find('td input').css('cursor', 'not-allowed');
			$('.tr1' + i).find('td textarea').attr('disabled', true);
			$('.tr1' + i).find('td textarea').css('cursor', 'not-allowed');
			$('.tr1' + i).find('td input[class="check"]').attr('disabled', false);

			$('.tr2' + i).find('td input').attr('disabled', true);
			$('.tr2' + i).find('td input').css('cursor', 'not-allowed');
			$('.tr2' + i).find('td textarea').attr('disabled', true);
			$('.tr2' + i).find('td textarea').css('cursor', 'not-allowed');
			$('.tr2' + i).find('td input[class="check"]').attr('disabled', false);
		}
	}
}

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

		if (getProv != '') {
			$('#provinceList').val(getProv);
			getMunicipalities(getProv);
		}

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

		if (getCity != '') {
			$('#muniList').val(getCity);
			getBrgys(getCity);
		}

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
			$('#brgyList').append(new Option(data[i].LOCATION_DESCRIPTION, data[i].BARANGAY));
		});

		if (getBrgy != '') {
			$('#brgyList').val(getBrgy);
		}

		$('#brgyList').selectpicker('render').selectpicker('refresh');
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