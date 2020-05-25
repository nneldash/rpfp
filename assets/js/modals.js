function clickModalAccomp()
{
	$('.genAccomp').click(function(event){
		event.preventDefault();
		
		$('#generateReportModal').modal();
		$('#generateReportModal .modal-title').text('Generate Report');

		$.post(base_url + 'modals/viewAccompModal')
		.done(function(html){
			$('#generateReportModal .modal-body').html(html);
		});
	});
}

function deleteReport()
{
	$('#checkAll').click(function(){
		var checked = $(this).prop('checked');

		if ($(this).is(':checked')) {
			$('input[type="checkbox"]').prop('checked', checked);
			$('input[name="deleteButton"]').attr('hidden', false);
		} else {
			$('input[type="checkbox"]').prop('checked', false);
			$('input[name="deleteButton"]').attr('hidden', true);
		}
	});

	$('.checkSelect').click(function(){
		var checked = $(this).prop('checked');

		if ($(this).is(':checked')) {
			$('input[name="deleteButton"]').attr('hidden', false);
		} else {
			$('input[name="deleteButton"]').attr('hidden', true);
		}
	});

	$('input[name="deleteButton"]').click(function(){
		var formData = {};

		$.each($('.checkSelect').filter(':checked'), function(key, value) {
			var item = $(value).val();
			var className = $(value).attr('name');
	
			formData[className] = item;
		});

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			url: base_url + '/accomplishment/deleteAccomplishment'
		}).done(function(result){
			console.log(result);

			// Toast.fire({
			// 	type: 'success',
			// 	title: 'Record deleted.',
			// 	message: "Record deleted"
			// });
		});
	});
}

function clickModalReportA()
{
	$('.genReportA').click(function(event){
		event.preventDefault();

		$('#generateReportModal').modal();
		$('#generateReportModal .modal-title').text('Generate Report');

		$.post(base_url + 'modals/viewFormAModal')
		.done(function(html){
			$('#generateReportModal .modal-body').html(html);
		});
	});
}

function clickModalReportB()
{
	$('.genReportB').click(function(event){
		event.preventDefault();

		$('#generateReportModal').modal();
		$('#generateReportModal .modal-title').text('Generate Report');

		$.post(base_url + 'modals/viewFormBModal')
		.done(function(html){
			$('#generateReportModal .modal-body').html(html);
		});
	});
}

function clickModalReportC() {
	$('.genReportC').click(function (event) {
		event.preventDefault();

		$('#generateReportModal').modal();
		$('#generateReportModal .modal-title').text('Generate Report');

		$.post(base_url + 'modals/viewFormCModal')
			.done(function (html) {
				$('#generateReportModal .modal-body').html(html);
			});
	});
}
