<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');

$slip = ServiceSlipClass::getServiceSlipFromVariable($slip);
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
					<input type="hidden" name="couple_id" value="<?= $couple_id; ?>">
					<p class="small"><b>SERVICE SLIP</b></p>
					<input type="hidden" name="slip_id" value="">
				</div>
				<div class="col-md-6 padding-r3p text-right">
					<p class="small">
						<b>
							Date of visit: 
							<input type="date" name="date_of_visit" value="<?= $slip->DateOfVisit; ?>" class="padding-l10 underline width-70"  />
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
						$couple_name,
						"text",
						"",
						"padding-l10 underline",
						"",
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
						$address,
						"text",
						"",
						"padding-l10 underline",
						"",
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
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::SDM ?>" <?= $slip->MethodUsed == '11' ? 'checked' : '' ?> required />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Pills</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::PILLS ?> <?= $slip->MethodUsed == '3' ? 'checked' : '' ?> " />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Ligation</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::TUBAL_LIGATION ?>" <?= $slip->MethodUsed == '6' ? 'checked' : '' ?> />
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
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::LAM ?>" <?= $slip->MethodUsed == '12' ? 'checked' : '' ?> />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>IUD</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::IUD ?>" <?= $slip->MethodUsed == '2' ? 'checked' : '' ?> />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Vasectomy</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::VASECTOMY ?>" <?= $slip->MethodUsed == '5' ? 'checked' : '' ?> />
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
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::CMM_BILLINGS ?>" <?= $slip->MethodUsed == '8' ? 'checked' : '' ?> />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Injectable</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::INJECTABLE ?>" <?= $slip->MethodUsed == '4' ? 'checked' : '' ?> />
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
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::SYMPTO_THERMAL ?>" <?= $slip->MethodUsed == '10' ? 'checked' : '' ?> />
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td>Condom</td>
							<td class="padding-0 back-eee">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::CONDOM ?>" <?= $slip->MethodUsed == '1' ? 'checked' : '' ?> />
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
										<input type="radio" name="method" class="fp_method" value="<?= ModernMethods::IMPLANT ?>" <?= $slip->MethodUsed == '7' ? 'checked' : '' ?> />
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
						<input type="radio" name="is_counseling" class="counseling" value="1" <?= $slip->IsCounseling == '1' ? 'checked' : '' ?> />
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
							<input type="radio" name="other_concern" class="other_concerns" value="1" <?= $slip->OtherConcern == '1' ? 'checked' : '' ?> />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<li class="flex">
						2. No sevice provider available during the visit
						<p> &nbsp; (</p>
						<label class="cont">
							<input type="radio" name="other_concern" class="other_concerns" value="2" <?= $slip->OtherConcern == '2' ? 'checked' : '' ?> />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<li class="flex">
						3. No trained personnel to do the needed FP service
						<p> &nbsp; (</p>
						<label class="cont">
							<input type="radio" name="other_concern" class="other_concerns" value="3" <?= $slip->OtherConcern == '3' ? 'checked' : '' ?> />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<li class="flex">
						4. Client is not qualified to use preferred method,
                    </li>
                    <li class="flex padding-l2p">
						counseled to use &nbsp;
						<select name="counseled_to_use" class="no4-select">
							<option></option>
							<option value="<?= ModernMethods::SDM ?>" <?= $slip->CounseledToUse == '11' ? 'selected' : '' ?> >SDM</option>
							<option value="<?= ModernMethods::LAM ?>" <?= $slip->CounseledToUse == '12' ? 'selected' : '' ?> >LAM</option>
							<option value="<?= ModernMethods::CMM_BILLINGS ?>" <?= $slip->CounseledToUse == '8' ? 'selected' : '' ?> >CMM</option>
							<option value="<?= ModernMethods::SYMPTO_THERMAL ?>" <?= $slip->CounseledToUse == '10' ? 'selected' : '' ?> >STM</option>
							<option value="<?= ModernMethods::PILLS ?>" <?= $slip->CounseledToUse == '3' ? 'selected' : '' ?> >Pills</option>
							<option value="<?= ModernMethods::IUD ?>" <?= $slip->CounseledToUse == '2' ? 'selected' : '' ?> >IUD</option>
							<option value="<?= ModernMethods::INJECTABLE ?>" <?= $slip->CounseledToUse == '4' ? 'selected' : '' ?> >Injectable</option>
							<option value="<?= ModernMethods::CONDOM ?>" <?= $slip->CounseledToUse == '1' ? 'selected' : '' ?> >Condom</option>
							<option value="<?= ModernMethods::IMPLANT ?>" <?= $slip->CounseledToUse == '7' ? 'selected' : '' ?> >Implant</option>
							<option value="<?= ModernMethods::TUBAL_LIGATION ?>" <?= $slip->CounseledToUse == '6' ? 'selected' : '' ?> >Ligation</option>
							<option value="<?= ModernMethods::VASECTOMY ?>" <?= $slip->CounseledToUse == '5' ? 'selected' : '' ?> >Vasectomy</option>
						</select>
                        &nbsp; &nbsp; but client is undecided
						<p> &nbsp; (</p>
						<label class="cont">
							<input class="no4-check" type="radio" name="other_concern" value="4" <?= $slip->OtherConcern == '4' ? 'checked' : '' ?> />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</li>
					<br>
					<li class="flex">
						5. Other reasons, please specify: 
							<p> &nbsp; (</p>
							<label class="cont">
								<input class="no5-check" type="radio" name="other_concern" value="5" <?= $slip->OtherConcern == '5' ? 'checked' : '' ?> />
								<span class="smolCheck back-eee"></span>
							</label>
							<p>)</p>
							<input class="padding-l10 underline width-45 no5-input" type="text" name="other_specify" value="<?= $slip->OtherSpecify != 'N/A' ? $slip->OtherSpecify : ''?>"/>
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
							<input type="radio" name="is_provided_service" class="provided_method" value="1" <?= $slip->IsProvided == '1' ? 'checked' : '' ?> />
							<span class="smolCheck back-eee"></span>
						</label>
						<p>)</p>
					</div>
					<div class="flex">
						<p class="small">
							Date of accepting the method: &nbsp;
						</p>
						<input type="date" name="date_of_method" value="<?= $slip->DateOfMethod; ?>" class="padding-l10 underline width-70" />
					</div>
					<div class="flex">
						<p class="small">
							2. Client is advised to go to: &nbsp;
						</p>
						<?php
	                        echo HtmlHelper::inputPdf(
	                            $is_pdf,
	                        	($slip->ClientAdvised != 'N/A' ? $slip->ClientAdvised : ''),
	                            "text",
	                            "client_advised",
	                            "padding-l10 underline width-20",
								"",
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
                        ($slip->ReferralFacility != 'N/A' ? $slip->ReferralFacility : ''),
                        "text",
                        "referral_facility",
						"padding-l10 underline width-35",
						"required",
						""
                    );
                ?>
			</div>
			<div class="col-md-12 padding-l7p text-center">
				<br><br>
				<?php
                    echo HtmlHelper::inputPdf(
                        $is_pdf,
                        ($slip->HealthServiceProvider != 'N/A' ? $slip->HealthServiceProvider : ''),
                        "text",
                        "health_service_provider",
						"padding-l10 underline width-70 text-center",
						"required",
                        ""
                    );
                ?>
				<p class="small text-center">Name, Position and Signature of attending Health Service Provider</p>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/serviceSlip.js')?>"></script>