$(function(){
	clickModal();
});

function clickModal()
{
	$('.genAccomp').click(function(){
		$('.modal-title').text('Generate Report');

		$('#accompModal').modal();

		$.post(base_url + 'accomplishment/viewAccompModal')
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}