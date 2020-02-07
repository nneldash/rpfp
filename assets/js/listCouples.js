function listCoupleModal()
{
	$('.btn-pending-listing').click(function(event) {
		event.preventDefault();

		var classNo = $(this).parent().siblings(':first').text();
		$('.modal-title').text(classNo);

		$('#coupleModal').modal();

		$.post(base_url + 'menu/pendingCoupleModal', {'classId' : classNo})
		.done(function(html){
			$('.modal-body').html(html);
		});
	});

	$('.btn-approve-listing').click(function(event) {
		event.preventDefault();

		var classNo = $(this).parent().siblings(':first').text();
		$('.modal-title').text(classNo);

		$('#coupleModal').modal();

		$.post(base_url + '/menu/approveCoupleModal', {'classId' : classNo})
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}

function fpType()
{
	$('.for_modernfp_user').hide();

	$('.fp_type').change(function(){
		var fpType = $('select[name="fptype_search"]').val();

		if (fpType == 'modernfp_user') {
			$('.non_fp_intention_status').hide();
			$('.intention_status').prop('disabled', true);
			$('.for_modernfp_user').show();
			$('.modernfp_user').prop('disabled', false);
			$('.with_intention').hide();
			$('.intention_to_use').prop('disabled', true)
			$('.for_modernfp_user').html('<label class="control-label col-md-3 col-xs-12">Modern FP</label>' +
                					'<div class="col-md-7 col-xs-12">' +
                						'<select name="modernfp_search" class="form-control modernfp_user">' +
											'<option value=""></option>' +
											'<option value="1">Condom</option>' +
											'<option value="2">IUD</option>' +
											'<option value="3">Pills</option>' +
											'<option value="4">Injectible</option>' +
											'<option value="5">Vasectomy</option>' +
											'<option value="6">Ligation</option>' +
											'<option value="7">Implant</option>' +
											'<option value="8">CMM</option>' +
											'<option value="9">BBT</option>' +
											'<option value="10">STM</option>' +
											'<option value="11">SDM</option>' +
											'<option value="12">LAM</option>' +
										'</select>' +
									'</div>');
		} else if (fpType == 'non_fp_user') {
			$('.for_modernfp_user').show();
			$('.for_modernfp_user').html('<label class="control-label col-md-3 col-xs-12">Non Modern FP</label>' +
									'<div class="col-md-7 col-xs-12">' +
										'<select name="nonmodern_search" class="form-control non_fp">' +
											'<option value=""></option>' +
											'<option value="1">Withdrawal</option>' +
											'<option value="2">Rhythm</option>' +
											'<option value="3">Calendar</option>' +
											'<option value="4">Abstinence</option>' +
											'<option value="5">Herbal</option>' +
											'<option value="6">No Method</option>' +
										'</select>' +
									'</div>');

			$('.non_fp_intention_status').show();
			$('.intention_status').prop('disabled', false);
			$('.non_fp_intention_status').html('<label class="control-label col-md-3 col-xs-12">Intention Status</label>' +
												'<div class="col-md-7 col-xs-12">' +
													'<select name="intention_status_search" class="form-control intention_status" onChange="intentionToUse();">' +
														'<option value=""></option>' +
														'<option value="1">With Intention</option>' +
														'<option value="2">Undecided</option>' +
														'<option value="3">Currently Pregnant</option>' +
														'<option value="4">No Intention</option>' +
													'</select>' +
													'</div>');						
		} else {
			$('.for_modernfp_user').hide();
			$('.modernfp_user').prop('disabled', true);
			$('.non_fp_intention_status').hide();
			$('.intention_status').prop('disabled', true);
			$('.with_intention').hide();
			$('.intention_to_use').prop('disabled', true);
		}

	});


}

function intentionToUse()
{
	var withIntention = $('select[name="intention_status_search"]').val();

	if (withIntention == 1) {
		$('.with_intention').show();
		$('.intention_to_use').prop('disabled', false);
		$('.with_intention').html('<label class="control-label col-md-3 col-xs-12">Intention To Use</label>' +
									'<div class="col-md-7 col-xs-12">' +
										'<select name="intention_to_use_search" class="form-control intention_to_use">' +
											'<option value=""></option>' +
											'<option value="1">Condom</option>' +
											'<option value="2">IUD</option>' +
											'<option value="3">Pills</option>' +
											'<option value="4">Injectible</option>' +
											'<option value="5">Vasectomy</option>' +
											'<option value="6">Ligation</option>' +
											'<option value="7">Implant</option>' +
											'<option value="8">CMM</option>' +
											'<option value="9">BBT</option>' +
											'<option value="10">STM</option>' +
											'<option value="11">SDM</option>' +
											'<option value="12">LAM</option>' +
										'</select>' +
									'</div>');
	} else {
		$('.with_intention').hide();
		$('.intention_to_use').prop('disabled', true);
	}
}

function numbersOnly()
{
	$('input').bind('keyup',function(){
		var ageFrom = $.isNumeric($('input[name="agefrom_search"]').val());
		var ageTo = $.isNumeric($('input[name="ageto_search"]').val());
		var noChildren = $.isNumeric($('input[name="no_children_search"]').val());

		if (ageFrom == false) {
			// alert(1);
		} else {
			// alert(2);
		}
	});
}

function searchNow()
{
	$('.search_now').click(function(e){
		e.preventDefault(); 

		var search = $('#search_form').serialize();

		$.ajax({
			type: 'POST',
			data: search,
			url: base_url + '/menu/approvedClassSearch'
		}).done(function(result){
			console.log(result);
			// $('.table-search-results').html(tableResults(result));
		});
		
	})
}

function tableResults(result)
{
	return '<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">' +
				'<thead>' +
				'<tr>' +
					'<th>Class #</th>' +
					'<th>Type Class</th>' +
					'<th>Province</th>' +
					'<th>Municipality / City</th>' +
					'<th>Barangay</th>' +
					'<th>Number of Couples</th>' +
					'<th>Date Conducted</th>' +
					'<th>Encoded By</th>' +
					'<th style="width: 10%;">Action</th>' +
				'</tr>'+
			'</thead>' +
			'<tbody>' +
				'<tr >' +
					'<td>'+ result.xXxClassNo.davalue +'</td>' +
					'<td>'+ result.xXxTypeClass.davalue +'</td>' +
					'<td>'+ result.xXxProvince.davalue +'</td>' +
					'<td>'+ result.xXxMunicipality.davalue +'</td>' +
					'<td>'+ result.xXxBarangay.davalue +'</td>' +
					'<td>10</td>' +
					'<td>'+ result.xXxDateConduct.davalue +'</td>' +
					'<td>'+ result.xXxFirstName.davalue +' '+ result.xXxLastName.davalue +'</td>' +
					'<td class="text-center">' +
						'<a href="'+ base_url +'forms?rpfpId='+ result.xXxRpfpClass.davalue +'&status=0" target="_blank">' +
							'<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">' +
								'<i class="fa fa-edit"></i>' +
							'</button>' +
						'</a>' +
					'</td>' +
				'</tr>' +
			'</tbody>' +
			'</table>';
}

function liveSearch()
{
	$('#provinceList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var provinceId = $(e.target.options[clickedIndex]).val();
		$($('#search_form input[name="province_search"]')[0]).val(provinceId);

		$('#muniList').find('option').remove();
		$('#muniList').selectpicker('refresh');
		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getMunicipalities(provinceId);
	});

	$('#muniList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var muniId = $(e.target.options[clickedIndex]).val();
		$($('#search_form input[name="municipality_search"]')[0]).val(muniId);

		$('#brgyList').find('option').remove();
		$('#brgyList').selectpicker('refresh');
		getBrgys(muniId);
	});

	$('#brgyList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		var brgy_id = $(e.target.options[clickedIndex]).val();
		$($('#search_form input[name="barangay_search"]')[0]).val(brgy_id);
	});
}

var getProv = $('input[name="province"]').val();
var getCity = $('input[name="city"]').val();
var getBrgy = $('input[name="barangay"]').val();

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
