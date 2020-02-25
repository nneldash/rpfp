<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
$formb_list = ReportFormB::getFromVariable($form_B);
?>

<?php if($is_pdf){ ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
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
				<p class="small text-right">FORM B</p>
			</div>
		</div>
		<div class="text-center">
			<p class="small">
				<b>
					RPFP CLASSES IMPLEMENTATION REPORT <br>
					FOR THE PERIOD <?= strtoupper( date('F, Y', $formb_list->From)) ?> <br>
					POPCOM Regional Office <?=$formb_list->RegionalOffice; ?> <br>
					TOTAL NUMBER OF UNMET NEED
				</b>
			</p>
		</div>
		<form id="form_validation" class="form-horizontal">
			<?php if(!$is_pdf) : ?>
		        <div id="leftButton">
		        	<a href="<?= base_url('menu/formB') ?>" class="save">
                        <span>BACK</span>
                    </a>
			    </div>
			    <div id="rightButton">
		        	<a href="<?= base_url('forms/viewformb') ?>" class="save" target="_blank">
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
									<p class="small">Month</p>									
								</th>
								<th rowspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											No. of Couples with unmet need for Modern FP
										</b>
									</p>
								</th>
								<th rowspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											No. of Clients <br> 
											with Unmet <br>
											need for Modern FP <br>
											referred/ <br>
											served
										</b>
									</p>
								</th>
								<th colspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											No. of Couples who are currently using Traditional FP
										</b>
									</p>
								</th>
								<th rowspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											No. of Clients currently using Traditional FP referred/served
										</b>
									</p>
								</th>
								<th rowspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											Total No. of Unmet Need
										</b>
									</p>									
								</th>
								<th rowspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											Total No. of Clients referred/served
										</b>
									</p>									
								</th>
							</tr>
							<tr>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											W/out intention <br>
											to shift modern <br>
											FP
										</b>
									</p>
								</th>
								<th class="text-center padding-0">
									<p class="small">
										<b>
											W/ intention <br>
											to shift modern <br>
											FP
										</b>
									</p>
								</th>
							</tr>
						</thead>
							<?php

							$sub_total = new FormBClass();
							$grand_total = new FormBClass();
							$formb = new FormBClass();
							$num_entries = count($formb_list);
							$num_grand_total = 16;
							$x = -1;
							foreach ($formb_list as $key => $formb) {
							// for ($x = 0; $x < $num_grand_total; $x++) {
								$x++;
								$formb->DateText = date('F', $formb_list->From);
								$divisor = 4;
								$quarter = (int) ($x / $divisor);
								$offset = (int) ($x % $divisor) + 1;
								$list_position = $quarter * $divisor + $offset;

								if ($x == $num_grand_total) {
									$formb = $grand_total;
									$sub_total->DateText = "Grand Total";
								} elseif ($list_position > $num_entries) {
									$formb = new FormBClass();
								} elseif ($offset == 0) {
									/** subtotal here */
									$grand_total->UnmetModern = (int)$grand_total->UnmetModern + (int)$sub_total->UnmetModern;
									$grand_total->ServedModern = (int)$grand_total->ServedModern + (int)$sub_total->ServedModern;
									$grand_total->NoIntention = (int)$grand_total->NoIntention + (int)$sub_total->NoIntention;
									$grand_total->WithIntention = (int)$grand_total->WithIntention + (int)$sub_total->WithIntention;
									$grand_total->ServedTraditional = (int)$grand_total->ServedTraditional + (int)$sub_total->ServedTraditional;
									$grand_total->TotalUnmet = (int)$grand_total->TotalUnmet + (int)$sub_total->TotalUnmet;
									$grand_total->TotalServed = (int)$grand_total->TotalServed + (int)$sub_total->TotalServed;
									$formb = $sub_total;
									$sub_total = new FormBClass();
									$sub_total->DateText = "Subtotal";
								} else {
									/** forma_list */
									// $forma = $forma_list[$list_position];

									$sub_total->UnmetModern = (int)$sub_total->UnmetModern + (int)$formb->UnmetModern;
									$sub_total->ServedModern = (int)$sub_total->ServedModern + (int)$formb->ServedModern;
									$sub_total->NoIntention = (int)$sub_total->NoIntention ;
									$sub_total->WithIntention = (int)$sub_total->WithIntention + (int)$formb->WithIntention;
									$sub_total->ServedTraditional = (int)$sub_total->ServedTraditional + (int)$formb->ServedTraditional;
									$sub_total->TotalUnmet = (int)$sub_total->TotalUnmet + (int)$formb->TotalUnmet;
									$sub_total->TotalServed = (int)$sub_total->TotalServed + (int)$formb->TotalServed;
								}
								?>

								<tr>
									<td class="text-center">
										<p class="small">
											<b>
											<?= $formb->DateText ?>
											<b>
										</p>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formb->UnmetModern); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formb->ServedModern); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formb->NoIntention); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formb->WithIntention); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formb->ServedTraditional); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formb->TotalUnmet); ?>
									</td>
									<td>
										<?php echo HtmlHelper::dashInputPdf($formb->TotalServed); ?>
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