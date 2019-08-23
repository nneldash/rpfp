<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
?>

<?php if($is_pdf): ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
	<style>
		.small {
			font-size: 12px!important;
		}
	</style>
<?php endif?>
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
				<div id="mybutton">
		            <input type="submit" class="save saveFormA" value="SAVE" name="saveform1" />
		        </div>
		        <div id="myPrintButton">
		        	<a href="<?= base_url('forms/viewformb') ?>" class="save printForm1" target="_blank">
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
								<th rowspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											W/out intention <br>
											to shift modern <br>
											FP
										</b>
									</p>
								</th>
								<th rowspan="2" class="text-center padding-0">
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
							</tr>
						</tbody>
					</table>
				</div>

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
						<td style="padding-left: 20px; border: none;"></td>
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
						<td style="padding-left: 60px; border: none;">
							<p class="small">Planning Officer IV</p>
						</td>
						<td style="border: none">
							<p class="small">Regional Director</p>
						</td>
						<td style="border: none"></td>
					</tr>
				</table>
				<!-- <div class="padding-t20">
					<p class="small"><b>Note: Profiled only are not to be included in the total accomplishment</b></p>
				</div>
				<div class="flex padding-t20">
					<p class="small padding-l10p">Prepared by:</p>
					<p class="small padding-l30p">Reviewed by:</p>
					<p class="small padding-l28p">Approved by:</p>
				</div> -->
			</div>
	    </form>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/form.js')?>"></script>