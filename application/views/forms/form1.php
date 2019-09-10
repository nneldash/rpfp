<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
?>

<?php if($is_pdf){ ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
	<style>
		b {
			font-weight: bold;
		}
		.small {
			font-size: 8px;
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
	<div class="border-2">
		<div class="row">
			<div class="col-md-12 padding-r3p text-right">
				<p class="small">RPFP FORM 1</p>
			</div>
		</div>
		<div class="border-t1 flex">
			<p class="small padding-l5 padding-r30">
				<b>DISCLAIMER:</b>
				We hereby certify that we have read and understood the Notice on Privacy's and Disclosure written on the dorsal part 
				of this Responsible Parenthood and Family Planning (RPFP) Form and by signing and submitting this, we hereby grant the 
				Commission on Population (POPCOM), or any of its authorized agents and partners, the authority to collect, obtain, store 
				and process the personal information that we provide below for the purpose/s of 
			</p>
			<?php
                echo HtmlHelper::inputPdf(
                    $is_pdf,
                    "",
                    "text",
                    "purpose",
                    "padding-l10 underline width-10 text-left",
                    ""
                );
            ?>
		</div>
		<form id="form_validation" class="form-horizontal">
			<?php if(!$is_pdf) : ?>
				<div id="mybutton">					
		            <input type="submit" class="save saveForm1" value="SAVE" name="saveform1" />
		        </div>

		        <div id="myPrintButton">
		        	<div class="dropdown save">
						<button class="dropdown-toggle" type="button" data-toggle="dropdown">
							Menu
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="<?= base_url('menu')?>">Pending</a></li>
							<li><a href="<?= base_url('menu/approve')?>">Approved</a></li>
							<li><a href="#">Import Excel</a></li>
							<li><a href="#">Summary</a></li>
							<li><a href="<?= base_url('login/logoffUser')?>">Logout</a></li>
						</ul>
					</div>
			    </div>
			<?php endif; ?>
			<div class="border-t1 table-responsive">
				<div style="padding-top: 10px"></div>
				<table style="float: left" class="table">
					<tr>
						<td class="border-1 padding-0 back-eee" style="border-left: none">
							<?php if (!$is_pdf) : ?>
								<label class="cont border-t1">
									<input type="radio" name="type" value="4Ps" />
									<span class="checkmark"></span>
								</label>
							<?php endif; ?>
						</td>
						<td class="padding-r20p border-0">
							<span class="small padding-l100"><b>&nbsp;&nbsp;4Ps</b></span>
						</td>

						<td class="border-1 padding-0 back-eee" style="border: 1px solid">
							<?php if (!$is_pdf) : ?>
								<label class="cont">
									<input type="radio" name="type" value="house_to_house" />
									<span class="checkmark"></span>
								</label>
							<?php endif; ?>
						</td>
						<td class="padding-r20p border-0">
							<span class="small padding-l100"><b>&nbsp;&nbsp;House-to-House</b></span>
						</td>

						<td class="padding-r8p border-0">
							<span class="small">Class No.:</span>
						</td>
						<td class="padding-r15p border-0">
							<?php
	                            echo HtmlHelper::inputPdf(
	                                $is_pdf,
	                                "",
	                                "text",
	                                "class_no",
	                                "padding-l10 underline width-70",
	                                ""
	                            );
	                        ?>
						</td>
					</tr>
					<tr>
						<td class="border-1 width-30 padding-0 back-eee" style="border-left: none!important;">
							<?php if (!$is_pdf) : ?>
								<label class="cont border-t1">
									<input type="radio" name="type" value="faith_based_org" />
									<span class="checkmark"></span>
								</label>
							<?php endif; ?>
						</td>
						<td class="border-0">
							<span class="small"><b>&nbsp;&nbsp;Faith-Based Organization</b></span>
						</td>

						<td class="border-1 width-30 padding-0 back-eee">
							<?php if (!$is_pdf) : ?>
								<label class="cont border-t1">
									<input type="radio" name="type" value="profile" />
									<span class="checkmark"></span>
								</label>
							<?php endif; ?>
						</td>
						<td class="border-0">
							<span class="small"><b>&nbsp;&nbsp;Profile only</b></span>
						</td>

						<td class="border-0">
							<span class="small">Prov/City/Mun.:</span>
						</td>
						<td class="border-0">
							<?php
	                            echo HtmlHelper::inputPdf(
	                                $is_pdf,
	                                "",
	                                "text",
	                                "province",
	                                "padding-l10 underline width-70",
	                                ""
	                            );
	                        ?>
						</td>
					</tr>
					<tr>
						<td class="border-1 width-30 padding-0 back-eee" style="border-left: none">
							<?php if (!$is_pdf) : ?>
								<label class="cont border-t1">
									<input type="radio" name="type" value="pmc" />
									<span class="checkmark"></span>
								</label>
							<?php endif; ?>
						</td>
						<td class="border-0">
							<span class="small"><b>&nbsp;&nbsp;PMC</b></span>
						</td>

						<td class="border-1 width-30 padding-0 back-eee">
							<?php if (!$is_pdf) : ?>
								<label class="cont border-t1">
									<input id="others" type="radio" name="type" value="others_check" />
									<span class="checkmark"></span>
								</label>
							<?php endif; ?>
						</td>
						<td class="border-0">
							<span class="small"><b>&nbsp;&nbsp;Others, please specify </b>
								<?php
		                            echo HtmlHelper::inputPdf(
		                                $is_pdf,
		                                "",
		                                "text",
		                                "others",
		                                "padding-l10 underline width-20 disabled-others",
		                                ""
		                            );
		                        ?>
		                    </span>
						</td>

						<td class="border-0">
							<span class="small">Barangay:</span>
						</td>
						<td class="border-0">
							<?php
	                            echo HtmlHelper::inputPdf(
	                                $is_pdf,
	                                "",
	                                "text",
	                                "barangay",
	                                "padding-l10 underline width-70",
	                                ""
	                            );
	                        ?>
						</td>
					</tr>
					<tr>
						<td class="border-1 width-30 padding-0 back-eee" style="border-left: none">
							<?php if (!$is_pdf) : ?>
								<label class="cont border-t1">
									<input type="radio" name="type" value="usapan" />
									<span class="checkmark"></span>
								</label>
							<?php endif; ?>
						</td>
						<td class="border-0">
							<span class="small"><b>&nbsp;&nbsp;Usapan</b></span>
						</td>

						<td class="border-t1"></td>
						<td class="border-0"></td>

						<td class="border-0">
							<span class="small">Date Conducted:</span>
						</td>
						<td class="border-0">
							<?php
	                            echo HtmlHelper::inputPdf(
	                                $is_pdf,
	                                "",
	                                "date",
	                                "date_conducted",
	                                "padding-l10 underline width-70",
	                                ""
	                            );
	                        ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="padding-t20" style="page-break-inside: avoid">
				<div class="table-responsive" style="overflow: hidden;">	
					<table class="table table-bordered margin-b0">
						<thead>
							<tr>
								<?php if (!$is_pdf): ?>
									<th rowspan="2" class="text-center">
										<p class="small">
											<b>Approve Couple</b>
										</p>
									</th>
								<?php endif; ?>
								<th rowspan="2" style="border-left: none; width: 2%;"></th>
								<th rowspan="2" class="text-center padding-0" style="width: 18%">
									<p class="small">
										<b>
											Name of Participants/Couple (Husband & <br>
											Wife) PLEASE WRITE IN BOLD LETTERS <br>
											(name, surname)<br> (1)
										</b>
									</p>
								</th>
								<th colspan="6" class="text-center">
									<p class="small">
										<b>PROFILE</b>
									</p>
								</th>
								<th colspan="2" class="text-center">
									<p class="small">
										<b>Modern FP User</b>
									</p>
								</th>
								<th colspan="3" class="text-center">
									<p class="small">
										<b>Traditional FP User</b>
									</p>
								</th>
								<th rowspan="2" class="text-center" style="border-right: none">
									<p class="small">
										<b>PARTICIPANT'S SIGNATURE <br>(13)</b>
									</p>
								</th>
								<?php if(!$is_pdf): ?>
									<th rowspan="2" class="text-center" style="border-right: none">
										<p class="small">
											<b>Service Slip</b>
										</p>
									</th>
								<?php endif; ?>
							</tr>
							<tr>
								<th class="text-center" style="width: 5%">
									<p class="small">
										<b>Sex <br> (M/F) <br> (2)</b>
									</p>
								</th>
								<th class="text-center" style="width: 5%">
									<p class="small">
										<b>Civil <br>Status <br> (3)</b>
									</p>
								</th>
								<th class="text-center">
									<p class="small">
										<b>Birthdate / Age <br>(4)</b>
									</p>
								</th>
								<th class="text-center">
									<p class="small">
										<b>Address / Household ID Number<br>(5)</b>
									</p>
								</th>
								<th class="text-center">
									<p class="small">
										<b>
											Highest <br> 
											Educational <br> 
											Attainment <br>
											(6)
										</b>
									</p>
								</th>
								<th class="text-center" style="width: 5%">
									<p class="small">
										<b>
											No. of <br> 
											Children <br>
											(7)
										</b>
									</p>
								</th>
								<th class="text-center" style="width: 5%">
									<p class="small">
										<b>
											Method <br> 
											Used <br> 
											(8)
										</b>
									</p>
								</th>
								<th class="text-center">
									<p class="small">
										<b>
											Intention to <br> 
											shift to other <br> 
											FP method <br> 
											(9)
										</b>
									</p>
								</th>
								<th class="text-center" style="width: 5%">
									<p class="small">
										<b>Type <br> (10)</b>
									</p>
								</th>
								<th class="text-center" style="width: 5%">
									<p class="small">
										<b>Status <br> (11)</b>
									</p>
								</th>
								<th class="text-center">
									<p class="small">
										<b>
											Reason for<br> 
											Intending to use FP <br> 
											Method <br> (12)
										</b>
									</p>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php for($i = 0; $i <= 9; $i++): ?>
								<tr>
									<?php if (!$is_pdf): ?>
										<td rowspan="2">
											<label class="cont">
												<input type="checkbox" name="type" value="attended" />
												<span class="checkmark"></span>
											</label>
										</td>
									<?php endif; ?>
									<td class="text-center" style="border-left: none" rowspan="2">
										<p class="small"><?= $i + 1; ?></p>
									</td>
									<td class="small" style="padding: 5px;">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                $is_pdf,
				                                "",
				                                "text",
				                                "name_participant1[".$i."]",
				                                "padding-l10",
				                                ""
				                            );
				                        ?>
									</td>
									<td class="small text-center">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                                "",
				                                "text",
				                                "sex1[".$i."]",
				                                "text-center",
				                                "1"
				                            );
				                        ?>
									</td>
									<td class="small text-center">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "civil_status1[".$i."]",
				                                "text-center",
				                                "1"
				                            );
				                        ?>
									</td>
									<td class="small text-center">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "age1[".$i."]",
				                                "text-center",
				                                ""
				                            );
				                        ?>
									</td>
									<td class="small text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "address[".$i."]",
				                                "height-50 padding-l10",
				                                ""
				                            );
				                        ?>
									</td>
									<td class="small text-center">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "educ1[".$i."]",
				                                "text-center",
				                                "1"
				                            );
				                        ?>
									</td>
									<td class="small text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "no_of_children[".$i."]",
				                                "height-50 text-center",
				                                "2"
				                            );
				                        ?>
									</td>
									<td class="small text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "method[".$i."]",
				                                "height-50 text-center",
				                                "2"
				                            );
				                        ?>
									</td>
									<td class="small text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "fp_method[".$i."]",
				                                "height-50 text-center",
				                                "2"
				                            );
				                        ?>
									</td>
									<td class="small text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "type[".$i."]",
				                                "height-50 text-center",
				                                "1"
				                            );
				                        ?>
									</td>
									<td class="small text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "status[".$i."]",
				                                "height-50 text-center",
				                                "1"
				                            );
				                        ?>
									</td>
									<td class="small text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "reason[".$i."]",
				                                "height-50 text-center",
				                                "1"
				                            );
				                        ?>
									</td>
									<td class="small" style="border-right: none; padding: 0">
										<?php if (!$is_pdf) : ?>
											<label class="cont">
												<input type="checkbox" name="type" value="attended" />
												<span class="checkmark"></span>
											</label>
										<?php endif; ?>
									</td>
									<?php if(!$is_pdf): ?>
										<td class="small text-center" rowspan="2">
											<button class="btn-slip">Service Slip</button>
										</td>
									<?php endif; ?>
								</tr>
									<tr>
										<td class="small" style="padding: 5px;">
											<?php
					                            echo HtmlHelper::inputPdf(
					                            	$is_pdf,
					                                "",
					                                "text",
					                                "name_participant2[".$i."]",
					                                "padding-l10",
					                                ""
					                            );
					                        ?>
										</td>
										<td class="small text-center">
											<?php
					                            echo HtmlHelper::inputPdf(
					                            	$is_pdf,
					                                "",
					                                "text",
					                                "sex2[".$i."]",
					                                "text-center",
					                                "1"
					                            );
					                        ?>
										</td>
										<td class="small text-center">
											<?php
					                            echo HtmlHelper::inputPdf(
					                            	$is_pdf,
					                            	"",
					                                "text",
					                                "civil_status2[".$i."]",
					                                "text-center",
					                                "1"
					                            );
					                        ?>
										</td>
										<td class="small text-center">
											<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "age2[".$i."]",
				                                "text-center",
				                                ""
				                            );
				                        ?>
										</td>
										<td class="small text-center">
											<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	"",
				                                "text",
				                                "educ2[".$i."]",
				                                "text-center",
				                                "1"
				                            );
				                        ?>
										</td>
										<td class="small" style="border-right: none; padding: 0">
											<?php if (!$is_pdf) : ?>
												<label class="cont">
													<input type="checkbox" name="type" value="attended" />
													<span class="checkmark"></span>
												</label>
											<?php endif; ?>
										</td>
								</tr>
							<?php endfor; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div style="page-break-inside: avoid;">
				<p class="small text-center">NOTE: Please use CODE NUMBER below for Civil Status, Educational Attainment and Method Used</p>
				<div class="table-responsive">	
					<table class="table table-bordered margin-b0">
						<thead>
							<tr>
								<th class="text-center" rowspan="2" style="border-left: none; width: 10%">
									<p class="small">
										<b>Civil Status</b> <br> 
										(Column 3)
									</p>
								</th>
								<th class="text-center" colspan="2" rowspan="2" style="width: 10%">
									<p class="small">
										<b>Highest Educational Attainment</b> <br> 
										(Column 6)
									</p>
								</th>
								<th class="text-center" colspan="4" style="width: 15%">
									<p class="small">
										<b>Modern FP Method Used</b> <br> 
										(Columns 8 & 9)
									</p>
								</th>
								<th class="text-center" rowspan="2" style="width: 10%">
									<p class="small">
										<b>
											Reason for Using FP / <br> 
											Intending to Use 
										</b> 
										<br> (Column 12)
									</p>
								</th>
								<th class="text-center" rowspan="2" colspan="2" style="width: 10%">
									<p class="small">
										<b>Traditional FP User: TYPE </b> <br> 
										(Column 10)
									</p>
								</th>
								<th class="text-center" rowspan="2" style="border-right: none; width: 20%">
									<p class="small">
										<b>Non-Modern FP User: STATUS </b> <br> 
										(Column 11)
									</p>
								</th>
							</tr>
							<tr>
								<th class="text-center" colspan="2">
									<p class="small">
										<b>Artificial Methods:</b>
									</p>
								</th>
								<th class="text-center" colspan="2" style="width: 10%">
									<p class="small">
										<b>Modern NFP Methods:</b>
									</p>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="padding-left: 10px;" style="border-left: none">
									<p class="small">
										1 - Married <br>
										2 - Single <br>
										3 - Widow/Widower <br>
										4 - Separated <br>
										5 - Live-in
									</p>								
								</td>
								<td style="border-right: none; padding-left: 5px;">
									<p class="small">
										1 - No Education  <br>
										2 - Elementary Level <br>
										3 - Elementary Graduate <br>
										4 - High School Level <br>
										5 - High School Graduate 
									</p>
								</td>
								<td style="border-left: none;">
									<p class="small">
										6 - Vocational <br>
										7 - College Level <br>
										8 - College Graduate <br>
										9 - Post Graduate
									</p>
								</td>
								<td style="border-right: none; padding-left: 5px;">
									<p class="small">
										1 - Condom  <br>
										2 - IUD <br>
										3 - Pills <br>
										4 - Injectable
									</p>
								</td>
								<td style="border-left: none;">
									<p class="small">
										5 - Vasectomy <br>
										6 - Tubal Ligation <br>
										7 - Implant
									</p>
								</td>
								<td style="border-right: none; padding-left: 5px;">
									<p class="small">
										8 - CMM / Billings  <br>
										9 - BBT <br>
										10 - Sympto-Thermal
									</p>
								</td>
								<td style="border-left: none;">
									<p class="small">
										11 - SDM <br>
										12 - LAM
									</p>
								</td>

								<td style="padding-left: 5px;">
									<p class="small">
										1 - Spacing <br>
										2 - Limiting <br>
										3 - Achieving
									</p>
								</td>
								<td style="border-right: none; padding-left: 5px;">
									<p class="small">
										1 - Withdrawal <br>
										2 - Rhythm <br>
										3 - Calendar <br>
										4 - Abstinence
									</p>
								</td>
								<td style="border-left: none;">
									<p class="small">
										5 - Herbal <br>
										6 - No Method
									</p>
								</td>
								<td style="padding-left: 5px; border-right: none">
									<p class="small">
										A - Espressing Intention to Use Modern FP <br> 
											Method (indicate CODE for Modern FP Methods <br> 
											use col. 8) <br>
										B - Undecided <br>
										C - Currently Pregnant <br>
										D - No Intention to Use
									</p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<table class="table border-0">
					<tr>
						<td class="border-0 padding-l20"></td>
						<td class="border-0">
							<p class="small">Prepared by:</p>
						</td>
						<td class="border-0">
							<p class="small">Reviewed by:</p>
						</td>
						<td class="border-0">
							<p class="small">Approved by:</p>
						</td>
						<td class="border-0"></td>
					</tr>
					<tr>
						<td class="border-0 padding-5"></td>
						<td class="border-0"></td>
						<td class="border-0"></td>
						<td class="border-0"></td>
						<td class="border-0"></td>
					</tr>
					<tr>
						<td class="border-0 padding-l20"></td>
						<td class="border-0">
							_______________________________
						</td>
						<td class="border-0">
							_______________________________
						</td>
						<td class="border-0">
							_______________________________
						</td>
						<td class="border-0"></td>
					</tr>
					<tr>
						<td class="border-0 padding-l20"></td>
						<td class="border-0 padding-l20">
							<p class="small">Name/Signature of RPM Team Member/s</p>
						</td>
						<td class="border-0 padding-l60">
							<p class="small">Name & Signature</p>
						</td>
						<td class="border-0">
							<p class="small">Name & Signature of Provincial/City Population Officer</p>
						</td>
						<td class="border-0"></td>
					</tr>
				</table>
			</div>
		</form>
	</div>
</div>

<?php if(!$is_pdf) : ?>
	<script type="text/javascript" src="<?= base_url('assets/js/form.js')?>"></script>
<?php endif; ?>