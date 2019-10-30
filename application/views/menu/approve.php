<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<link href="NewAssets/fontAwesome" rel="stylesheet">
<link href="<?= base_url('NewAssets/datatablesBootstrap') ?>" rel="stylesheet">
<link href="<?= base_url('NewAssets/datatablesResponsive') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<br>
<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
		<?php foreach($approve as $approved) : ?>
			<tr>
				<td><?= $approved->ClassNo ?></td>
				<td><?= $approved->TypeClass ?></td>
				<td><?= $approved->Barangay; ?></td>
				<td><?= date('F d, Y', strtotime($approved->DateConduct)); ?></td>
				<td class="text-center">
					<button class="btn btn-primary btn-approve-listing" data-toggle="tooltip" data-placement="left" title="View List">
						<i class="fa fa-list"></i>
					</button>					
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript" src="<?= base_url('assets/js/listCouples.js')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableBtJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableRpJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableBtrpJs')?>"></script>