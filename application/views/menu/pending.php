<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('NewAssets/datatablesBootstrap') ?>" rel="stylesheet">
<link href="<?= base_url('NewAssets/datatablesResponsive') ?>" rel="stylesheet">


<p>Region: _____________________</p> <!-- insert region here -->
<br>
<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
	<tr>
		<th>Class #</th>
		<th>Date Conducted</th>
		<th>Encoded By</th>
		<th>Location</th>
		<th>Couple</th>
		<th style="width: 10%;">Action</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>4PS-BUL-ORMIN-1904-5112</td>
		<td>04/09/2019</td>
		<td>Rowel Reyes</td>
		<td>Bulacan City</td>
		<td>
			<ul>
				<li>Husband</li>
				<li>Wife</li>
			</ul>
		</td>
		<td class="text-center">
			<a href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
					<i class="fa fa-edit"></i>
				</button>
			</a>
			<a class="viewForm" href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="View">
					<i class="fa fa-folder-open-o"></i>
				</button>
			</a>
		</td>
	</tr>
	<tr>
		<td>H2H-BAN-ROM-19-04-5113</td>
		<td>04/09/2019</td>
		<td>Nixie Rojo</td>
		<td>Romblon City</td>
		<td>
			<ul>
				<li>Husband</li>
				<li>Wife</li>
			</ul>
		</td>
		<td class="text-center">
			<a href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
					<i class="fa fa-edit"></i>
				</button>
			</a>
			<a class="viewForm" href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="View">
					<i class="fa fa-folder-open-o"></i>
				</button>
			</a>
		</td>
	</tr>
	<tr>
		<td>N4PS-CAL-ORMIN-19-06-5114</td>
		<td>06/09/2019</td>
		<td>Ivan Alfonso</td>
		<td>Caloocan City</td>
		<td>
			<ul>
				<li>Husband</li>
				<li>Wife</li>
			</ul>
		</td>
		<td class="text-center">
			<a href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
					<i class="fa fa-edit"></i>
				</button>
			</a>
			<a class="viewForm" href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="View">
					<i class="fa fa-folder-open-o"></i>
				</button>
			</a>
		</td>
	</tr>
	<tr>
		<td>H2H-SJOSE-OCCI-19-01-5115</td>
		<td>01/09/2019</td>
		<td>Marlo Servo</td>
		<td>Mindoro</td>
		<td>
			<ul>
				<li>Husband</li>
				<li>Wife</li>
			</ul>
		</td>
		<td class="text-center">
			<a href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
					<i class="fa fa-edit"></i>
				</button>
			</a>
			<a class="viewForm" href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="View">
					<i class="fa fa-folder-open-o"></i>
				</button>
			</a>
		</td>
	</tr>
	<tr>
		<td>4PS-MAG-OCCI-19-07-5125</td>
		<td>09/07/2019</td>
		<td>King Funtanilla</td>
		<td>Makati City</td>
		<td>
			<ul>
				<li>Husband</li>
				<li>Wife</li>
			</ul>
		</td>
		<td class="text-center">
			<a href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
					<i class="fa fa-edit"></i>
				</button>
			</a>
			<a class="viewForm" href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="View">
					<i class="fa fa-folder-open-o"></i>
				</button>
			</a>
		</td>
	</tr>
	<tr>
		<td>N4PS-RIZAL-OCCI-19-04-5122</td>
		<td>09/04/2019</td>
		<td>Paulo Dognidon</td>
		<td>Rizal</td>
		<td>
			<ul>
				<li>Husband</li>
				<li>Wife</li>
			</ul>
		</td>
		<td class="text-center">
			<a href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
					<i class="fa fa-edit"></i>
				</button>
			</a>
			<a class="viewForm" href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="View">
					<i class="fa fa-folder-open-o"></i>
				</button>
			</a>
		</td>
	</tr>
	<tr>
		<td>N4PS-BOAC-MAR-19-06-5138</td>
		<td>09/09/2019</td>
		<td>Judith Maclang</td>
		<td>Antipolo City</td>
		<td>
			<ul>
				<li>Husband</li>
				<li>Wife</li>
			</ul>
		</td>
		<td class="text-center">
			<a href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
					<i class="fa fa-edit"></i>
				</button>
			</a>
			<a class="viewForm" href="<?= base_url('forms'); ?>" target="_blank">
				<button class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="View">
					<i class="fa fa-folder-open-o"></i>
				</button>
			</a>
		</td>
	</tr>
</tbody>
</table>

<script type="text/javascript" src="<?= base_url('assets/js/form.js')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableBtJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableRpJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableBtrpJs')?>"></script>