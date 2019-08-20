<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
?>

<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">


<div class="body-padding">	
	<div class="border-2">
		<div class="row">
			<div class="col padding-r3p padding-b8">
				<p class="small float-right">FORM A</p>
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
		<form id="form_validation" class="form-horizontal">
			<div id="mybutton">
	            <input type="submit" class="save saveFormA" value="SAVE" name="saveform1" />
	        </div>
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
				<div class="flex padding-t20">
					<p class="small padding-l10p">Prepared by:</p>
					<p class="small padding-l30p">Reviewed by:</p>
					<p class="small padding-l28p">Approved by:</p>
				</div>
			</div>
	    </form>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/form.js')?>"></script>