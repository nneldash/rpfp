loadJs(base_url + '/NewAssets/templateJs',
	function() { listAccomplishmentModal(); }
);

function listAccomplishmentModal()
{
	$('.btn-accomplishment-listing').click(function(event) {
		event.preventDefault();

		var reportNo = $(this).parent().siblings(':first').text();
		$('.modal-title').text(reportNo);

		$('#accomplishmentModal').modal();

		$.post(base_url + '/menu/accomplishmentModal', {'reportId' : reportNo})
		.done(function(html){
			$('.modal-body').html(html);
		});
	});
}