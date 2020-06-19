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
			$('button[name="deleteButton"]').attr('hidden', false);
		} else {
			$('input[type="checkbox"]').prop('checked', false);
			$('button[name="deleteButton"]').attr('hidden', true);
		}
	});

	$('.checkSelect').click(function(){
		var checked = $(this).prop('checked');

		if ($(this).is(':checked')) {
			$('button[name="deleteButton"]').attr('hidden', false);
		} else {
			$('button[name="deleteButton"]').attr('hidden', true);
		}
	});

	$('button[name="deleteButton"]').click(function(){
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: 'rgb(4, 65, 16)',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				var formData = {};
				var deleteForm = $('input[name="reportName"]').val();
				var MY_LINK = '#/Menu/pending';

				if (deleteForm == 'accompReport') {
					MY_LINK = '#/Menu/accomplishment';
				} else if (deleteForm == 'formA'){ 
					MY_LINK = '#/Menu/forma';
				} else if (deleteForm == 'formB') {
					MY_LINK = '#/Menu/formb';
				} else if (deleteForm == 'formC') {
					MY_LINK = '#/Menu/formc';
				} else {
					MY_LINK = '#/Menu/pending';
				}
	
				$.each($('input[class="checkSelect"]:checked, input[name="reportName"]'), function(key, value) {
					var item = $(value).val();
					var className = $(value).attr('name');
			
					formData[className] = item;
				});

				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					data: formData,
					url: base_url + 'report/deleteReport'
				}).done(function(result){
					if (result.message == 'deleted') {
						Swal.fire({
							title: 'Success',
							text: "Record has been Deleted!",
							type: 'success',
							showCancelButton: false,
  							showConfirmButton: false
						});
						
						var active_a = $('ul.nav.side-menu li a[href="' + MY_LINK + '"]')[0];			
						active_a.click();
						var active_li = $(active_a.parentElement);
						active_li.addClass('active');

					} else {
						Toast.fire({
							text: "An error occured.",
							type: 'error'
						})
					}

					return false;
				});
			}
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
