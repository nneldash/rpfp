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

function deleteAccomplishment()
{
	$('#checkAll').click(function(){
		var checked = $(this).prop('checked');

		if ($(this).is(':checked')) {
			$('input[type="checkbox"]').prop('checked', checked);
			$('input[name="deleteAccomplishment"]').attr('hidden', false);
		} else {
			$('input[type="checkbox"]').prop('checked', false);
			$('input[name="deleteAccomplishment"]').attr('hidden', true);
		}
	});

	$('.checkAccomp').click(function(){
		var checked = $(this).prop('checked');

		if ($(this).is(':checked')) {
			$('input[name="deleteAccomplishment"]').attr('hidden', false);
		} else {
			$('input[name="deleteAccomplishment"]').attr('hidden', true);
		}
	});

	$('input[name="deleteAccomplishment"]').click(function(){
		var formData = {};

		$.each($('.checkAccomp').filter(':checked'), function(key, value) {
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

