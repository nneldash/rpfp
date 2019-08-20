$(function() {
	saveForm();
});

function saveForm()
{
	$('.save').click(function(){
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
