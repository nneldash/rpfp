<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="table-responsive">	
	<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap pendingList" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Class #</th>
				<th>Type Class</th>
				<th>Barangay</th>
				<th>Date Conducted</th>
				<th style="width: 10%;">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($forms as $form): ?>
				<tr>
					<td><?= $form->ClassNo; ?></td>
					<td><?= $form->TypeClass; ?></td>
					<td><?= $form->Barangay; ?></td>
					<td><?= date('F d, Y', strtotime($form->DateConduct)); ?></td>
					<td class="text-center">
						<a href="<?= base_url('forms?rpfpId='.($form->RpfpClass)); ?>" target="_blank">
							<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
								<i class="fa fa-edit"></i>
							</button>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script>
	$(document).ready( function () {
		var table = $('.pendingList').DataTable();
	});
</script>