/** PREVENT SAVE FORM UPON CLICK OF SERVICE SLIP */
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

		$('#muniList').find('option').remove();
		$('#muniList').selectpicker('refresh');
		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getMunicipalities(provinceId);
	});

	$('#muniList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var muniId = $(e.target.options[clickedIndex]).val();
		$($('#form_validation input[name="city"]')[0]).val(muniId);

		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getBrgys(muniId);
	});

	$('#brgyList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var brgy_id = $(e.target.options[clickedIndex]).val();
		$($('#form_validation input[name="barangay"]')[0]).val(brgy_id);
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
	noChildrenValidation();
	methodValidation();
	typeValidation();
	statusValidation();
	reasonValidation();
	typeUnmet();
	statusUnmet();

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

	setTimeout(getIntentionUse, 2000);
});

function getIntentionUse() 
{
	for(var i = 0; i <= 9 ; i ++) {
		var val = $('.tr1' + i).find('input[name="status[' + i +']"]').val();

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
	}
}

function click_click_click(id, couplesId)
{
	$('#'+ id +' .auto-fill-data').click(function(){
		$.ajax({
			type : 'POST',
			cache : true,
			url : base_url + 'forms/getDuplicateDetails',
			data : {
				'couplesId' : couplesId
			}
		}).done(function(result){
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
	 	
	 	$(this).on("click", function() {
			var id = $(this).attr('aria-describedby');
			click_click_click(id, couplesId);
		});
 	});

}


function sexValidation()
{
	$('.gender1').keydown(function(event){
		if(!(event.keyCode == 70 ||
			event.keyCode == 77  ||
			event.keyCode == 8 	 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.gender2').keydown(function(event){
		if(!(event.keyCode == 70 || 
			event.keyCode == 77  || 
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});
}

function noChildrenValidation()
{
	$('.noChildren').keydown(function(event){
		if(!(event.keyCode == 48 ||
			event.keyCode == 49 || 
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;	    	
	    }	

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
		if(!(event.keyCode == 65 || 
			event.keyCode == 66  ||
			event.keyCode == 67  ||
			event.keyCode == 68  ||
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }	    
		
		var index = $(this).closest('tr').find('input[class="slipIndex"]').val();
	    var val = $(this).val();
	    val = val.toUpperCase();

	    if(val == 'A') {
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
			event.keyCode == 8   || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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
			event.keyCode == 8 	 || 
			event.keyCode == 9)) 
		{
			event.preventDefault();
			return false;
	    }

	    if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
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

function criteria(index1, index2, gender1, gender2, age1, age2, type, status)
{
	if(status === '' || status === undefined) {
		console.log('');
	} else {
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
	if (status != 'C') {
		if (age >= 15 && age <= 49 && type >= 1 && type <= 5) {
			$('.tr1' + index + ' .criteria').find('.label-danger').removeClass('none');
		} else if (age >= 15 && age <= 49 && type == 6 && status == 'A') {
			$('.tr1' + index + ' .criteria').find('.label-danger').removeClass('none');
		} else {
			$('.tr1' + index + ' .criteria').find('.label-danger').addClass('none');
		}
	} else {
		$('.tr1' + index + ' .criteria').find('.label-danger').addClass('none');
	}
}

function getDataDuplicate()
{
	$('.fname1').keyup(function(){
		var fname1 = $(this).val();
		var lname1 = $(this).closest('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;

		var fname2 = $(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2 = $(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2 = $(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2 = $(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.lname1').keyup(function(){
		var lname1 = $(this).val();
		var fname1 = $(this).closest('tr').find('.fname1').val();
		var extname1 = $(this).closest('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;

		var fname2 = $(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2 = $(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2 = $(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2 = $(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.extname1').keyup(function(){
		var extname1 = $(this).val();
		var fname1 = $(this).closest('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').find('.lname1').val();
		var sex1 = $(this).closest('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;

		var fname2 = $(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2 = $(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2 = $(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2 = $(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);
	});

	$('.gender1').keyup(function(){
		var sex1 = $(this).val();
		var sex1 = sex1.toUpperCase();
		var fname1 = $(this).closest('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').find('.extname1').val();
		
		var bday1 = $(this).closest('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;

		var fname2 = $(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2 = $(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2 = $(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2 = $(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		var age1 	= $(this).closest('tr').find('.getAge1').val();
		var age2 	= $(this).closest('tr').next('tr').find('.getAge2').val();
		var type 	= $(this).closest('tr').find('.typeFp').val();
		var status 	= $(this).closest('tr').find('.status-trad').val();

		criteria(index, index, sex1, sex2, age1, age2, type, status);
		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.bday1').keyup(function(){
		var bday1 = $(this).val();

		dob1 = new Date(bday1);
		var today1 = new Date();
		var age1 = Math.floor((today1 - dob1) / (365.25 * 24 * 60 * 60 * 1000));

		var dateArr1 = bday1.split('-');

		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);

		var bday1 = year1 + '-' + month1 + '-' + day1;
		$(this).closest('td').find('.getAge1').val(age1);

		var fname1 = $(this).closest('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();

		var fname2 = $(this).closest('tr').next('.secondRow').find('.fname2').val();
		var lname2 = $(this).closest('tr').next('.secondRow').find('.lname2').val();
		var extname2 = $(this).closest('tr').next('.secondRow').find('.extname2').val();
		var sex2 = $(this).closest('tr').next('.secondRow').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').next('.secondRow').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var index = $(this).closest('tr').find('.loopIndex1').val();

		var age2 	= $(this).closest('tr').next('tr').find('.getAge2').val();
		var type 	= $(this).closest('tr').find('.typeFp').val();
		var status 	= $(this).closest('tr').find('.status-trad').val();

		criteria(index, index, sex1, sex2, age1, age2, type, status);
		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.fname2').keyup(function(){
		var fname2 = $(this).val();
		var lname2 = $(this).closest('tr').find('.lname2').val();
		var extname2 = $(this).closest('tr').find('.extname2').val();
		var sex2 = $(this).closest('tr').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var fname1 = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;
		
		var index = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.lname2').keyup(function(){
		var lname2 = $(this).val();
		var fname2 = $(this).closest('tr').find('.fname2').val();
		var extname2 = $(this).closest('tr').find('.extname2').val();
		var sex2 = $(this).closest('tr').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var fname1 = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;

		var index = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);

		if(!$(this).prop('required')) {
	    	$(this).closest('tr').find('.require-this').attr('required', 'required');
	    	$(this).closest('tr').find('.required').removeAttr('hidden', 'hidden');
	    }
	});

	$('.extname2').keyup(function(){
		var extname2 = $(this).val();
		var fname2 = $(this).closest('tr').find('.fname2').val();
		var lname2 = $(this).closest('tr').find('.lname2').val();
		var sex2 = $(this).closest('tr').find('.gender2').val();
		var sex2 = sex2.toUpperCase();
		
		var bday2 = $(this).closest('tr').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var fname1 = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;

		var index = $(this).closest('tr').find('.loopIndex2').val();

		autoGetData(fname1, lname1, extname1, sex1, bday1, fname2, lname2, extname2, sex2, bday2, index);
	});

	$('.gender2').keyup(function(){
		var sex2 = $(this).val();
		var sex2 = sex2.toUpperCase();
		var fname2 = $(this).closest('tr').find('.fname2').val();
		var lname2 = $(this).closest('tr').find('.lname2').val();
		var extname2 = $(this).closest('tr').find('.extname2').val();
		
		var bday2 = $(this).closest('tr').find('.bday2').val();
		var dateArr2 = bday2.split('-');
		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);
		var bday2 = year2 + '-' + month2 + '-' + day2;

		var fname1 = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;

		var index = $(this).closest('tr').find('.loopIndex2').val();

		var age1 	= $(this).closest('tr').prev('tr').find('.getAge1').val();
		var age2 	= $(this).closest('tr').find('.getAge2').val();
		var type 	= $(this).closest('tr').prev('tr').find('.typeFp').val();
		var status 	= $(this).closest('tr').prev('tr').find('.status-trad').val();

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

		var dateArr2 = bday2.split('-');

		var month2 = $.trim(dateArr2[0]);
		var day2 = $.trim(dateArr2[1]);
		var year2 = $.trim(dateArr2[2]);

		var bday2 = year2 + '-' + month2 + '-' + day2;
		$(this).closest('td').find('.getAge2').val(age2);

		var index2 = $(this).closest('tr').find('.loopIndex2').val();
		var fname2 = $(this).closest('tr').find('.fname2').val();
		var lname2 = $(this).closest('tr').find('.lname2').val();
		var extname2 = $(this).closest('tr').find('.extname2').val();
		var sex2 = $(this).closest('tr').find('.gender2').val();
		var sex2 = sex2.toUpperCase();

		var fname1 = $(this).closest('tr').prev('tr').find('.fname1').val();
		var lname1 = $(this).closest('tr').prev('tr').find('.lname1').val();
		var extname1 = $(this).closest('tr').prev('tr').find('.extname1').val();
		var sex1 = $(this).closest('tr').prev('tr').find('.gender1').val();
		var sex1 = sex1.toUpperCase();
		
		var bday1 = $(this).closest('tr').prev('tr').find('.bday1').val();
		var dateArr1 = bday1.split('-');
		var month1 = $.trim(dateArr1[0]);
		var day1 = $.trim(dateArr1[1]);
		var year1 = $.trim(dateArr1[2]);
		var bday1 = year1 + '-' + month1 + '-' + day1;
		
		var index = $(this).closest('tr').find('.loopIndex2').val();

		var age1 	= $(this).closest('tr').prev('tr').find('.getAge2').val();
		var type 	= $(this).closest('tr').find('.typeFp').val();
		var status 	= $(this).closest('tr').find('.status-trad').val();

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
	var status = '';
	if (sex1 === 'F' && sex2 === 'M') {
		var h_fname = fname2;
		var h_lname = lname2;
		var h_extname = extname2;
		var h_bday = bday2;
		var w_fname = fname1;
		var w_lname = lname1;
		var w_bday = bday1;
	} else if(sex2 === 'F' && sex1 === 'M') {
		var h_fname = fname1;
		var h_lname = lname1;
		var h_extname = extname1;
		var h_bday = bday1;
		var w_fname = fname2;
		var w_lname = lname2;
		var w_bday = bday2;
	} else {
		return false;
	}

	$.ajax({
			type : 'POST',
			cache : true,
			url : base_url + 'forms/checkCoupleDuplicate',
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
		if (result.ActiveStatus === '2') {
			status = 'Pending';
		} else if (result.ActiveStatus === '0') {
			status = 'Approve';
		} else {
			status;
		}

		if (result.CheckCount >= 1) {
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
		
		save_page(current_page());
		var formData = {};
		/** iterate all inputs/textarea */
		$.each( $('#form_validation input, #form_validation textarea'), function(key, value) {
			formData[$(value).attr('name')] = $(value).val();
		});
				
		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			url: base_url + '/forms/saveForm1'
		}).done(function(result){
			Toast.fire({
				type: (result.is_save == true) ? 'success' : 'error',
				title: 'Form 1 save status',
				message: result.message == undefined ? "There was an error saving Form 1" : result.message
			});
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


$(document).ready(function(){
	if (($('#new_form').val() != undefined) || ($('#edit_existing').val() != undefined)) {
		reset_page_storage();
	}
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
		var current_value = $($(this).siblings('input[type=checkbox]')[0]).val();
		$($(this).siblings('input[type=checkbox]')[0]).val(current_value == 'attended' ? "" : 'attended');
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
}

$(document).ready(function() {
	$('#new_form_1').click(function() {
		if (confirm('Changes will be LOST!!!, proceed to NEW FORM?')) {
			// window.location.href = base_url + "/Forms/new";
			reset_page_storage()
		}
	});
});
