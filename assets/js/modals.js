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
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		// Swal.fire({
		// 	title: 'Are you sure?',
		// 	text: "You won't be able to revert this!",
		// 	icon: 'warning',
		// 	showCancelButton: true,
		// 	confirmButtonColor: 'rgb(4, 65, 16)',
		// 	cancelButtonColor: '#d33',
		// 	confirmButtonText: 'Yes, delete it!'
		// }).then((result) => {
		// 	if (result.value) {
		// 		var formData = {};
	
		// 		$.each($('input[class="checkSelect"]:checked'), function(key, value) {
		// 			var item = $(value).val();
		// 			var className = $(value).attr('name');
			
		// 			formData[className] = item;
		// 		});

		// 		$.ajax({
		// 			type: 'POST',
		// 			dataType: 'JSON',
		// 			data: formData,
		// 			url: base_url + 'accomplishment/deleteAccomplishment'
		// 		}).done(function(result){
		// 			console.log(result);

		// 			if (result.message == 'deleted') {
		// 				Swal.fire(
		// 					'Deleted!',
		// 					'Report has been deleted.',
		// 					'success'
		// 				)
		// 				// location.reload();
		// 			} else {
		// 				Swal.fire(
		// 					'Deleted!',
		// 					'Report has been deleted.',
		// 					'error'
		// 				)
		// 			}	
					
		// 			return false;
		// 		});
				
		// 	}
		// });

		var formData = {};
	
		$.each($('input[class="checkSelect"]:checked'), function(key, value) {
			var item = $(value).val();
			var className = $(value).attr('name');
	
			formData[className] = item;
		});

		formData['reportName'] = $('input[name="reportName"]').val();

		// console.log(formData);
		// return false;

		$.ajax({
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			url: base_url + 'report/deleteReport'
		}).done(function(result){
			console.log(result);
			return false;

			if (result.message == 'deleted') {
				Toast.fire({
					type: 'success',
					title: 'Record deleted.'
				});
				location.reload();
			} else {
				Toast.fire({
					type: 'error',
					title: 'An error occured.'
				});
			}	
			
			return false;
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
