<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
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
					FOR THE PERIOD January to December 2018 <br>
					TOTAL NUMBER OF UNMET NEED
				</b>
			</p>
		</div>
		<form id="form_validation" class="form-horizontal">
			<?php if(!$is_pdf) : ?>
		        <div id="leftButton">
		        	<a href="<?= base_url('menu') ?>" class="save">
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