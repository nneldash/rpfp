<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
?>

<div class="body-padding" style="padding-top: 0">
	<form id="service_slip" class="form-horizontal">
		<div class="row">
			<div class="col-md-12 text-right">
	            <input type="submit" class="save saveServiceSlip" value="SAVE" name="saveSlip" style="width: 15%; margin-bottom: 1%" />
	        </div>
		</div>
		<div class="row border-2">
			<div class="col-md-12">
				<div class="col-md-6 padding-r3p text-left">
					<p class="small"><b>SERVICE SLIP</b></p>
					<input type="hidden" name="slip_id">
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
										<input type="radio" name="method" value="sdm" />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Pills</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" value="pills" />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Ligation</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" value="ligation" />
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
										<input type="radio" name="method" value="lam" />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>IUD</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" value="iud" />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Vasectomy</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" value="vasectomy" />
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
										<input type="radio" name="method" value="cmm" />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Injectable</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" value="injectable" />
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
										<input type="radio" name="method" value="stm" />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Condom</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" value="condom" />
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
										<input type="radio" name="method" value="implant" />
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
			<div class="col-md-12 padding-r3p border-b1 flex">
				<p class="small">
					<b>
						2. Counseling 
					</b>
				</p>
				<p><b> &nbsp; (</b></p>
				<?php if (!$is_pdf) : ?>
					<label class="cont">
						<input type="radio" name="method" value="counseling" />
						<span class="smolCheck back-eee"></span>
					</label>
				<?php endif; ?>
				<p><b>)</b></p>
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
					<li class="flex">
						1. Needed FP method is not available in the facility
						<p> &nbsp; (</p>
						<label class="cont">
							<input type="radio" name="method" value="need fp method" />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<li class="flex">
						2. No sevice provider available during the visit
						<p> &nbsp; (</p>
						<label class="cont">
							<input type="radio" name="method" value="no service provider" />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<li class="flex">
						3. No trained personnel to do the needed FP service
						<p> &nbsp; (</p>
						<label class="cont">
							<input type="radio" name="method" value="need fp method" />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<li class="flex">
						4. Client is not qualified to use preferred method,
                    </li>
                    <li class="flex padding-l2p">
						counseled to use &nbsp;
						<?php
                            echo HtmlHelper::inputPdf(
                                $is_pdf,
                                "",
                                "text",
                                "counseled_to_use",
                                "padding-l10 underline width-20 no4-input",
                                ""
                            );
                        ?> 
                        &nbsp; &nbsp; but client is undecided
						<p> &nbsp; (</p>
						<label class="cont">
							<input class="no4-check" type="radio" name="method" value="need fp method" />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<br>
					<li class="flex">
						5. Other reasons, please specify: 
						<?php
                            echo HtmlHelper::inputPdf(
                                $is_pdf,
                                "",
                                "text",
                                "other_reason",
                                "padding-l10 underline width-45 no5-input",
                                ""
                            );
                        ?>
					</li>
				</ol>
			</div>
			<div class="col-md-12 flex">
				<div class="col-md-2">
					<p class="small">
						<b>ACTION NEEDED:</b>
					</p>
				</div>
				<div class="col-md-10">
					<div class="flex">
						<p class="small">
							1. Client has been provided a method
						</p>
						<p> &nbsp; (</p>
						<label class="cont">
							<input type="radio" name="action" value="client has method provided" />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</div>
					<div class="flex">
						<p class="small">
							Date of accepting the method: &nbsp;
						</p>
						<?php
	                        echo HtmlHelper::inputPdf(
	                            $is_pdf,
	                            "",
	                            "date",
	                            "date_of_method",
	                            "padding-l10 underline width-20",
	                            ""
	                        );
	                    ?>
					</div>
					<div class="flex">
						<p class="small">
							2. Client is advised to go to: &nbsp;
						</p>
						<?php
	                        echo HtmlHelper::inputPdf(
	                            $is_pdf,
	                            "",
	                            "text",
	                            "client_advised",
	                            "padding-l10 underline width-20",
	                            ""
	                        );
	                    ?>
					</div>
				</div>	
			</div>
			<div class="col-md-12 padding-l7p flex">
				<p class="small">Name & address of referral facility :</p>
				<?php
                    echo HtmlHelper::inputPdf(
                        $is_pdf,
                        "",
                        "text",
                        "referral_facility",
                        "padding-l10 underline width-35",
                        ""
                    );
                ?>
			</div>
			<div class="col-md-12 padding-l7p text-center">
				<br><br>
				<?php
                    echo HtmlHelper::inputPdf(
                        $is_pdf,
                        "",
                        "text",
                        "referral_facility",
                        "padding-l10 underline width-70 text-center",
                        ""
                    );
                ?>
				<p class="small text-center">Name, Position and Signature of attending Health Service Provider</p>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/serviceSlip.js')?>"></script>