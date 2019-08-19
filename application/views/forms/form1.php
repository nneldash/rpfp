<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
?>

<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<div class="body-padding">	
	<div class="border-2">
		<div class="row">
			<div class="col padding-r3p padding-b8">
				<p class="small float-right">RPFP FORM 1</p>
			</div>
		</div>
		<div class="border-t1">
			<p class="small padding-l5 padding-r30">
				<b>DISCLAIMER:</b>
				We hereby certify that we have read and understood the Notice on Privacy's and Disclosure written on the dorsal part 
				of this Responsible Parenthood and Family Planning (RPFP) Form and by signing and submitting this, we hereby grant the 
				Commission on Population (POPCOM), or any of its authorized agents and partners, the authority to collect, obtain, store 
				and process the personal information that we provide below for the purpose/s of 
			</p>
		</div>
		<form id="form_validation" class="form-horizontal">
			<div class="border-t1 flex">
				<div class="col-md-2 padding-l0 padding-t20">
					<div class="flex">
						<div class="width-20 height-20 border-1 margin-r5 border-l0 border-b0"></div>
						<p class="small"><b>4Ps</b></p>
					</div>
					<div class="flex">
						<div class="width-20 height-20 border-1 margin-r5 border-l0 border-b0"></div>
						<p class="small"><b>Faith-Based Organization</b></p>
					</div>
					<div class="flex">
						<div class="width-20 height-20 border-1 margin-r5 border-l0 border-b0"></div>
						<p class="small"><b>PMC</b></p>
					</div>
					<div class="flex">
						<div class="width-20 height-20 border-1 margin-r5 border-l0"></div>
						<p class="small"><b>Usapan</b></p>
					</div>
				</div>
				<div class="col-md-5 padding-l0 padding-t20">
					<div class="flex">
						<div class="width-8 height-20 border-1 margin-r5 border-b0"></div>
						<p class="small"><b>House-to-House</b></p>
					</div>
					<div class="flex">
						<div class="width-8 height-20 border-1 margin-r5 border-b0"></div>
						<p class="small"><b>Profile only</b></p>
					</div>
					<div class="flex">
						<div class="width-8 height-20 border-1 margin-r5"></div>
						<p class="small"><b>Others, please specify</b></p>
						<!-- <input type="text" name="" style="border-bottom: 1px solid; margin-left: 14%;" /> -->
					</div>
				</div>
				<div class="col-md-5 padding-l0 padding-t20">
					<div class="flex">
						<p class="small">Class No.:</p>
						<!-- <input type="text" name="" style="border-bottom: 1px solid; margin-left: 14%;" /> -->
					</div>
					<div class="flex">
						<p class="small">Prov/City/Mun.:</p>
						<!-- <input type="text" name="" style="border-bottom: 1px solid; margin-left: 14%;" /> -->
					</div>
					<div class="flex">
						<p class="small">Barangay</p>
						<!-- <input type="text" name="" style="border-bottom: 1px solid; margin-left: 14%;" /> -->
					</div>
					<div class="flex">
						<p class="small">Date Conducted</p>
						<!-- <input type="text" name="" style="border-bottom: 1px solid; margin-left: 14%;" /> -->
					</div>
				</div>
			</div>
			<div class="padding-t20">
				<div class="table-responsive">	
					<table class="table table-bordered margin-b0">
						<thead>
							<tr>
								<th rowspan="2"></th>
								<th rowspan="2" class="text-center padding-0">
									<p class="small">
										<b>
											Name of Participants/Couple (Husband & <br>
											Wife) PLEASE WRITE IN BOLD LETTERS <br>
											(name, surname)<br> (1)
										</b>
									</p>
								</th>
								<th colspan="6" class="text-center">
									<p class="small"><b>PROFILE</b></p>
								</th>
								<th colspan="2" class="text-center">
									<p class="small"><b>Modern FP User</b></p>
								</th>
								<th colspan="3" class="text-center">
									<p class="small"><b>Traditional FP User</b></p>
								</th>
								<th rowspan="2" class="text-center">
									<p class="small"><b>PARTICIPANT'S SIGNATURE <br>(13)</b></p>
								</th>
							</tr>
							<tr>
								<th class="text-center">
									<p class="small"><b>Sex <br> (M/F) <br> (2)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Civil <br>Status <br> (3)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Birthdate / Age <br>(4)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Address / Household ID Number<br>(5)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Highest <br> Educational <br> Attainment <br>(6)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>No. of <br> Children <br>(7)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Method <br> Used <br> (8)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Intention to <br> shift to other <br> FP method <br> (9)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Type <br> (10)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Status <br> (11)</b></p>
								</th>
								<th class="text-center">
									<p class="small"><b>Reason for<br> Intending to use FP <br> Method <br> (12)</b></p>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php for($i = 1; $i <= 10; $i++): ?>
								<tr>
									<td class="text-center" rowspan="2"><p class="small"><?= $i; ?></p></td>
									<td>
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "name_participant1[".$i."]",
				                                "padding-l10"
				                            );
				                        ?>
									</td>
									<td class="width-3">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "sex1[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td class="width-3">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "civil_status1[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td class="width-10">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "age1[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "address[".$i."]",
				                                "height-50 padding-l10"
				                            );
				                        ?>
									</td>
									<td class="width-5">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "educ1[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td rowspan="2" class="width-5">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "no_children[".$i."]",
				                                "height-50 text-center"
				                            );
				                        ?>
									</td>
									<td rowspan="2" class="width-5">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "method[".$i."]",
				                                "height-50 text-center"
				                            );
				                        ?>
									</td>
									<td rowspan="2" class="width-5">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "fp_method[".$i."]",
				                                "height-50 text-center"
				                            );
				                        ?>
									</td>
									<td rowspan="2" class="width-5">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "type[".$i."]",
				                                "height-50 text-center"
				                            );
				                        ?>
									</td>
									<td rowspan="2" class="width-5">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "status[".$i."]",
				                                "height-50 text-center"
				                            );
				                        ?>
									</td>
									<td rowspan="2" class="width-10">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "reason[".$i."]",
				                                "height-50 text-center"
				                            );
				                        ?>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "name_participant2[".$i."]",
				                                "padding-l10"
				                            );
				                        ?>
									</td>
									<td class="width-3">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "sex2[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td class="width-3">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "civil_status2[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td class="width-10">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "age2[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td class="width-5">
										<?php
				                            echo HtmlHelper::inputPdf(
				                                "text",
				                                "educ2[".$i."]",
				                                "text-center"
				                            );
				                        ?>
									</td>
									<td></td>
								</tr>
							<?php endfor; ?>						
						</tbody>
					</table>
				</div>
			</div>
			<div>
				<p class="small text-center">NOTE: Please use CODE NUMBER below for Civil Status, Educational Attainment and Method Used</p>
				<div class="table-responsive">	
					<table class="table table-bordered margin-b0">
						<thead>
							<tr>
								<th class="text-center" rowspan="2">
									<p class="small"><b>Civil Status</b> <br> (Column 3)</p>
								</th>
								<th class="text-center" colspan="2" rowspan="2">
									<p class="small"><b>Highest Educational Attainment</b> <br> (Column 6)</p>
								</th>
								<th class="text-center" colspan="4">
									<p class="small"><b>Modern FP Method Used</b> <br> (Columns 8 & 9)</p>
								</th>
								<th class="text-center" rowspan="2">
									<p class="small"><b>Reason for Using FP / <br> Intending to Use </b> <br> (Column 12)</p>
								</th>
								<th class="text-center" rowspan="2" colspan="2">
									<p class="small"><b>Traditional FP User: TYPE </b> <br> (Column 10)</p>
								</th>
								<th class="text-center" rowspan="2">
									<p class="small"><b>Non-Modern FP User: STATUS </b><br> (Column 11)</p>
								</th>
							</tr>
							<tr>
								<th class="text-center" colspan="2" ><p class="small"><b>Artificial Method:</b></p></th>
								<th class="text-center" colspan="2" ><p class="small"><b>Modern NFP Methods:</b></p></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="padding-l15">
									<p class="small">
										1 - Married <br>
										2 - Single <br>
										3 - Widow/Widower <br>
										4 - Separated <br>
										5 - Live-in
									</p>								
								</td>
								<td class="padding-l5 border-r0">
									<p class="small">
										1 - No Education  <br>
										2 - Elemantary Level <br>
										3 - Elementary Graduate <br>
										4 - High School Level <br>
										5 - High School Graduate 
									</p>
								</td>
								<td class="border-l0">
									<p class="small">
										6 - Vocational <br>
										7 - College Level <br>
										8 - College Graduate <br>
										9 - Post Graduate
									</p>
								</td>
								<td class="padding-l5 border-r0">
									<p class="small">
										1 - Condom  <br>
										2 - IUD <br>
										3 - Pills <br>
										4 - Injectable
									</p>
								</td>
								<td class="border-l0">
									<p class="small">
										5 - Vasectomy <br>
										6 - Tubal Ligation <br>
										7 - Implant
									</p>
								</td>
								<td class="padding-l5 border-r0">
									<p class="small">
										8 - CMM / Billings  <br>
										9 - BBT <br>
										10 - Sympto-Thermal
									</p>
								</td>
								<td class="border-l0">
									<p class="small">
										11 - SDM <br>
										12 - LAM
									</p>
								</td>

								<td class="padding-l5">
									<p class="small">
										1 - Spacing <br>
										2 - Limiting <br>
										3 - Achieving
									</p>
								</td>
								<td class="padding-l5 border-r0">
									<p class="small">
										1 - Withdrawal <br>
										2 - Rhythm <br>
										3 - Calendar <br>
										4 - Abstinence
									</p>
								</td>
								<td class="border-l0">
									<p class="small">
										5 - Herbal <br>
										6 - No Method
									</p>
								</td>
								<td class="padding-l5">
									<p class="small">
										A - Espressing Intention to Use Modern FP <br> Method (indicate CODE for Modern FP Methods <br> use col. 8) <br>
										B - Undecided <br>
										C - Currently Pregnant <br>
										D - No Intention to Use
									</p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="flex">
					<p class="small padding-l10p">Prepared by:</p>
					<p class="small padding-l30p">Reviewed by:</p>
					<p class="small padding-l28p">Approved by:</p>
				</div>
				<div class="padding-t3p flex">
					<p class="small padding-l15p" class="padding-left: 15%">Name/Signature of RPM Team Member/s</p>
					<p class="small padding-l20p" class="padding-left: 20%">Name & Signature</p>
					<p class="small padding-l25p" class="padding-left: 25%">Name & Signature of Provincial/City Population Officer</p>
				</div>
			</div>
		</form>
	</div>
</div>