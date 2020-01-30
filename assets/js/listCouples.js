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
			$('.for_fp_user').show();
			$('.for_fp_user').html('FP User: <select name="fpuser_search" style="width: 15%">'+
										'<option></option>'+
										'<option value="condom">Condom</option>'+
										'<option value="iud">IUD</option>'+
										'<option value="pills">Pills</option>'+
										'<option value="injectible">Injectible</option>'+
										'<option value="vasectomy">Vasectomy</option>'+
										'<option value="ligation">Ligation</option>'+
										'<option value="implant">Implant</option>'+
										'<option value="cmm">CMM</option>'+
										'<option value="bbt">BBT</option>'+
										'<option value="stm">STM</option>'+
										'<option value="sdm">SDM</option>'+
										'<option value="lam">LAM</option>'+
									'</select>');
		} else if (fpType == 'non_fp_user') {
			$('.for_fp_user').show();
			$('.for_fp_user').html('Non FP User: <select name="nonfpuser_search" class="non_fp" style="width: 15%" onChange="nonFpUser();">'+
										'<option></option>'+
										'<option value="non_modern_fp">Non Modern FP Method</option>'+
										'<option value="intention_status">Intention Status</option>'+
									'</select>');
		} else {
			$('.for_fp_user').hide();
		}

	});


}

function nonFpUser()
{
	var nonFp = $('select[name="nonfpuser_search"]').val();
	
	if (nonFp == 'intention_status') {
		$('.non_fp_intention_status').show();
		$('.non_fp_intention_status').html('Intention Status: <select name="intention_status_search" class="intention_status" style="width: 										15%"'+
												'<option><option>'+
												'<option value="with_intention">With Intention</option>'+
												'<option value="undecided">Undecided</option>'+
												'<option value="currently_pregnant">Currently Pregnant</option>'+
												'<option value="no_intention">No Intention</option>'+
											'</select>');
	} else {
		$('.non_fp_intention_status').hide();
	}
}

