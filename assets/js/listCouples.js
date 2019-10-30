var base_url = window.location.origin + '/rpfp';

$(function(){
	listCoupleModal();
});

function listCoupleModal()
{
	$('.btn-listing').click(function(event) {
		event.preventDefault();

		var classNo = $(this).parent().siblings(':first').text();
		$('.modal-title').text(classNo);

		$('#coupleModal').modal();

		$.post(base_url + '/menu/coupleModal')
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}