<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
$formc_list = ReportFormC::getFromVariable($form_C);
?>

<?php if($is_pdf){ ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
	<style>
		@page {
			margin: 0 80px;
		}
		.small {
			font-size: 14px!important;
		}
	</style>
<?php } else { ?>
	<style>
		.table-bordered > tbody > tr > td,
		.table-bordered > thead > tr > th,
		.table-bordered {
			border: 1px solid #000;
		}		
	</style>
<?php } ?>

<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<div class="body-padding">	
	<div class="">
		<div class="row">
			<div class="col padding-r3p padding-b8">
				<p class="small text-right">FORM C</p>
			</div>
		</div>
		<div class="text-center">
			<p class="small">
				<b>
					RPFP CLASSES IMPLEMENTATION REPORT <br>
					FOR THE PERIOD <?= strtoupper( date('F, Y', $formc_list->From)) ?> <br>
					POPCOM Regional Office <?=$formc_list->RegionalOffice; ?> <br>
					TOTAL NUMBER OF COUPLES SERVED WITH UNMET NEED
				</b>
			</p>
		</div>
		<form id="form_validation" class="form-horizontal">
			<?php if(!$is_pdf) : ?>
		        <div id="leftButton">
		        	<a href="<?= base_url('menu/formC') ?>" class="save">
                        <span>BACK</span>
                    </a>
			    </div>
			    <div id="rightButton">
		        	<a href="<?= base_url('forms/viewformc') ?>" class="save" target="_blank">
                        <span>PRINT</span>
                    </a>
			    </div>
		    <?php endif; ?>
	        <div class="padding-t20">
				<div class="table-responsive">	
					<table class="table table-bordered margin-b0">
						<thead>
							<tr>
								<th rowspan="2" class="text-center padding-0">
									<p class="small">Region/ <br>Province</p>									
								</th>
								<th colspan="13" class="text-center padding-0">
									<p class="small">
										<b>
											Number Served by Method Mix
										</b>
									</p>
								</th>
							</tr>
							<tr>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											Condom
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											IUD
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											Pills
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											Injectables
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											NSV
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											BTL
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											Sub- <br>Dermal<br>Implant
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											CMM/<br>Billings
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											BBT
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											Sympto-<br>Thermal
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											SDM
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											LAM
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											TOTAL
										</b>
									</p>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i=1; $i <= 3; $i++): ?>
								<tr>
									<td class="text-center">
										<p class="small">
											<b>
												<?= date('F',strtotime('01.'.$i.'.2001'))?>
											</b>
										</p>
									</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							<?php endfor; ?>
							<tr>
								<td class="text-center">
									<p class="small text-danger">
										<b>
											Sub-Total
										</b>
									</p>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php for ($i=4; $i <= 6; $i++): ?>
								<tr>
									<td class="text-center">
										<p class="small">
											<b>
												<?= date('F',strtotime('01.'.$i.'.2001'))?>
											</b>
										</p>
									</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							<?php endfor; ?>
							<tr>
								<td class="text-center">
									<p class="small text-danger">
										<b>
											Sub-Total
										</b>
									</p>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php for ($i=7; $i <= 9; $i++): ?>
								<tr>
									<td class="text-center">
										<p class="small">
											<b>
												<?= date('F',strtotime('01.'.$i.'.2001'))?>
											</b>
										</p>
									</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							<?php endfor; ?>
							<tr>
								<td class="text-center">
									<p class="small text-danger">
										<b>
											Sub-Total
										</b>
									</p>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php for ($i=10; $i <= 12; $i++): ?>
								<tr>
									<td class="text-center">
										<p class="small">
											<b>
												<?= date('F',strtotime('01.'.$i.'.2001'))?>
											</b>
										</p>
									</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							<?php endfor; ?>
							<tr>
								<td class="text-center">
									<p class="small text-danger">
										<b>
											Sub-Total
										</b>
									</p>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="text-center">
									<p class="small text-primary">
										<b>
											Total
										</b>
									</p>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				<br><br>
				<table class="table">
					<tr>
						<td style="padding-left: 20px; border: none"></td>
						<td style="border: none">
							<p class="small">Prepared by:</p>
						</td>
						<td style="border: none">
							<p class="small">Noted by:</p>
						</td>
						<td style="border: none">
							<p class="small">Approved by:</p>
						</td>
						<td style="border: none"></td>
					</tr>
					<tr>
						<td style="padding: 5px; border: none;"></td>
						<td style="border: none">
							
						</td>
						<td style="border: none">
							
						</td>
						<td style="border: none">
							
						</td>
						<td style="border: none"></td>
					</tr>
					<tr>
						<td style="padding-left: 20px; padding-top: 30px; border: none;"></td>
						<td style="border: none">
							
						</td>
						<td style="border: none">
							
						</td>
						<td style="border: none">
							
						</td>
						<td style="border: none"></td>
					</tr>
					<tr>
						<td style="padding-left: 20px; border: none"></td>
						<td style="padding-left: 20px; border: none;">

						</td>
						<td style="border: none;">
							<p class="small">Planning Officer IV</p>
						</td>
						<td style="border: none">
							<p class="small">Regional Director</p>
						</td>
						<td style="border: none"></td>
					</tr>
				</table>
			</div>
	    </form>
	</div>
</div>