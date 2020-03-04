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
						<?php

						$sub_total = new FormCClass();
						$grand_total = new FormCClass();
						$formc = new FormCClass();
						$num_entries = count($formc_list);
						$x = 1;
						$y = 1;
						$z = 1;
						$num_grand_total = 16;

						foreach ($formc_list as $key => $formc) {
						// for ($x = 0; $x < $num_grand_total; $x++) {
							$formc->DateText = date('F', strtotime(strtoupper( date('Y', $formc_list->From)) .'-' . $formc->ReportDate . '-1'));
									
							$divisor = 4;
							$quarter = (int) ($x / $divisor);
							$offset = (int) ($x % $divisor) + 1;
							$list_position = $quarter * $divisor + $offset;

							if ($z == 4) {
						?>
								<tr>
									<td class="text-center">
										<p class="small">
											<b>
													Subtotal
											<b>
										</p>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedCondom); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedIUD); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedPills); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedInjectables); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedNSV); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedBTL); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedImplant); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedCMM); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedBBT); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedSymptoThermal); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedSDM); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->ServedLAM); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formc->TotalServed); ?>
									</td>
								</tr>
						<?php
								$x++;
								/** subtotal here */
								$grand_total->ServedCondom = (int)$grand_total->ServedCondom + (int)$sub_total->ServedCondom;
								$grand_total->ServedIUD = (int)$grand_total->ServedIUD + (int)$sub_total->ServedIUD;
								$grand_total->ServedPills = (int)$grand_total->ServedPills + (int)$sub_total->ServedPills;
								$grand_total->ServedInjectables = (int)$grand_total->ServedInjectables + (int)$sub_total->ServedInjectables;
								$grand_total->ServedNSV = (int)$grand_total->ServedNSV + (int)$sub_total->ServedNSV;
								$grand_total->ServedBTL = (int)$grand_total->ServedBTL + (int)$sub_total->ServedBTL;
								$grand_total->ServedImplant = (int)$grand_total->ServedImplant + (int)$sub_total->ServedImplant;
								$grand_total->ServedCMM = (int)$grand_total->ServedCMM + (int)$sub_total->ServedCMM;
								$grand_total->ServedBBT = (int)$grand_total->ServedBBT + (int)$sub_total->ServedBBT;
								$grand_total->ServedSymptoThermal = (int)$grand_total->ServedSymptoThermal + (int)$sub_total->ServedSymptoThermal;
								$grand_total->ServedSDM = (int)$grand_total->ServedSDM + (int)$sub_total->ServedSDM;
								$grand_total->ServedLAM = (int)$grand_total->ServedLAM + (int)$sub_total->ServedLAM;
								$grand_total->TotalServed = (int)$grand_total->TotalServed + (int)$sub_total->TotalServed;
								$z = 1;
							} else {
								/** forma_list */
								// $forma = $forma_list[$list_position];

								$sub_total->ServedCondom = (int)$sub_total->ServedCondom + (int)$formc->ServedCondom;
								$sub_total->ServedIUD = (int)$sub_total->ServedIUD + (int)$formc->ServedIUD;
								$sub_total->ServedPills = (int)$sub_total->ServedPills + (int)$formc->ServedPills ;
								$sub_total->ServedInjectables = (int)$sub_total->ServedInjectables + (int)$formc->ServedInjectables;
								$sub_total->ServedNSV = (int)$sub_total->ServedNSV + (int)$formc->ServedNSV;
								$sub_total->ServedBTL = (int)$sub_total->ServedBTL + (int)$formc->ServedBTL;
								$sub_total->ServedImplant = (int)$sub_total->ServedImplant + (int)$formc->ServedImplant;
								$sub_total->ServedCMM = (int)$sub_total->ServedCMM + (int)$formc->ServedCMM;
								$sub_total->ServedBBT = (int)$sub_total->ServedBBT + (int)$formc->ServedBBT;
								$sub_total->ServedSymptoThermal = (int)$sub_total->ServedSymptoThermal + (int)$formc->ServedSymptoThermal;
								$sub_total->ServedSDM = (int)$sub_total->ServedSDM + (int)$formc->ServedSDM;
								$sub_total->ServedLAM = (int)$sub_total->ServedLAM + (int) $formc->ServedLAM;
								$sub_total->TotalServed = (int)$sub_total->TotalServed +  (int)$formc->TotalServed;
								$y++;
								$z++;
							}
							?>

							<tr>
								<td class="text-center">
									<p class="small">
										<b>
										<?= $formc->DateText ?>
										<b>
									</p>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedCondom); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedIUD); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedPills); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedInjectables); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedNSV); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedBTL); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedImplant); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedCMM); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedBBT); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedSymptoThermal); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedSDM); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedLAM); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->TotalServed); ?>
								</td>
							</tr>
							<?php
						}

						if ($y == $num_entries) {
						?>
							<tr>
								<td class="text-center">
									<p class="small">
										<b>
													Grand Total
										<b>
									</p>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedCondom); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedIUD); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedPills); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedInjectables); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedNSV); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedBTL); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedImplant); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedCMM); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedBBT); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedSymptoThermal); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedSDM); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->ServedLAM); ?>
								</td>
								<td>
									<?php echo HtmlHelper::dashInputPdf($formc->TotalServed); ?>
								</td>
							</tr>
						<?php
						}
						?>
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