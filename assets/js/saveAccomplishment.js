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
		getSubmit(ReportYear, ReportMonth);
	});
}

function getSubmit(month, year)
{
	$('.genAccompSubmit').click(function() {
		// const Toast = Swal.mixin({
		// 	toast: true,
		// 	position: 'top-end',
		// 	showConfirmButton: false,
		// 	timer: 3000
		// });

		$.post(base_url + 'accomplishment/genAccompData', {'month' : month, 'year' : year})
		.done(function(result){
			console.log(result);
			// if(result.is_save == true) {
			// 	Toast.fire({
			// 		type: 'success',
			// 		title: 'Accomplishment Report successfully generated!'
			// 	});
			// } else {
			// 	Toast.fire({
			// 		type: 'error',
			// 		title: 'An error occurred.'
			// 	});
			// }
		});
	});
}