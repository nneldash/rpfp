
$(document).ready( function() {
    $('#refresh').click(function(event) {
        event.preventDefault();
		//$('#menuModal').modal();
		var button_view =	`<div class="text-center">
								<button class="btn btn-primary btn-pending-listing" data-toggle="tooltip" data-placement="left" title="View List">
									<i class="fa fa-list"></i>
								</button>
							</div>`;

		$("#datatable-responsive").DataTable({
			"destroy": true,
			"ajax": {
				"url":"http://[::1]/rpfp/Couples/pendingList",
				"method": "POST",
				"data": {
					'items_per_page' : 3,
					'page_no': 2
				}
			},
			"initComplete": function() {
				refresh_now();
			},
			"columnDefs": [{
				"targets": -1,
				"data": null,
				"defaultContent": button_view
			}]
		});
	});
});

function refresh_now(reload) {
	$("ul.pagination").remove();
	$("div.dataTables_info").remove();
	$("div.dataTables_length").remove();
	$("#datatable-responsive_filter").remove();
	
}	
