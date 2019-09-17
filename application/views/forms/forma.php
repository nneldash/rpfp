<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
echo '<pre>';
print_r($forma);
exit;
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
					FOR THE PERIOD ___________________ 2018 <br>
					POPCOM Regional Office __________ <br>
					DEMAND GENERATION ACTIVITIES
				</b>
			</p>
		</div>
		
		<?php if(!$is_pdf) : ?>
	        <div id="leftButton">
	        	<a href="<?= base_url('menu') ?>" class="save">
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