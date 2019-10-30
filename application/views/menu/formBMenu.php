<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<link href="NewAssets/fontAwesome" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<br>
<div style="text-transform: none; width: 15%;">					
    <input type="submit" class="save" value="Generate Report" name="genReportB" />
</div>
<br>
<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Report Year</th>
			<th>Report Month</th>
			<th>Date Generated</th>
			<th style="width: 10%;">Action</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>2019</td>
			<td>October</td>
			<td>October 23, 2019</td>
			<td class="text-center">
				<a class="viewForm folderview" href="<?= base_url('forms/formB'); ?>" target="_blank">
					<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
						<i class="fa fa-folder-o"></i>
						<i class="fa fa-folder-open-o"></i>
					</button>
				</a>
			</td>
		</tr>
		<tr>
			<td>2019</td>
			<td>September</td>
			<td>Sepetember 18, 2019</td>
			<td class="text-center">
				<a class="viewForm folderview" href="<?= base_url('forms/formB'); ?>" target="_blank">
					<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
						<i class="fa fa-folder-o"></i>
						<i class="fa fa-folder-open-o"></i>
					</button>
				</a>
			</td>
		</tr>
		<tr>
			<td>2019</td>
			<td>August</td>
			<td>August 20, 2019</td>
			<td class="text-center">
				<a class="viewForm folderview" href="<?= base_url('forms/formB'); ?>" target="_blank">
					<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
						<i class="fa fa-folder-o"></i>
						<i class="fa fa-folder-open-o"></i>
					</button>
				</a>
			</td>
		</tr>
	</tbody>
</table>