$(function() {
	saveForm1();
	saveFormA();
});

function saveForm1()
{
	$('.saveForm1').click(function(){
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		Toast.fire({
			type: 'success',
			title: 'Form 1 successfully saved!'
		});

		return false;
	});

}

function saveFormA()
{
	$('.saveFormA').click(function(){
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		Toast.fire({
			type: 'success',
			title: 'Form A successfully saved!'
		});

		return false;
	});

}
