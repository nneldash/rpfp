loadJs(base_url + '/NewAssets/templateJs',
	function() { searchAdvanceModal(); }
);

function searchAdvanceModal()
{
	$('.btn-searchAdvance').click(function(event) {
		event.preventDefault();

		$('#searchAdvanceModal').modal();

		$.post(base_url + '/menu/searchAdvanceModal')
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}