$(function(){
	clickModalAccomp();
	clickModalReportA();
	clickModalReportB();
	clickModalReportC();
});

function clickModalAccomp()
{
	$('.genAccomp').click(function(){
		$('.modal-title').text('Generate Report');

		$('#generateReportModal').modal();

		$.post(base_url + 'modals/viewAccompModal')
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}

function clickModalReportA()
{
	$('.genReportA').click(function(){
		$('.modal-title').text('Generate Report');

		$('#generateReportModal').modal();

		$.post(base_url + 'modals/viewFormAModal')
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}

function clickModalReportB()
{
	$('.genReportB').click(function(){
		$('.modal-title').text('Generate Report');

		$('#generateReportModal').modal();

		$.post(base_url + 'modals/viewFormBModal')
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}

function clickModalReportC()
{
	$('.genReportC').click(function(){
		$('.modal-title').text('Generate Report');

		$('#generateReportModal').modal();

		$.post(base_url + 'modals/viewFormCModal')
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}