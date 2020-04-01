/** PREVENT SAVE FORM UPON CLICK OF SERVICE SLIP */
var backspace_and_tab = {8: 'BACKSPACE', 9: 'TAB'};
var statuses = {65 : 'A', 66 : 'B', 67 : 'C', 68 : 'D'};
var sexes = {70 : 'FEMALE', 77 : 'MALE'};
var zeros = {48 : 'ZERO', 96 : 'NUMPAD ZERO'};
var sixes = {54 : 'SIX', 102 : 'NUMPAD SIX'};

var one_to_three = {	49 : 'ONE', 
						50 : 'TWO', 
						51 : 'THREE', 
						97 : 'NUMPAD ONE', 
						98 : 'NUMPAD TWO', 
						99 : 'NUMPAD THREE'
					};
var one_to_five = 	{  	49 : 'ONE', 
						50 : 'TWO', 
						51 : 'THREE', 
						52 : 'FOUR', 
						53 : 'FIVE', 
						97 : 'NUMPAD ONE', 
						98 : 'NUMPAD TWO',
						99 : 'NUMPAD THREE', 
						100 : 'NUMPAD FOUR', 
						101 : 'NUMPAD FIVE'
					};
var six_to_nine = 	{ 	54 : 'SIX',
						55 : 'SEVEN', 
						56 : 'EIGHT', 
						57 : 'NINE', 
						102 : 'NUMPAD SIX',
						103 : 'NUMPAD SEVEN',
						104 : 'NUMPAD EIGHT',
						105 : 'NUMPAD NINE'
					};

$(document).ready(function(){
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
			event.preventDefault();
			return false;
	    }
	});

	$('#provinceList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var provinceId = $(e.target.options[clickedIndex]).val();
		$($('#form_validation input[name="province"]')[0]).val(provinceId);
		$('#form_validation input[name="city"]').val('');
		$('#form_validation input[name="barangay"]').val('');

		$('#muniList').find('option').remove();
		$('#muniList').selectpicker('refresh');
		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getMunicipalities(provinceId);
	});

	$('#muniList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var muniId = $(e.target.options[clickedIndex]).val();
		$($('#form_validation input[name="city"]')[0]).val(muniId);
		$('#form_validation input[name="barangay"]').val('');

		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getBrgys(muniId);
	});

	$('#brgyList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var brgy_id = $(e.target.options[clickedIndex]).val();
		$($('#form_validation input[name="barangay"]')[0]).val(brgy_id);
	});
});

var isRDM = $('#rdm').val();
var isFocal = $('#focal').val();

