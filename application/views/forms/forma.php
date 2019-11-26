<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');

$forma = FormAClass::getFormFromVariable($form_A);
// echo '<pre>';
// print_r($forma);exit;
$count = 0;
$class4Ps = 0;
$classNon4Ps = 0;
$classUsapan = 0;
$classPMC = 0;
$classH2H = 0;
$classProfiled = 0;
$targetCouples = 0;

$sub_class4Ps = 0;
$sub_classNon4Ps = 0;
$sub_classUsapan = 0;
$sub_classPMC = 0;
$sub_classH2H = 0;
$sub_classProfiled = 0;
$sub_TotalClass = 0;
$sub_targetCouples = 0;
?>

<?php if($is_pdf) { ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
	<style>
		.small {
			font-size: 12px!important;
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
				<p class="small text-right">FORM A</p>
			</div>
		</div>
		<div class="text-center">
			<p class="small">
				<b>
					RPFP CLASSES IMPLEMENTATION REPORT <br>
					FOR THE PERIOD <?=$forma->Period->MonthsPeriod; ?> <?= $_GET['ReportYear']; ?> <br>
					POPCOM Regional Office <?=$forma->Period->RegionalOffice; ?> <br>
					DEMAND GENERATION ACTIVITIES
				</b>
			</p>
		</div>
		
		<?php if(!$is_pdf) : ?>
	        <div id="leftButton">
	        	<a href="<?= base_url('menu/formA') ?>" class="save">
                    <span>BACK</span>
                </a>
		    </div>
		    <div id="rightButton">
	        	<a href="<?= base_url('forms/viewforma') ?>" class="save" target="_blank">
                    <span>PRINT</span>
                </a>
		    </div>
	    <?php endif; ?>
        <div class="padding-t20">
			<div class="table-responsive">	
				<table class="table table-bordered margin-b0">
					<thead>
						<tr>
							<th rowspan="3" class="text-center padding-0">
								<p class="small">Month</p>									
							</th>
							<th colspan="7" class="text-center padding-0">
								<p class="small">
									<b>
										No. of Classes/Sessions Held
									</b>
								</p>
							</th>
							<th rowspan="3" class="text-center padding-0">
								<p class="small">
									<b>
										Target No. <br> 
										of Couples/<br>
										Individuals
									</b>
								</p>
							</th>
							<th colspan="7" class="text-center padding-0">
								<p class="small">
									<b>
										No. of Individuals of Reproductive Age Reached
									</b>
								</p>
							</th>
							<th colspan="3" class="text-center padding-0">
								<p class="small">
									<b>
										Solo/Couple Disaggregation
									</b>
								</p>
							</th>
							<th rowspan="3" class="text-center padding-0">
								<p class="small">Total Couples/ <br>Individuals <br>Reached</p>									
							</th>
						</tr>
						<tr>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Sub Module <br>
										2.2 (4Ps)
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Non- <br>
										4Ps
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										USAPAN
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										PMC
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										H2H
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Profiled <br>
										Only
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Total
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Sub Module <br>
										2.2 (4Ps)
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Non- <br>
										4Ps
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										USAPAN
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										PMC
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										H2H
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Profiled <br>
										Only
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Total
									</b>
								</p>
							</th>
							<th colspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Solo Attendees
									</b>
								</p>
							</th>
							<th rowspan="2" class="text-center padding-0">
								<p class="small">
									<b>
										Couple <br>
										Attendees
									</b>
								</p>
							</th>
						</tr>
						<tr>
							<th class="text-center padding-0">
								<p class="small">
									<b>
										Male
									</b>
								</p>
							</th>
							<th class="text-center padding-0">
								<p class="small">
									<b>
										Female
									</b>
								</p>
							</th>
						</tr>
					</thead>
					<?php for ($iii=1; $iii <= 4; $iii++): ?>
					<?php for ($ii=1; $ii <= 3; $ii++): ?>
					<!-- <?php $i = 1 + $i; ?> -->
						<tr>
						<?php foreach ($form_A as $forma) : ?>
							<td class="text-center">
								<p class="small">
									<b>
										<?= date('F',strtotime('01.'.$i.'.2001'))?>
									<b>
								</p>
							</td>
							<td>
									<?php 
										if($forma->Class4Ps != 'N/A') {
											echo $forma->Class4Ps;
											$class4Ps= $forma->Class4Ps;
											$sub_class4Ps+= $forma->Class4Ps;
										} else {
											echo 0;
										}
									?>
							</td>
							<td>
									<?php 
										if($forma->ClassNon4Ps != 'N/A') {
											echo $forma->ClassNon4Ps;
											$classNon4Ps= $forma->ClassNon4Ps;
											$sub_classNon4Ps+= $forma->ClassNon4Ps;
										} else {
											echo 0;
										}
									?>
							</td>
							<td>
									<?php 
										if($forma->ClassUsapan != 'N/A') {
											echo $forma->ClassUsapan;
											$classUsapan= $forma->ClassUsapan;
											$sub_classUsapan+= $forma->ClassUsapan;
										} else {
											echo 0;
										}
									?>
							</td>
							<td>
									<?php 
										if($forma->ClassPMC != 'N/A') {
											echo $forma->ClassPMC;
											$classPMC= $forma->ClassPMC;
											$sub_classPMC+= $forma->ClassPMC;
										} else {
											echo 0;
										}
									?>
							</td>
							<td>
									<?php 
										if($forma->ClassH2H != 'N/A') {
											echo $forma->ClassH2H;
											$classH2H= $forma->ClassH2H;
											$sub_classH2H+= $forma->ClassH2H;
										} else {
											echo 0;
										}
									?>
							</td>
							<td>
									<?php 
										if($forma->ClassProfiled != 'N/A') {
											echo $forma->ClassProfiled;
											$classProfiled= $forma->ClassProfiled;
											$sub_classProfiled+= $forma->ClassProfiled;
										} else {
											echo 0;
										}
									?>
							</td>
							<td>
								<?= $sub_TotalClass = $class4Ps + $classNon4Ps + $classUsapan + $classPMC + $classH2H + $classProfiled ?>
							</td>
							<td>
									<?php 
										if($forma->TargetCouples != 'N/A') {
											echo $forma->TargetCouples;
											$targetCouples= $forma->TargetCouples;
											$sub_targetCouples+= $forma->TargetCouples;
										} else {
											echo 0;
										}
									?>
							</td>
							<td><?= $forma->WRA4Ps ?></td>
							<td><?= $forma->WRANon4Ps ?></td>
							<td><?= $forma->WRAUsapan ?></td>
							<td><?= $forma->WRAPMC ?></td>
							<td><?= $forma->WRAH2H ?></td>
							<td><?= $forma->WRAProfiled ?></td>
							<td></td>
							<td><?= $forma->SoloMale ?></td>
							<td><?= $forma->SoloFemale ?></td>
							<td><?= $forma->CoupleAttendee ?></td>
							<td><?= $forma->TotalReached ?></td>
						<?php endforeach; ?>
						</tr>
					<?php endfor; ?>
					<?php $ii=1; ?>
						<tr>
							<td class="text-center">
								<p class="small text-danger">
									<b>
										Sub-Total
									</b>
								</p>
							</td>
							<td><?= $sub_class4Ps+= $sub_class4Ps ?></td>
							<td><?= $sub_classNon4Ps+= $sub_classNon4Ps ?></td>
							<td><?= $sub_classUsapan+= $sub_classUsapan ?></td>
							<td><?= $sub_classPMC+= $sub_classPMC ?></td>
							<td><?= $sub_classH2H+= $sub_classH2H ?></td>
							<td><?= $sub_classProfiled+= $sub_classProfiled ?></td>
							<td><?= $sub_TotalClass+= $sub_TotalClass ?></td>
							<td><?= $sub_targetCouples+= $sub_targetCouples ?></td>
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
								<p class="small text-primary">
									<b>
										Grand Total
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

			<div class="padding-t20">
				<p class="small"><b>Note: Profiled only are not to be included in the total accomplishment</b></p>
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
					<td style="padding-left: 20px; padding-top: 40px; border: none;"></td>
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
	</div>
</div>