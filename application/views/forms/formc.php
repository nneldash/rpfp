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
			font-size: 12px!important;
		}
		.padding-b8 {
			padding-bottom: 0;
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

<div class="body-padding" style="padding-top: 0;">	
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
					FOR THE PERIOD <span style="text-transform: uppercase;"><?= ($formc_list->Header != 0 ? date('F', $formc_list->From) . ' - ' : '' ) ?> <?= date('F, Y', $formc_list->To) ?></span> <br>
					POPCOM <?= ($formc_list->RegionalOffice != '' ? 'Regional Office '. $formc_list->RegionalOffice : 'Central Office' ) ?> <br>
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
		        	<a href="<?= base_url('forms/viewformc?RegionalOffice=' . $this->input->get('RegionalOffice') . '&ReportNo=' . $this->input->get('ReportNo') . '&ReportMonth=' . $this->input->get('ReportMonth') . '&ReportYear=' . $this->input->get('ReportYear')); ?>" 
	                    class="save" 
	                    target="_blank">
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
									
				?>
						<tr>
							<td class="text-center">
								<p class="small">
									<b>
										<?= $formc->DateText ?>
									<b>
								</p>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedCondom); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedIUD); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedPills); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedInjectables); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedNSV); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedBTL); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedImplant); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedCMM); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedBBT); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedSymptoThermal); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedSDM); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->ServedLAM); ?>
							</td>
							<td style="text-align: right; padding-right: 10px;">
								<?php echo HtmlHelper::dashInputPdf($formc->TotalServed); ?>
							</td>
						</tr>
				<?php
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

							$grand_total->ServedCondom = (int)$grand_total->ServedCondom + (int)$formc->ServedCondom;
							$grand_total->ServedIUD = (int)$grand_total->ServedIUD + (int)$formc->ServedIUD;
							$grand_total->ServedPills = (int)$grand_total->ServedPills + (int)$formc->ServedPills;
							$grand_total->ServedInjectables = (int)$grand_total->ServedInjectables + (int)$formc->ServedInjectables;
							$grand_total->ServedNSV = (int)$grand_total->ServedNSV + (int)$formc->ServedNSV;
							$grand_total->ServedBTL = (int)$grand_total->ServedBTL + (int)$formc->ServedBTL;
							$grand_total->ServedImplant = (int)$grand_total->ServedImplant + (int)$formc->ServedImplant;
							$grand_total->ServedCMM = (int)$grand_total->ServedCMM + (int)$formc->ServedCMM;
							$grand_total->ServedBBT = (int)$grand_total->ServedBBT + (int)$formc->ServedBBT;
							$grand_total->ServedSymptoThermal = (int)$grand_total->ServedSymptoThermal + (int)$formc->ServedSymptoThermal;
							$grand_total->ServedSDM = (int)$grand_total->ServedSDM + (int)$formc->ServedSDM;
							$grand_total->ServedLAM = (int)$grand_total->ServedLAM + (int)$formc->ServedLAM;
							$grand_total->TotalServed = (int)$grand_total->TotalServed + (int)$formc->TotalServed;

							if ($z == 3) {
						?>
								<tr>
									<td class="text-center">
										<p class="small">
											<b>
												Subtotal
											<b>
										</p>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedCondom); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedIUD); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedPills); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedInjectables); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedNSV); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedBTL); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedImplant); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedCMM); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedBBT); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedSymptoThermal); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedSDM); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->ServedLAM); ?>
									</td>
									<td style="text-align: right; padding-right: 10px;">
										<?php echo HtmlHelper::dashInputPdf($sub_total->TotalServed); ?>
									</td>
								</tr>
						<?php
								$x++;
								/** subtotal here */
								$z = 1;
								$sub_total->ServedCondom = 0;
								$sub_total->ServedIUD = 0;
								$sub_total->ServedPills = 0;
								$sub_total->ServedInjectables = 0;
								$sub_total->ServedNSV = 0;
								$sub_total->ServedBTL = 0;
								$sub_total->ServedImplant = 0;
								$sub_total->ServedCMM = 0;
								$sub_total->ServedBBT = 0;
								$sub_total->ServedSymptoThermal = 0;
								$sub_total->ServedSDM = 0;
								$sub_total->ServedLAM = 0;
								$sub_total->TotalServed = 0;
							} else {
								$y++;
								$z++;
							}
						}
							if ($y < 3) {
						?>
							<tr>
								<td class="text-center">
									<p class="small">
										<b>
											Subtotal
										<b>
									</p>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedCondom); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedIUD); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedPills); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedInjectables); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedNSV); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedBTL); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedImplant); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedCMM); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedBBT); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedSymptoThermal); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;"	>
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedSDM); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;"	>
									<?php echo HtmlHelper::dashInputPdf($sub_total->ServedLAM); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;"	>
									<?php echo HtmlHelper::dashInputPdf($sub_total->TotalServed); ?>
								</td>
							</tr>
						<?php
							}
						?>
							<tr>
								<td class="text-center">
									<p class="small">
										<b>
													Grand Total
										<b>
									</p>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedCondom); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedIUD); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedPills); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedInjectables); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedNSV); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedBTL); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedImplant); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedCMM); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedBBT); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedSymptoThermal); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedSDM); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->ServedLAM); ?>
								</td>
								<td style="text-align: right; padding-right: 10px;">
									<?php echo HtmlHelper::dashInputPdf($grand_total->TotalServed); ?>
								</td>
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
				<?php if (!$is_pdf): ?>
					<div class="text-right">
						<p><?= date('M d, Y h:ia')?></p>
					</div>
				<?php endif; ?>
			</div>
	    </form>
	</div>
</div>