$(function() {
  	serviceModal();
  	importModal();
	inputValid();
	saveForm1();
	checkBox();
	getDataDuplicate();
	getProvinces();
	isApprove();
	sexValidation();
	civilStatusValidation();
	educationValidation();
	noChildrenValidation();
	methodValidation();
	typeValidation();
	statusValidation();
	reasonValidation();
	typeUnmet();
	statusUnmet();
	importChanges();
	afterLoadValidation();
	// refreshPage();

	Inputmask().mask(".birthAge");

    $('.selectpicker').selectpicker({
    	container: 'body'
    });

    var FromEndDate = new Date();
    $('.date_con').datepicker({
    	dateFormat: "mm/dd/yy",
    	maxDate: FromEndDate,
		changeYear: true
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

function refreshPage()
{

	if (window.performance) {
	 	console.info("window.performance works fine on this browser");
	}

	if (performance.navigation.type == 1) {
		// const Toast = Swal.mixin({
		// 	toast: true,
		// 	position: 'top-end',
		// 	showConfirmButton: false,
		// 	timer: 3000
		// });
		
		// Toast.fire({
		// 	title: "Good job", 
		// 	text: "You clicked the button!", 
		// 	type: "success"
		// }).then(function(){ 
		//    location.reload();
		// });

		// Toast.fire({
		// 	type: 'error',
		// 	title: 'Fill the required fields'
		// });
		// alert('Are you sure?')
		// console.info("This page is reloaded" );
	} else {
		console.info( "This page is not reloaded");
	}
}

function afterLoadValidation()
{
	for(var i = 0; i <= 9; i ++) {
		var fname1 	  =	$('.tr1' + i + ' textarea[name="firstname1[' + i +']"]').val();
		var lname1 	  =	$('.tr1' + i + ' textarea[name="lastname1[' + i +']"]').val();
		var extname1  =	$('.tr1' + i + ' input[name="extname1[' + i +']"]').val();
		var sex1 	  =	$('.tr1' + i + ' input[name="sex1[' + i +']"]').val();
		var bday1     =	$('.tr1' + i + ' input[name="bday1[' + i +']"]').val();
		var age1      =	$('.tr1' + i + ' input[name="age1[' + i +']"]').val();

		var fname2    =	$('.tr2' + i + ' textarea[name="firstname2[' + i +']"]').val();
		var lname2    =	$('.tr2' + i + ' textarea[name="lastname2[' + i +']"]').val();
		var extname2  =	$('.tr2' + i + ' input[name="extname2[' + i +']"]').val();
		var sex2      =	$('.tr2' + i + ' input[name="sex2[' + i +']"]').val();
		var bday2     =	$('.tr2' + i + ' input[name="bday2[' + i +']"]').val();
		var age2      =	$('.tr2' + i + ' input[name="age2[' + i +']"]').val();

		var type      =	$('.tr1' + i + ' input[name="type[' + i +']"]').val();
		var status    =	$('.tr1' + i + ' input[name="status[' + i +']"]').val();

		var dateArr1  = bday1.split('-');
		var month1    = $.trim(dateArr1[0]);
		var day1      =	$.trim(dateArr1[1]);
		var year1     = $.trim(dateArr1[2]);
		var bday1     =	year1 + '-' + month1 + '-' + day1;

		var dateArr2  = bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2      =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     = year2 + '-' + month2 + '-' + day2;		

		if (fname1 != '') {
			if(!$('.tr1' + i + ' textarea[name="firstname1[' + i +']"]').prop('required')) {
		    	$('.tr1' + i).find('td .require-this').attr('required', 'required');
		    	$('.tr1' + i).find('td .required').removeAttr('hidden', 'hidden');
		    }
		}

		if (fname2 != '') {
			if(!$('.tr2' + i + ' textarea[name="firstname2[' + i +']"]').prop('required')) {
		    	$('.tr2' + i).find('td .require-this').attr('required', 'required');
		    	$('.tr2' + i).find('td .required').removeAttr('hidden', 'hidden');
		    }
		}
		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, i);
		criteria(i, i, sex1, sex2, age1, age2, type, status);

		val = status.toUpperCase();
		if(val == 'A') {
	    	$('input[name="intention-use[' + i +']"').attr('required', 'required');
	    	$('input[name="intention-use[' + i +']"').find('.intention-required').removeAttr('hidden', 'hidden');
	    	$('input[name="intention_use['+i+']"').removeAttr('disabled', 'disabled');
	    	intentionStatusValidation(i);
	    } else {
	    	$('input[name="intention-use[' + i +']"').removeAttr('required', 'required');
	    	$('input[name="intention-use[' + i +']"').find('.intention-required').attr('hidden', 'hidden');
	    	$('input[name="intention_use['+i+']"').attr('disabled', 'disabled');
		}
		
		var isSlipSave = $('.fp_served' + i).val();
		if (isSlipSave == 1) {
			$('.tr1' + i + ' .criteria .labelDiv').html('<span class="label label-success">Served</span>');
		}
	}
}

function importChanges()
{
	$('#importModal').on('hidden.bs.modal', function (e) {
		setTimeout(function(){
			var prov = $('input[name="province"]').val();
			$('#provinceList').val(prov);
			$('#provinceList').selectpicker('render').selectpicker('refresh');

			getMunicipalities(prov);
		}, 2000);
		afterLoadValidation();
	});
}

function click_click_click(index, id, couplesId)
{
	$('#'+ id +' .auto-fill-data').click(function(event){
		event.preventDefault();
		$.ajax({
			type : 'POST',
			cache : true,
			url : base_url + 'forms/getDuplicateDetails',
			data : {
				'couplesId' : couplesId
			}
		}).done(function(result){
			var age1 = $('[aria-describedby='+ id + ']').closest('tr').find('.getAge1').val();
			var sex1 = $('[aria-describedby='+ id + ']').closest('tr').find('.gender1').val();
			var age2 = $('[aria-describedby='+ id + ']').closest('tr').next('tr').find('.getAge2').val();
			var sex2 = $('[aria-describedby='+ id + ']').closest('tr').next('tr').find('.gender2').val();

			criteria(index, index, sex1, sex2, age1, age2, result.Tfp_Type, result.Tfp_Status);

			$('[aria-describedby='+ id + ']').popover('hide');

			if(result.Address_No_St != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.add_st').val(result.Address_No_St);
			}

			if(result.Address_Barangay != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.add_brgy').val(result.Address_Barangay);
			}

			if(result.Address_City != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.add_city').val(result.Address_City);
			}

			if(result.Household_No != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.hh_no').val(result.Household_No);
			}

			if(result.Number_Child != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.noChildren').val(result.Number_Child);
			}

			if(result.Mfp_Used != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.method8').val(result.Mfp_Used);
			}

			if(result.Mfp_Shift != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.method9').val(result.Mfp_Shift);
			}

			if(result.Tfp_Type != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.typeFp').val(result.Tfp_Type);
			}

			if(result.Tfp_Status != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.status-trad').val(result.Tfp_Status);
			}

			if(result.Mfp_Intention_Use != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.intention-use').val(result.Mfp_Intention_Use);
			}

			if(result.Reason_Use != 'N/A') {
				$('[aria-describedby='+ id + ']').closest('tr').find('.reasonFp').val(result.Reason_Use);
			}
		});
	});
}

function tooltip(couplesId, status, husband, wife, index)
{
	$("[data-toggle=popover"+index+"]").unbind('mousedown');
	$("[data-toggle=popover"+index+"]").bind('mousedown', function(event) {
 		event.preventDefault();

		var new_content =   '<p>Husband: <span class="fill-husband">'+ husband +'</span></p>' +
							'<p>Wife: <span class="fill-wife">'+ wife +'</span></p> <br>' +
							'<p class="button-fill auto-fill-data">Autofill data</p>';

		$("[data-toggle=popover"+index+"]").popover({
			container: 'body',
		    html: true,
		    title: 'Possible Duplicate in ' + status,
			content: new_content
		});
	 	
	 	$(this).on("click", function(event) {
	 		event.preventDefault();
			var id = $(this).attr('aria-describedby');
			click_click_click(index, id, couplesId);
		});
 	});

}

function sexValidation()
{
	$('.gender1').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((sexes.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
			if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});

	$('.gender2').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((sexes.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
			if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }	    
	});
}

function civilStatusValidation()
{
	$('.civil1').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
			if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});

	$('.civil2').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
			if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function educationValidation()
{
	$('.education1').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
			(six_to_nine.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
			if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});

	$('.education2').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
			(six_to_nine.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
			if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function noChildrenValidation()
{
	$('.noChildren').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
			(six_to_nine.hasOwnProperty(key)) ||
			(zeros.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
	    	if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function methodValidation()
{
	$('.method8').keyup(function(event){
		var val = $(this).val();
	    if (val > 12 || val == 0) {
	    	$(this).val('');
	    	event.preventDefault();
			return false;
	    }
	});

	$('.method9').keyup(function(event){
		var val = $(this).val();
	    if (val > 12 || val == 0) {
	    	$(this).val('');
	    	event.preventDefault();
			return false;
	    }
	});

	$('.method8').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
			(six_to_nine.hasOwnProperty(key)) ||
			(zeros.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
	    	if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});

	$('.method9').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
			(six_to_nine.hasOwnProperty(key)) ||
			(zeros.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
	    	if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function typeValidation()
{
	$('.typeFp').keydown(function(event){
		var key = event.keyCode || event.which;

		if ((one_to_five.hasOwnProperty(key)) ||
			(sixes.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
	    	if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function statusUnmet()
{
	$('.status-trad').keyup(function(){
		var status 	= $(this).val();
		var gender1 = $(this).closest('tr').find('.gender1').val();
		var gender2 = $(this).closest('tr').next('tr').find('.gender2').val();
		var age1 	= $(this).closest('tr').find('.getAge1').val();
		var age2 	= $(this).closest('tr').next('tr').find('.getAge2').val();
		var type 	= $(this).closest('tr').find('.typeFp').val();
		var index1 	= $(this).closest('tr').find('.loopIndex1').val();
	    var index2 	= $(this).closest('tr').next('tr').find('.loopIndex2').val();

		gender1 = gender1.toUpperCase();
		gender2 = gender2.toUpperCase();
		
		criteria(index1, index2, gender1, gender2, age1, age2, type, status);

		var index = $(this).closest('tr').find('input[class="loopIndex1"]').val();
		status = status.toUpperCase();
		if(status == 'A') {
	    	$(this).closest('tr').find('.intention-use').attr('required', 'required');
	    	$(this).closest('tr').find('.intention-required').removeAttr('hidden', 'hidden');
	    	$(this).closest('tr').find('input[name="intention_use['+index+']"]').removeAttr('disabled', 'disabled');
	    	intentionStatusValidation(index);
	    } else {
	    	$(this).closest('tr').find('.intention-use').val('');
	    	$(this).closest('tr').find('.intention-use').removeAttr('required', 'required');
	    	$(this).closest('tr').find('.intention-required').attr('hidden', 'hidden');
	    	$(this).closest('tr').find('input[name="intention_use['+index+']"]').attr('disabled', 'disabled');
	    }
	});
}

function typeUnmet()
{
	$('.typeFp').keyup(function(){
		var type 	= $(this).val();
	    var gender1 = $(this).closest('tr').find('.gender1').val();
	    var gender2 = $(this).closest('tr').next('tr').find('.gender2').val();
	    var age1 	= $(this).closest('tr').find('.getAge1').val();
	    var age2 	= $(this).closest('tr').next('tr').find('.getAge2').val();
	    var status 	= $(this).closest('tr').find('.status-trad').val();
	    var index1 	= $(this).closest('tr').find('.loopIndex1').val();
	    var index2 	= $(this).closest('tr').next('tr').find('.loopIndex2').val();

	    gender1 = gender1.toUpperCase();
	    gender2 = gender2.toUpperCase();

	    criteria(index1, index2, gender1, gender2, age1, age2, type, status);
	});
}

function statusValidation()
{
	$('.status-trad').keydown(function(event){
	    var val = $(this).val();
	    var key = event.keyCode || event.which;

	    if ((statuses.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
	    	if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function intentionStatusValidation()
{
	$('.intention-use').keyup(function(event){
		var val = $(this).val();
	    if (val > 12 || val == 0) {
	    	$(this).val('');
	    	event.preventDefault();
			return false;
	    }
	});

	$('.intention-use').keydown(function(event){
	    var key = event.keyCode || event.which;

	    if ((zeros.hasOwnProperty(key)) ||
	    	(one_to_five.hasOwnProperty(key)) ||
	    	(six_to_nine.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
	    	if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function reasonValidation()
{
	$('.reasonFp').keydown(function(event){
	    var key = event.keyCode || event.which;

	    if ((one_to_three.hasOwnProperty(key)) ||
	    	(backspace_and_tab.hasOwnProperty(key))
	    ) {
	    	if(!$(this).prop('required')) {
		    	$(this).closest('tr').find('.require-this').attr('required', 'required');
		    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
		    }
	    } else {
	    	event.preventDefault();
	    	return false;
	    }
	});
}

function isApprove()
{
	var count = $('tr:last-child').find('.loopIndex2').val();
	var i = 0;

	for (i = 0; i <= count; i++) {
		var hasClass = $('.tr1' + i).hasClass('isApprove');
		var fpserved = $('.tr1' + i).find('.fp_served'+ i).val();
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

			if(fpserved <= 1) {
				$('.tr1' + i + ' .criteria .labelDiv').html('<span class="label label-success">Served</span>');
				// $('.tr1' + i + ' .criteria').find('.label-success').removeClass('none');
				// $('.tr1' + i + ' .criteria').find('.label-danger').addClass('none');
			}
		}
	}
}

function getProvinces()
{
	var getProv = $('input[name="province"]').val();
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
	var getCity = $('input[name="city"]').val();
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
	var getBrgy = $('input[name="barangay"]').val();
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

function criteria(index1, index2, gender1, gender2, age1, age2, type, status)
{
	if(status === '' || status === undefined) {
		return false;
	} else {
		var gender1 = gender1.toUpperCase();
		var gender2 = gender2.toUpperCase();
		var status = status.toUpperCase();
		if (gender1 === 'F') {
			UnmetNeedCriteria(index1, age1, type, status);
		} else if(gender2 === 'F') {
			UnmetNeedCriteria(index2, age2, type, status);
		} else {
			return false;
		}
	}
}

function UnmetNeedCriteria(index, age, type, status)
{
	var isSlipSave = $('.fp_served' + index).val();
	if (status != 'C') {
		if (age >= 15 && age <= 49 && type >= 1 && type <= 5) {
			if (isSlipSave != 1) {
				$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-danger">Unmet Need</span>');
			} else {
				$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-success">Served</span>');
			}			
		} else if (age >= 15 && age <= 49 && type == 6 && status == 'A') {
			if (isSlipSave != 1) {
				$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-danger">Unmet Need</span>');
			} else {
				$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-success">Served</span>');
			}
		} else {
			if (isSlipSave != 1) {
				$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-danger none">Unmet Need</span>');
			} else {
				$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-success">Served</span>');
			}			
		}
	} else {
		if (isSlipSave != 1) {
			$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-danger none">Unmet Need</span>');
		} else {
			$('.tr1' + index + ' .criteria .labelDiv').html('<span class="label label-success">Served</span>');
		}
	}
}

function getDataDuplicate()
{
	$('.fname1').keyup(function(){
		var fname1 	  =	$(this).val();
		var lname1    =	$(this).closest('tr').find('.lname1').val();
		var extname1  =	$(this).closest('tr').find('.extname1').val();
		var sex1      =	$(this).closest('tr').find('.gender1').val();
		var sex1 	  = sex1.toUpperCase();
		
		var bday1     =	$(this).closest('tr').find('.bday1').val();
		var dateArr1  =	bday1.split('-');
		var month1    =	$.trim(dateArr1[0]);
		var day1      =	$.trim(dateArr1[1]);
		var year1     =	$.trim(dateArr1[2]);
		var bday1     =	year1 + '-' + month1 + '-' + day1;

		var fname2    =	$(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2    =	$(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2  =	$(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2      =	$(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2      = sex2.toUpperCase();
		
		var bday2     =	$(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2  =	bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2      =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     =	year2 + '-' + month2 + '-' + day2;

		var index     =	$(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.lname1').keyup(function(){
		var lname1 	  = $(this).val();
		var fname1    =	$(this).closest('tr').find('.fname1').val();
		var extname1  =	$(this).closest('tr').find('.extname1').val();
		var sex1      =	$(this).closest('tr').find('.gender1').val();
		var sex1 	  =	sex1.toUpperCase();
		
		var bday1     =	$(this).closest('tr').find('.bday1').val();
		var dateArr1  =	bday1.split('-');
		var month1    =	$.trim(dateArr1[0]);
		var day1      =	$.trim(dateArr1[1]);
		var year1     =	$.trim(dateArr1[2]);
		var bday1     =	year1 + '-' + month1 + '-' + day1;

		var fname2    =	$(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2    =	$(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2  =	$(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2      =	$(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2      =	sex2.toUpperCase();
		
		var bday2     =	$(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2  =	bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2 	  =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     =	year2 + '-' + month2 + '-' + day2;

		var index 	  = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.extname1').keyup(function(){
		var extname1  = $(this).val();
		var fname1    =	$(this).closest('tr').find('.fname1').val();
		var lname1 	  =	$(this).closest('tr').find('.lname1').val();
		var sex1 	  =	$(this).closest('tr').find('.gender1').val();
		var sex1 	  =	sex1.toUpperCase();
		
		var bday1 	  = $(this).closest('tr').find('.bday1').val();
		var dateArr1  =	bday1.split('-');
		var month1    =	$.trim(dateArr1[0]);
		var day1      =	$.trim(dateArr1[1]);
		var year1     = $.trim(dateArr1[2]);
		var bday1     =	year1 + '-' + month1 + '-' + day1;

		var fname2    =	$(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2    =	$(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2  =	$(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2      =	$(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2      = sex2.toUpperCase();
		
		var bday2     =	$(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2  =	bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2      =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     =	year2 + '-' + month2 + '-' + day2;

		var index     =	$(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);
	});

	$('.gender1').keyup(function(){
		var sex1      = $(this).val();
		var sex1      =	sex1.toUpperCase();
		var fname1 	  =	$(this).closest('tr').find('.fname1').val();
		var lname1    =	$(this).closest('tr').find('.lname1').val();
		var extname1  =	$(this).closest('tr').find('.extname1').val();
		
		var bday1     = $(this).closest('tr').find('.bday1').val();
		var dateArr1  =	bday1.split('-');
		var month1    =	$.trim(dateArr1[0]);
		var day1      =	$.trim(dateArr1[1]);
		var year1     =	$.trim(dateArr1[2]);
		var bday1     =	year1 + '-' + month1 + '-' + day1;

		var fname2    =	$(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2    =	$(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2  =	$(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2      =	$(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2      =	sex2.toUpperCase();
		
		var bday2     =	$(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2  =	bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2      =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     = year2 + '-' + month2 + '-' + day2;

		var index 	  = $(this).closest('tr').find('.loopIndex1').val();

		var age1      =	$(this).closest('tr').find('.getAge1').val();
		var age2 	  =	$(this).closest('tr').next('tr').find('.getAge2').val();
		var type 	  =	$(this).closest('tr').find('.typeFp').val();
		var status 	  = $(this).closest('tr').find('.status-trad').val();

		criteria(index, index, sex1, sex2, age1, age2, type, status);
		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.bday1').keyup(function(){
		var bday1 = $(this).val();

		dob1 = 			new Date(bday1);
		var today1 = 	new Date();
		var age1 = 		Math.floor((today1 - dob1) / (365.25 * 24 * 60 * 60 * 1000));
		var curr_year = today1.getFullYear();

		var dateArr1 =	 bday1.split('-');

		var month1 = 	$.trim(dateArr1[0]);
		var day1 = 		$.trim(dateArr1[1]);
		var year1 = 	$.trim(dateArr1[2]);
		
		if (month1 > 12 || 
			day1   > 31 ||
			month1 == 0 || 
			day1   == 0 ||
			year1 	> curr_year
		) {
			age1 = '';
			$(this).val('');
		}

		var bday1 = year1 + '-' + month1 + '-' + day1;
		$(this).closest('td').find('.getAge1').val(age1);

		var fname1    = $(this).closest('tr').find('.fname1').val();
		var lname1    =	$(this).closest('tr').find('.lname1').val();
		var extname1  =	$(this).closest('tr').find('.extname1').val();
		var sex1      =	$(this).closest('tr').find('.gender1').val();
		var sex1  	  =	sex1.toUpperCase();

		var fname2 	  =	$(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2 	  =	$(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2  =	$(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2 	  =	$(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2 	  =	sex2.toUpperCase();
		
		var bday2 	  = $(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2  =	bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2      =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     =	year2 + '-' + month2 + '-' + day2;

		var index     =	$(this).closest('tr').find('.loopIndex1').val();

		var age2      =	$(this).closest('tr').next('tr').find('.getAge2').val();
		var type      =	$(this).closest('tr').find('.typeFp').val();
		var status    =	$(this).closest('tr').find('.status-trad').val();

		criteria(index, index, sex1, sex2, age1, age2, type, status);
		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.fname2').keyup(function(){
		var fname2    =	$(this).val();
		var lname2    =	$(this).closest('tr').find('.lname2').val();
		var extname2  =	$(this).closest('tr').find('.extname2').val();
		var sex2      =	$(this).closest('tr').find('.gender2').val();
		var sex2      =	sex2.toUpperCase();
		
		var bday2     =	$(this).closest('tr').find('.bday2').val();
		var dateArr2  =	bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2      =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     =	year2 + '-' + month2 + '-' + day2;

		var fname1    =	$(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1    =	$(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1  =	$(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1      = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1      =	sex1.toUpperCase();
		
		var bday1     =	$(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1  =	bday1.split('-');
		var month1    =	$.trim(dateArr1[0]);
		var day1      = $.trim(dateArr1[1]);
		var year1 	  =	$.trim(dateArr1[2]);
		var bday1     = year1 + '-' + month1 + '-' + day1;
		
		var index     = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.lname2').keyup(function(){
		var lname2    = $(this).val();
		var fname2    = $(this).closest('tr').find('.fname2').val();
		var extname2  = $(this).closest('tr').find('.extname2').val();
		var sex2      =	$(this).closest('tr').find('.gender2').val();
		var sex2      =	sex2.toUpperCase();
		
		var bday2     =	$(this).closest('tr').find('.bday2').val();
		var dateArr2  =	bday2.split('-');
		var month2    =	$.trim(dateArr2[0]);
		var day2      =	$.trim(dateArr2[1]);
		var year2     =	$.trim(dateArr2[2]);
		var bday2     =	year2 + '-' + month2 + '-' + day2;

		var fname1    =	$(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1    =	$(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1  =	$(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1      =	$(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1      =	sex1.toUpperCase();
		
		var bday1     =	$(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1  =	bday1.split('-');
		var month1    =	$.trim(dateArr1[0]);
		var day1      =	$.trim(dateArr1[1]);
		var year1     =	$.trim(dateArr1[2]);
		var bday1     =	year1 + '-' + month1 + '-' + day1;

		var index     = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.extname2').keyup(function(){
		var extname2 = $(this).val();
		var fname2   = $(this).closest('tr').find('.fname2').val();
		var lname2   = $(this).closest('tr').find('.lname2').val();
		var sex2     = $(this).closest('tr').find('.gender2').val();
		var sex2     = sex2.toUpperCase();
		
		var bday2    = $(this).closest('tr').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2   = $.trim(dateArr2[0]);
		var day2     = $.trim(dateArr2[1]);
		var year2    = $.trim(dateArr2[2]);
		var bday2    = year2 + '-' + month2 + '-' + day2;

		var fname1   = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1   = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1     = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1     = sex1.toUpperCase();
		
		var bday1    = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1   = $.trim(dateArr1[0]);
		var day1     = $.trim(dateArr1[1]);
		var year1    = $.trim(dateArr1[2]);
		var bday1    = year1 + '-' + month1 + '-' + day1;

		var index    = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);
	});

	$('.gender2').keyup(function(){
		var sex2 	 = $(this).val();
		var sex2 	 = sex2.toUpperCase();
		var fname2   = $(this).closest('tr').find('.fname2').val();
		var lname2   = $(this).closest('tr').find('.lname2').val();
		var extname2 = $(this).closest('tr').find('.extname2').val();
		
		var bday2    = $(this).closest('tr').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2   = $.trim(dateArr2[0]);
		var day2     = $.trim(dateArr2[1]);
		var year2    = $.trim(dateArr2[2]);
		var bday2    = year2 + '-' + month2 + '-' + day2;

		var fname1   = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1   = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1     = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1     = sex1.toUpperCase();
		
		var bday1    = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1   = $.trim(dateArr1[0]);
		var day1     = $.trim(dateArr1[1]);
		var year1    = $.trim(dateArr1[2]);
		var bday1    = year1 + '-' + month1 + '-' + day1;

		var index    = $(this).closest('tr').find('.loopIndex2').val();

		var age1     = $(this).closest('tr').prev('tr').find('.getAge1').val();
		var age2     = $(this).closest('tr').find('.getAge2').val();
		var type     = $(this).closest('tr').prev('tr').find('.typeFp').val();
		var status   = $(this).closest('tr').prev('tr').find('.status-trad').val();

		criteria(index, index, sex1, sex2, age1, age2, type, status);
		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.bday2').keyup(function(){
		var bday2 = $(this).val();

		dob2 = new Date(bday2);
		var today2 = new Date();
		var age2 = Math.floor((today2 - dob2) / (365.25 * 24 * 60 * 60 * 1000));
		var curr_year = today2.getFullYear();

		var dateArr2 = bday2.split('-');

		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);

		if (month2 > 12 || 
			day2   > 31 ||
			month2 == 0 || 
			day2   == 0 ||
			year2 	> curr_year
		) {
			age2 = '';
			$(this).val('');
		}

		var bday2 = year2 + '-' + month2 + '-' + day2;
		$(this).closest('td').find('.getAge2').val(age2);

		var index2 	 = $(this).closest('tr').find('.loopIndex2').val();
		var fname2   = $(this).closest('tr').find('.fname2').val();
		var lname2   = $(this).closest('tr').find('.lname2').val();
		var extname2 = $(this).closest('tr').find('.extname2').val();
		var sex2 	 = $(this).closest('tr').find('.gender2').val();
		var sex2     = sex2.toUpperCase();

		var fname1   = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1   = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1 	 = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1 	 = sex1.toUpperCase();
		
		var bday1    = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1   = $.trim(dateArr1[0]);
		var day1     = $.trim(dateArr1[1]);
		var year1    = $.trim(dateArr1[2]);
		var bday1    = year1 + '-' + month1 + '-' + day1;
		
		var index    = $(this).closest('tr').find('.loopIndex2').val();

		var age1 	 = $(this).closest('tr').prev('tr').find('.getAge2').val();
		var type 	 = $(this).closest('tr').find('.typeFp').val();
		var status 	 = $(this).closest('tr').find('.status-trad').val();

		criteria(index, index, sex1, sex2, age1, age2, type, status);
		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});
}

function autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index)
{
	var controller = 'forms/checkCoupleDuplicate';
	var status = '';
	if(sex1 != '' && sex2 != '') {
		controller = 'forms/checkCoupleDuplicate';
		if (sex1 === 'F' && sex2 === 'M') {
			var h_fname 	= fname2;
			var h_lname 	= lname2;
			var h_extname 	= extname2;
			var h_bday 		= bday2;
			var w_fname 	= fname1;
			var w_lname 	= lname1;
			var w_bday 		= bday1;
		} else if(sex2 === 'F' && sex1 === 'M') {
			var h_fname 	= fname1;
			var h_lname 	= lname1;
			var h_extname 	= extname1;
			var h_bday 		= bday1;
			var w_fname 	= fname2;
			var w_lname 	= lname2;
			var w_bday 		= bday2;
		} else {
			return false;
		}
	// } else if (sex1 != '' && sex2 == ''){
	// 	controller = 'forms/checkIndividualDuplicate';
	// 	if (sex1 === 'F') {
	// 		var h_fname 	= fname2;
	// 		var h_lname 	= lname2;
	// 		var h_extname 	= extname2;
	// 		var h_bday 		= bday2;
	// 		var w_fname 	= fname1;
	// 		var w_lname 	= lname1;
	// 		var w_bday 		= bday1;
	// 	} else if(sex1 === 'M') {
	// 		var h_fname 	= fname1;
	// 		var h_lname 	= lname1;
	// 		var h_extname 	= extname1;
	// 		var h_bday 		= bday1;
	// 		var w_fname 	= fname2;
	// 		var w_lname 	= lname2;
	// 		var w_bday 		= bday2;
	// 	} else {
	// 		return false;
	// 	}
	} else {
		return false;
	}

	$.ajax({
			type : 'POST',
			cache : true,
			url : base_url + controller,
			data : {
				'h_fname'	: h_fname, 
				'h_lname' 	: h_lname, 
				'h_ext' 	: h_extname,
				'h_bday'	: h_bday,
				'w_fname'	: w_fname,
				'w_lname'	: w_lname,
				'w_bday'	: w_bday
			}
	}).done(function(result){
		var hasId = $('.tr1' + index + ' input[name="couple_id['+ index +']"]').val();
		if (result.ActiveStatus === '2') {
			status = 'Pending';
		} else if (result.ActiveStatus === '0') {
			status = 'Approve';
		} else {
			status;
		}

		if(result.Husband == '') {
			result.Husband = 'N/A';
		}

		if (result.CheckCount >= 1) {
			if (hasId == '') {
				$('.tr1' + index + ' td:nth-child(1)').addClass('has-duplicate');
				$('.tr2' + index + ' td:nth-child(1)').addClass('has-duplicate');

				$('.tr1' + index + ' td:nth-child(2)').addClass('has-duplicate');
				$('.tr2' + index + ' td:nth-child(2)').addClass('has-duplicate');

				$('.tr1' + index + ' td:nth-child(3)').addClass('has-duplicate');
				$('.tr2' + index + ' td:nth-child(3)').addClass('has-duplicate');

				$('.tr1' + index + ' td:nth-child(4)').addClass('has-duplicate');
				$('.tr2' + index + ' td:nth-child(4)').addClass('has-duplicate');

				$('.tr1' + index + ' td:nth-child(5)').addClass('has-duplicate');

				$('.tr1' + index + ' td .extname1').addClass('has-duplicate');
				$('.tr2' + index + ' td .extname2').addClass('has-duplicate');

				$('.tr1' + index + ' td .gender1').addClass('has-duplicate');
				$('.tr2' + index + ' td .gender2').addClass('has-duplicate');

				$('.tr1' + index + ' td .bday1').addClass('has-duplicate');
				$('.tr2' + index + ' td .bday2').addClass('has-duplicate');

				$('.tr1' + index + ' td .civil1').addClass('has-duplicate');
				$('.tr2' + index + ' td .civil2').addClass('has-duplicate');

				$('.tr1' + index + ' td .getAge1').addClass('has-duplicate');
				$('.tr2' + index + ' td .getAge2').addClass('has-duplicate');

				$('.tr1' + index + ' td textarea').addClass('has-duplicate');
				$('.tr2' + index + ' td textarea').addClass('has-duplicate');

				$('.tr1' + index + ' td .duplicateBtn').removeAttr('hidden');

				$('.tr1' + index + ' td #popover-content').find('.fill-husband').text(result.Husband);
				$('.tr1' + index + ' td #popover-content').find('.fill-wife').text(result.Wife);

				tooltip(result.CouplesId, status, result.Husband, result.Wife, index);
			}
		} else {

			$('.tr1' + index + ' td:nth-child(1)').removeClass('has-duplicate');
			$('.tr2' + index + ' td:nth-child(1)').removeClass('has-duplicate');

			$('.tr1' + index + ' td:nth-child(2)').removeClass('has-duplicate');
			$('.tr2' + index + ' td:nth-child(2)').removeClass('has-duplicate');

			$('.tr1' + index + ' td:nth-child(3)').removeClass('has-duplicate');
			$('.tr2' + index + ' td:nth-child(3)').removeClass('has-duplicate');

			$('.tr1' + index + ' td:nth-child(4)').removeClass('has-duplicate');
			$('.tr2' + index + ' td:nth-child(4)').removeClass('has-duplicate');

			$('.tr1' + index + ' td:nth-child(5)').removeClass('has-duplicate');

			$('.tr1' + index + ' td .extname1').removeClass('has-duplicate');
			$('.tr2' + index + ' td .extname2').removeClass('has-duplicate');

			$('.tr1' + index + ' td .gender1').removeClass('has-duplicate');
			$('.tr2' + index + ' td .gender2').removeClass('has-duplicate');

			$('.tr1' + index + ' td .bday1').removeClass('has-duplicate');
			$('.tr2' + index + ' td .bday2').removeClass('has-duplicate');

			$('.tr1' + index + ' td .civil1').removeClass('has-duplicate');
			$('.tr2' + index + ' td .civil2').removeClass('has-duplicate');

			$('.tr1' + index + ' td .getAge1').removeClass('has-duplicate');
			$('.tr2' + index + ' td .getAge2').removeClass('has-duplicate');

			$('.tr1' + index + ' td textarea').removeClass('has-duplicate');
			$('.tr2' + index + ' td textarea').removeClass('has-duplicate');
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

		$.post(base_url + '/forms/serviceSlip', {'index' : index, 'couple_id' : coupleId, 'couple_name' : coupleName, 'address' : address})
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

function checkBox()
{
	$('#checkAll').click(function() {
        var checked = $(this).prop('checked');
        $('.approveCheck').find('.check').prop('checked', checked);
    	$('td:first-child input[name="approveCouple"]').closest('tr').toggleClass("highlight", this.checked);
    	$('td:first-child input[name="approveCouple"]').closest('tr').next('tr').toggleClass("highlight", this.checked);
    });

	$('td:first-child input[name="approveCouple"]').change(function() {
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

function checkRequired() 
{
	var validate = {
						'type_class' : 0,
						'class_and_couple_details' : 0,
						'signature' : 0
	}

	if ($('input[name=type_of_class]:checked').length > 0) {
		validate['type_class'] = 0;
		$('#rpfpClass table tr').find('td .checkmark').removeClass('required-field');

		var others = $('#rpfpClass table tr').find('td input[id=others]');
		if ((others).is(':checked')) {
			if ($('#rpfpClass table tr').find('td input[name=others]').val() == '') {
				$('#rpfpClass table tr').find('td input[name=others]').addClass('required-field');
				validate['type_class'] = 1;
			} else {
				$('#rpfpClass table tr').find('td input[name=others]').removeClass('required-field');
				validate['type_class'] = 0;
			}
		} else { 
			$('#rpfpClass table tr').find('td input').removeClass('required-field');
			validate['type_class'] = 0;
		}
	} else {
		$('#rpfpClass table tr').find('td .checkmark').addClass('required-field');
		validate['type_class'] = 1;
	}

	$.each($('input,textarea,select').filter('[required]'), function(key, value) {
		var item = $(value).val();
		var className = $(value).attr('class');

		if (item == '') {
			validate['class_and_couple_details'] = 1;
			$(value).addClass('required-field');
			$(value).closest('tr').addClass('required-tr');
			var index = $(value).closest('tr').find('td:nth-child(2) .loopIndex1').val();			
			
			if (className == 'provinceList' || className == 'muniList' || className == 'brgyList') {
				$(value).closest('td').find('button[data-id='+ className +']').addClass('required-field');
				validate['class_and_couple_details'] = 1;
			}
		} else {
			$(value).removeClass('required-field');
			if (className == 'provinceList' || className == 'muniList' || className == 'brgyList') {
				$(value).closest('td').find('button[data-id='+ className +']').removeClass('required-field');
				validate['class_and_couple_details'] = 0;
			}
		}
	});

	for (var i = 0; i <= 9; i++) {
		var trRequired1 = $('.tr1' + i).hasClass('required-tr');
		var trRequired2 = $('.tr2' + i).hasClass('required-tr');

		if (trRequired1 == true && trRequired2 == true) {
			if ($('input[name="attendee1['+ i +']"]:checked').length > 0 || $('input[name="attendee2['+ i +']"]:checked').length > 0) {
				$('input[name="attendee1['+ i +']"], input[name="attendee2['+ i +']"]').closest('tr').removeClass('required-tr');
				$('input[name="attendee1['+ i +']"], input[name="attendee2['+ i +']"]').closest('tr').find('.back-eee').removeClass('required-field');
			} else {
				validate['signature'] = 1;
				$('input[name="attendee1['+ i +']"], input[name="attendee2['+ i +']"]').closest('tr').addClass('required-tr');
				$('input[name="attendee1['+ i +']"], input[name="attendee2['+ i +']"]').closest('tr').find('.back-eee').addClass('required-field');
			}
		} else {
			if (trRequired1 == true) {
				if ($('input[name="attendee1['+ i +']"]:checked').length > 0) {
					$('input[name="attendee1['+ i +']"]').closest('tr').removeClass('required-tr');
					$('input[name="attendee1['+ i +']"]').closest('tr').find('.back-eee').removeClass('required-field');
				} else {
					$('input[name="attendee1['+ i +']"]').closest('tr').addClass('required-tr');
					$('input[name="attendee1['+ i +']"]').closest('tr').find('.back-eee').addClass('required-field');
				}
			} else if (trRequired2 == true) {
				if ($('input[name="attendee2['+ i +']"]:checked').length > 0) {
					$('input[name="attendee2['+ i +']"]').closest('tr').removeClass('required-tr');
					$('input[name="attendee2['+ i +']"]').closest('tr').find('.back-eee').removeClass('required-field');
				} else {
					$('input[name="attendee2['+ i +']"]').closest('tr').addClass('required-tr');
					$('input[name="attendee2['+ i +']"]').closest('tr').find('.back-eee').addClass('required-field');
				}
			}
		}
	}

	var countRequired = $('.formTable .required-tr').length;
	if (countRequired == 0) {
		validate['signature'] = 0;
	} else {
		validate['signature'] = 1;
	}

	console.log(validate);

	if (validate['type_class'] == 0 && validate['class_and_couple_details'] == 0 && validate['signature'] == 0) {
		validate = 1
		return validate;
	} else {
		validate = 0;
	}
}

function saveForm1()

{
	$('.saveForm1').click(function(event) {
		event.preventDefault();
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		save_page(current_page());
		var formData = {};
		/** iterate all inputs/textarea */
		$.each( $('#form_validation input, #form_validation textarea'), function(key, value) {
			var item = $(value);
			var item_value = item.val();
			if (item.prop('type') == 'radio') {
				item_value = $('#rpfpClass input[name="' + item.prop('name') + '"]:checked').val();
			}
			if (item.prop('name').indexOf('attendee') == 0) {
				item_value = item.val() == 'attended' ? 1 : 0;
			}
			if (item.prop('name') == 'date_conducted') {
				var newDate = new Date(item.val());
				var yyyy = newDate.getFullYear();
				var mm = newDate.getMonth();
				var dd = newDate.getDate();
				mm += 1;
				newDate = yyyy + '-' + ('0' + (mm)).slice(-2) + '-' + ('0' + dd).slice(-2);

				item_value = newDate;
			}
			
			formData[item.prop('name')] = item_value;
		});
		// console.log(formData);return false;
		var validate = checkRequired();
		if (validate != 1) {
			Toast.fire({
				type: 'error',
				title: 'Fill the required fields'
			}); 
		} else {
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				data: formData,
				url: base_url + '/forms/saveForm1'
			}).done(function(result){
				Toast.fire({
					type: (result.is_save) ? 'success' : 'error',
					title: 'Form 1 save status',
					message: result.message == undefined ? "There was an error saving Form 1" : result.message
				});

				if (result.is_save) {
					/** put rpfp class id in field */
					$('#class_id').val(result.value);

					/** initialize edit existing field */
					var temp = $('#edit_existing');
					if (temp.length == 0) {
						temp = $(document.createElement('div'));
						temp.prop('id', 'edit_existing');
					}
					temp.val('edit-from-save');
				}
			});
		}				
	});
}

$(document).ready(function(){

	re_initialize_page();

	$('.next').click(function() {
		/** load variables from browser storage */
		var current = current_page();
		var total_pages = num_pages();

		/** save current page  */
		save_page(current);

		if (++current > total_pages) {
			num_pages(total_pages = current);
		}

		/** erase contents of form (couples data only) */
		clear_form();
		get_page(current);
		current_page(current);
		update_page_numbering(current, total_pages);
	});

	$('.previous').click(function() {
		var current = current_page();

		/** save current page */
		save_page(current);

		if (--current < 1) {
			current = 1;
		}

		/** erase contents of form (couples data only) */
		clear_form();
		get_page(current);
		current_page(current);
		
		var total_pages = num_pages();
		update_page_numbering(current, total_pages);
	});

	$('input[type=checkbox] + span').click(function(){
		// var current_value = $($(this).siblings('input[type=checkbox][class^="attended"]')[0]).val();
		var current_checkbox = $($(this).siblings('input[type=checkbox]')[0]);
		var current_value = current_checkbox.val();

		var new_value = "";
		if (current_checkbox.is('[class^="attended"]')) {
			new_value = current_value == 'attended' ? "" : 'attended';
		} else if (current_checkbox.is('[name^="approveCouple"]')){
			new_value = current_value == 'approved' ? "" : 'approved';
		}
		current_checkbox.val(new_value);
	});

	$('#loading-wrapper').removeClass('loading');
});

function current_page(page_num=null) {
	if (page_num == null) {
		var temp = localStorage.getItem('current_page');
		return temp != null ? temp : 0;
	}
	localStorage.setItem('current_page', page_num);
}

function num_pages(page_num=null) {
	if (page_num == null) {
		var temp = localStorage.getItem('num_pages');
		return temp != null ? temp : 0;
	}
	localStorage.setItem('num_pages', page_num);
}

function reset_page_storage() {
	current_page(1);
	num_pages(1);
	$.each(Object.keys(localStorage), function(key, value) {
		if ((value.search('items_page_') == 0) || (value.search('rpfp_seminar') == 0))  {
			localStorage.removeItem(value);
		}
	});
}

function clear_form() {
	$('#paged_form input[type="checkbox"]').attr('checked', false);
	$('#paged_form input[type="checkbox"]').val('');
	$('#paged_form input[type="hidden"]').not($('.loopIndex1')).not($('[name="slipIndex"')).val('');
	$('#paged_form textarea').val('');
	$('#paged_form input[type="text"]').val('');
	$('.has-duplicate').removeClass('has-duplicate');
	$("[data-toggle^=popover]").unbind('mousedown');
	$('.duplicateBtn').prop('hidden', true);
	$('.criteria .label:not(.none)').addClass('none');
	$(".fp_served*").prop('type', 'hidden');
	$('#paged_form .required').text('');
}

function clear_seminar() {
	$('.selectpicker').val('0');
	$('.selectpicker').selectpicker('render').selectpicker('refresh');

	$('#rpfpClass input[type="radio"]').attr('checked', false);
	$('#rpfpClass textarea').val('');
	$('#rpfpClass input[type="text"]').val('');
	$('#rpfpClass input[type="date"]').val('')
	
}

function save_seminar() {
	var data_array = {};
	$.each( $('#rpfpClass input, #rpfpClass textarea'), function(key, value) {
		var item = $(value);
		var item_value = item.val();
		if (item.prop('type') == 'radio') {
			item_value = $('#rpfpClass input[name="' + item.prop('name') + '"]:checked').val();
		}
		data_array[item.prop('name')] = item_value;
	});

	/** convert to jason */
	data_json = JSON.stringify(data_array);

	/** save to local storage */
	localStorage.setItem('rpfp_seminar', data_json);
}

function get_seminar() {
	/** convert json data to array */
	var array_data = $.parseJSON(localStorage.getItem('rpfp_seminar'));

	/** load page if not empty*/
	if (array_data != null) {
	/** iterate and save to all inputs/textarea */
		$.each(array_data, function(key, value) {
			if (key.indexOf('type_of_class') == 0) {
				$($('#rpfpClass input[name="' + key + '"][value="' + value + '"]')[0]).prop('checked', true);
			} else {
				$($('#rpfpClass input[name="' + key + '"], #rpfpClass textarea[name="' + key + '"]')[0]).val(value);
			}
		});
	}	
}

function save_page(page_num) {
	save_seminar();
	var data_array = {};

	/** iterate all inputs/textarea */
	$.each( $('#paged_form input, #paged_form textarea'), function(key, value) {
		data_array[$(value).prop('name')] = $(value).val();
	});

	/** convert to jason */
	data_json = JSON.stringify(data_array);

	/** save to local storage */
	localStorage.setItem('items_page_' + page_num, data_json);
}

function get_page(page_num) {
	get_seminar();
	/** convert json data to array */
	var array_data = $.parseJSON(localStorage.getItem('items_page_' + page_num));

	/** load page if not empty*/
	if (array_data != null) {
	/** iterate and save to all inputs/textarea */
		$.each(array_data, function(key, value) {
			if (key.indexOf('attendee') == 0) {
				$($('#paged_form input[name="' + key + '"]')[0]).prop('checked', value=='attended');
			} else {
				$($('#paged_form input[name="' + key + '"], #paged_form textarea[name="' + key + '"]')[0]).val(value);
			}
		});
	}
}

function update_page_numbering(page_num, total_pages) {
	$("#pager").html("Page " + page_num + " of " + total_pages);
	$("#num_items").val("10");
}

$(document).ready(function() {
	$('#new_form_1').click(function(event) {
		event.preventDefault();
		if (confirm('Changes will be LOST!!!, proceed to NEW FORM?')) {
			clear_seminar();
			var temp1 = document.getElementById('new_form');
			var temp2 = document.getElementById('edit_existing');
			if (temp1 != null) {
				document.body.removeChild(temp1);
			}
			if (temp2 != null) {
				document.body.removeChild(temp2);
			}
			
			re_initialize_page();
			clear_form();
			get_page(current);
			current_page(current);
			update_page_numbering(current, total_pages);
	
			var temp = $('#new_form');
			if (temp.length == 0) {
				temp = $(document.createElement('div'));
				temp.prop('id', 'new_form');
				temp.prop('hidden', true);
			}
			temp.val('new-form-from-click');
		}
	});	
});

function re_initialize_page() {
	$('#loading-wrapper').addClass('loading');
	if (($('#new_form').val() != undefined) || ($('#edit_existing').val() != undefined)) {
		reset_page_storage();
	}
	$.each($('#paged_form input[name^="attendee"]'), function(key, value) {
		$(this).prop('checked', $(value).val() =='attended');
	});
	var current = current_page();
	var total_pages = num_pages();

	if (current > 0) {
		get_page(current);
		if (total_pages < current) {
			num_pages(total_pages = current);			
		}
	} else {
		current = 1;
		total_pages = 1;
	}
	update_page_numbering(current, total_pages);
	$('#loading-wrapper').removeClass('loading');
}
