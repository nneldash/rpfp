
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
