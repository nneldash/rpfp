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
	$('.for_fp_user').hide();

	$('.fp_type').change(function(){
		var fpType = $('select[name="fptype_search"]').val();

		if (fpType == 'fp_user') {
			$('.non_fp_intention_status').hide();
			$('.intention_status').prop('disabled', true);
			$('.for_fp_user').show();
			$('.fp_user').prop('disabled', false);
			$('.for_fp_user').html('<label class="control-label col-md-3 col-xs-12">FP User</label>' +
                					'<div class="col-md-7 col-xs-12">' +
                						'<select name="fpuser_search" class="form-control fp_user">' +
											'<option value=""></option>' +
											'<option value="condom">Condom</option>' +
											'<option value="iud">IUD</option>' +
											'<option value="pills">Pills</option>' +
											'<option value="injectible">Injectible</option>' +
											'<option value="vasectomy">Vasectomy</option>' +
											'<option value="ligation">Ligation</option>' +
											'<option value="implant">Implant</option>' +
											'<option value="cmm">CMM</option>' +
											'<option value="bbt">BBT</option>' +
											'<option value="stm">STM</option>' +
											'<option value="sdm">SDM</option>' +
											'<option value="lam">LAM</option>' +
										'</select>' +
									'</div>');
		} else if (fpType == 'non_fp_user') {
			$('.for_fp_user').show();
			$('.for_fp_user').html('<label class="control-label col-md-3 col-xs-12">Non FP User</label>' +
									'<div class="col-md-7 col-xs-12">' +
										'<select name="nonfpuser_search" class="form-control non_fp" onChange="nonFpUser();">' +
											'<option value=""></option>' +
											'<option value="non_modern_fp">Non Modern FP Method</option>' +
											'<option value="intention_status">Intention Status</option>' +
										'</select>' +
									'</div>');
		} else {
			$('.for_fp_user').hide();
			$('.fp_user').prop('disabled', true);
			$('.non_fp_intention_status').hide();
			$('.intention_status').prop('disabled', true);
		}

	});


}

function nonFpUser()
{
	var nonFp = $('select[name="nonfpuser_search"]').val();
	
	if (nonFp == 'intention_status') {
		$('.non_fp_intention_status').show();
		$('.intention_status').prop('disabled', false);
		$('.non_fp_intention_status').html('<label class="control-label col-md-3 col-xs-12">Intention Status</label>' +
											'<div class="col-md-7 col-xs-12">' +
												'<select name="intention_status_search" class="form-control intention_status">' +
													'<option value=""></option>' +
													'<option value="with_intention">With Intention</option>' +
													'<option value="undecided">Undecided</option>' +
													'<option value="currently_pregnant">Currently Pregnant</option>' +
													'<option value="no_intention">No Intention</option>' +
												'</select>' +
											'</div>');
	} else {
		$('.non_fp_intention_status').hide();
		$('.intention_status').prop('disabled', true);
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
			// console.log(result);
			$('.table-search-results').html(tableResults());
		});
		
	})
}

function tableResults()
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
				'<tr>' +
					'<td>RPFP-TAC-2019-00002</td>' +
					'<td>4Ps</td>' +
					'<td>LEYTE</td>' +
					'<td>CITY OF TACLOBAN (Capital)</td>' +
					'<td>Barangay 92 (Apitong)	</td>' +
					'<td>10</td>' +
					'<td>February 11, 2019</td>' +
					'<td>Rowel Reyes</td>' +
					'<td class="text-center">' +
						'<a href="'+ base_url +'forms?rpfpId=7&status=0" target="_blank">' +
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
