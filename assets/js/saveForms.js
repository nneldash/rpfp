$(function(){
	genAccomp();
});

function genAccomp()
{
	$('select[id=repYearSelect]').change(function(){
		var ReportYear = $(this).val();
		getYear(ReportYear);
	});

}

function getYear(ReportYear)
{
	$('select[id=repMonthSelect]').change(function(){
		var ReportMonth = $(this).val();
		getSubmit(ReportMonth, ReportYear);
	});
}

function getSubmit(month, year)
{
	var formName = $('.formName').val();

	$('.genFormSubmit').click(function() {
		var that = $(this);
		openLoader(that);

		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		$.post(base_url + 'FormGeneration/'+ formName, {'year' : year, 'month' : month})
		.done(function(result){
			$('#accompModal').modal('hide');
			if(result.is_save == true) {
				window.location.reload();
				Toast.fire({
					type: 'success',
					title: 'Accomplishment Report successfully generated!'
				});
			} else {
				Toast.fire({
					type: 'error',
					title: 'An error occurred.'
				});
			}
		});
	});
}

function openLoader(that)
{
	that.attr('disabled',true);
	that.find('i').addClass('hidden');
	var loader = '<i class="fa fa-loading fa-spinner fa-spin"></i>';
	that.find('.buttonload').html(loader);
}