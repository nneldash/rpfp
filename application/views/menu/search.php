<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

<style>
	.btn-search {
		border: 1px solid;
	    background: #076c1b;
	    padding: 10px;
	    width: 100%;
	    color: #fff;
	}
</style>

<div class="container">
	<div class="row">
		<div class="text-center">
			<button class="btn btn-search">
				<i class="fa fa-search"> Search Form 1</i>
			</button>
			<!-- <form class="form-horizontal">
				<input type="text" class="form-control" name="search" />
				<span class="fa fa-search form-control-feedback right" aria-hidden="true"></span>
			</form> -->
		</div>
		<br>
		<div class="table-responsive">
			<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Class #</th>
						<th>Type Class</th>
						<th>City</th>
						<th>Barangay</th>
						<th>Date Conducted</th>
						<th style="width: 10%;">Action</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>

	</div>
</div>