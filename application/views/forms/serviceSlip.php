<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
?>

<?php if($is_pdf){ ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<?php } else { ?>
<style>
	.table-bordered > tbody > tr > td,
	.table-bordered > thead > tr > th,
	.table-bordered {
		border: 1px solid #000;
	}

</style>
<?php } ?>

<style>
	.small {
		font-size: 15px;
	}
</style>
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<div class="body-padding">
	<div class="col-md-offset-2 col-md-8">
		<div class="row border-2">
			<form id="form_validation" class="form-horizontal">
				<?php if(!$is_pdf) : ?>
					<div id="mybutton">					
			            <input type="submit" class="save saveServiceSlip" value="SAVE" name="saveform1" />
			        </div>
				<?php endif; ?>
				<div class="col-md-12">
					<div class="col-md-6 padding-r3p text-left">
						<p class="small"><b>SERVICE SLIP</b></p>
					</div>
					<div class="col-md-6 padding-r3p text-right">
						<p class="small">
							<b>
								Date of visit: 
								<?php
		                            echo HtmlHelper::inputPdf(
		                                $is_pdf,
		                                "",
		                                "date",
		                                "date_of_visit",
		                                "padding-l10 underline width-45",
		                                ""
		                            );
		                        ?>
							</b>
						</p>
					</div>
				</div>
				<div class="col-md-12 padding-r3p padding-b10">
					<div class="col-md-12">
						<p class="small">
							(NOTE: Please return this to the Couples or to the Community Volunteer)
						</p>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-4 padding-r3p">
						<p class="small">
							Name of the Client:
						</p>
					</div>
					<div class="col-md-8">
						<?php
	                        echo HtmlHelper::inputPdf(
	                            $is_pdf,
	                            "",
	                            "text",
	                            "client_name",
	                            "padding-l10 underline",
	                            ""
	                        );
	                    ?>
					</div>
				</div>
				<div class="col-md-12 padding-b15">
					<div class="col-md-4">
						<p class="small">
							Address of the Client:
						</p>
					</div>
					<div class="col-md-8">
						<?php
	                        echo HtmlHelper::inputPdf(
	                            $is_pdf,
	                            "",
	                            "text",
	                            "client_address",
	                            "padding-l10 underline",
	                            ""
	                        );
	                    ?>
					</div>
				</div>
				<div class="col-md-12 padding-r3p text-center border-t1">
					<p class="small">
						<b>
							Note: THIS PORTION IS FOR SERVICE PROVIDER
						</b>
					</p>
				</div>
				<div class="col-md-12 padding-r3p border-t1">
					<p class="small-12">
						Please check Family Planning services provided to the client:
					</p>
					<p class="small">
						<b>
							1. FP Method
						</b>
					</p>
				</div>
				<div class="col-md-12 padding-0 table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="text-center">NFP Method</th>
								<th class="text-center">Check</th>
								<th class="text-center">Artificial Method</th>
								<th class="text-center">Check</th>
								<th class="text-center">Permanent Method</th>
								<th class="text-center">Check</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>SDM</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="sdm" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td>Pills</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="pills" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td>Ligation</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="ligation" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td>LAM</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="lam" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td>IUD</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="iud" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td>Vasectomy</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="vasectomy" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
							</tr>
							<tr>
								<td>CMM</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="cmm" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td>Injectable</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="injectable" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>STM</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="stm" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td>Condom</td>
								<td class="padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="condom" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>Implant</td>
								<td class="text-center padding-0 back-eee">
									<?php if (!$is_pdf) : ?>
										<label class="cont">
											<input type="radio" name="fp_method" value="implant" />
											<span class="checkmark"></span>
										</label>
									<?php endif; ?>
								</td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 padding-r3p border-b1">
					<p class="small">
						<b>
							2. Counseling
						</b>
					</p>
				</div>
				<div class="col-md-12 padding-r3p border-b1">
					<p class="small">
						<b>
							3. Other concerns:
						</b>
					</p>
					<p class="small">
						<b>
							Client not provided FP service because of the following reason/s:
						</b>
					</p>
				</div>
				<div class="col-md-12 padding-r3p">
					<ol>
						<li>
							1. Needed FP method is not available in the facility
						</li>
						<li>
							2. No sevice provider available during the visit
						</li>
						<li>
							3. No trained personnel to do the needed FP service
						</li>
						<li>
							4. Client is not qualified to use preferred method, <br>
							counseled to use ____________________ but client is undecided
						</li>
						<li>
							5. Other reasons, please specify: ____________________
						</li>
					</ol>
				</div>
			</form>
		</div>
	</div>
</div>