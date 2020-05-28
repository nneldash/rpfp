<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');

$form1 = FormClass::getFromVariable($form1);
$rpfpId = (!empty($this->input->get('rpfpId')) ? $this->input->get('rpfpId') : 0);
$status = $this->input->get('status');
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
	<link href="<?= base_url('NewAssets/FontAwesome'); ?>" rel="stylesheet">
	<link href="<?= base_url('NewAssets/bootstrapSelectCss'); ?>" rel="stylesheet">	
	<link href="<?= base_url('NewAssets/theme') ?>" rel="stylesheet">
	<style>
		.table >tbody > .approveCheck > td,
		.table >tbody > .secondRow > td {
			padding-bottom: 0;
			padding: 2px;
			vertical-align: inherit;
		}

		.table-bordered > tbody > tr > td,
		.table-bordered > thead > tr > th,
		.table-bordered {
			border: 1px solid #000;
		}
		a {
			text-decoration: none;
			display: inline-block;
			padding: 8px 16px;
		}
		a:hover {
			background-color: #ddd;
			color: black;
		}
		input, textarea {
			border-bottom: 1px solid #a7bfc1;
		}
	</style>
<?php } ?>

<?= !empty($new_form) ? '<div class="hidden" id="new_form"></div>' : BLANK ?>
<?= !empty($edit_existing) ? '<div class="hidden" id="edit_existing"></div>' : BLANK ?>
<div class="loading" id="loading-wrapper" >
	<div id="loading-text" role="status"></div>
</div>
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">
<input type="hidden" id="rdm" name="rdm" value="<?= $isRegionalDataManager; ?>" />
<input type="hidden" id="focal" name="focal" value="<?= $isFocalPerson; ?>" />
<div class="container-fluid text-center">
	<a href="#" class="previous">&laquo; Previous</a>
	<a href="#" class="next">Next &raquo;</a>
	<div id="pager">Page 1 of 1</div>
</div>
<div class="body-padding">
	<div class="border-2">
		<div class="row">
			<div class="col-md-12 padding-r3p text-right">
				<p class="small">RPFP FORM 1</p>
			</div>
		</div>
		<div class="border-t1 block small padding-l5 padding-r30">
			<b>DISCLAIMER:</b>
			We hereby certify that we have read and understood the Notice on Privacy's and Disclosure written on the dorsal part 
			of this Responsible Parenthood and Family Planning (RPFP) Form and by signing and submitting this, we hereby grant the 
			Commission on Population (POPCOM), or any of its authorized agents and partners, the authority to collect, obtain, store 
			and process the personal information that we provide below for the purpose/s of
			<?php
                echo HtmlHelper::inputPdf(
                    $is_pdf,
                    "",
                    "text",
                    "purpose",
                    "padding-l10 underline width-10 text-left",
					"",
					"",
					""
                );
            ?>
	        <a class="accordionDropdown" data-toggle="collapse" data-parent="#accordion" href="#rpfpClass">
	        	Hide/Show RPFP Class
	        </a>
		</div>
		<form id="form_validation" class="form-horizontal">
			<input type="hidden" id="num_items" name="num_items" value="1" />
			<?php if(!$is_pdf) : ?>
		        <div id="leftButton">
		        	<div class="dropdown save">
						<button class="dropdown-toggle" type="button" data-toggle="dropdown">
							Menu
							<span class="caret"></span>
							</button>
						<ul class="dropdown-menu">
							<li><a href="<?= base_url('Forms/new')?>" id="new_form_1" >New Form 1</a></li>
							<?php if($isEncoder): ?>
								<li><a class="btn-import" id="import_excel">Import Excel</a></li>
							<?php endif; ?>
							<li><a href="<?= base_url('menu')?>" id="main_menu">Back</a></li>
							<li><a href="<?= base_url('login/logoffUser')?>" id="log_off">Logout</a></li>
						</ul>
					</div>
	
				</div>
				<?php if ($status == 2): ?>
					<div id="rightButton" style="text-transform: none; ">					
						<input type="submit" class="save saveForm1" value="" name="saveform1" />
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<input type="hidden" name="class_id" value="<?= $rpfpId; ?>" />
	        <br>
			<div id="rpfpClass" class="collapse <?= $rpfpId == '' ? 'in' : '' ?>">
				<div class="border-t1 table-responsive">
					<div style="padding-top: 10px"></div>
					<table style="float: left" class="table">
						<tr>
							<td class="border-1 padding-0 back-eee" style="border-left: none">
								<?php if (!$is_pdf) : ?>
									<label class="cont border-t1">
										<input id="4ps" type="radio" required name="type_of_class" value="1" 
											<?= $form1->Seminar->TypeOfClass->Type == '4Ps' ? 'checked' : '' ?>
										/>
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td class="padding-r20p border-0">
								<span class="small"><b>&nbsp;&nbsp;4Ps</b></span>
							</td>

							<td class="border-1 padding-0 back-eee" style="border: 1px solid">
								<?php if (!$is_pdf) : ?>
									<label class="cont">
										<input id="house" type="radio" name="type_of_class" value="5" 
											<?= $form1->Seminar->TypeOfClass->Type == 'House-to-House' ? 'checked' : '' ?>
										/>
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td class="padding-r20p border-0">
								<span class="small"><b>&nbsp;&nbsp;House-to-House</b></span>
							</td>

							<td class="padding-r8p border-0">
								<span class="required">*</span>
								<span class="small">Class No.:</span>
							</td>
							<td class="padding-r15p border-0">
								<span class="small">
									<?php
			                            echo HtmlHelper::inputPdf(
			                                $is_pdf,
			                                $form1->Seminar->ClassNumber,
			                                "text",
			                                "class_no",
			                                "padding-l10 underline width-70",
			                                "",
			                                "required",
											""
			                            );
			                        ?>
		                        </span>
							</td>
						</tr>
						<tr>
							<td class="border-1 width-30 padding-0 back-eee" style="border-left: none!important;">
								<?php if (!$is_pdf) : ?>
									<label class="cont border-t1">
										<input id="faith" type="radio" name="type_of_class" value="2" 
											<?= $form1->Seminar->TypeOfClass->Type == 'Faith-Based Organization' ? 'checked' : '' ?> 
										/>
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
										<input id="profile" type="radio" name="type_of_class" value="6" 
											<?= $form1->Seminar->TypeOfClass->Type == 'Profile only' ? 'checked' : '' ?>
										/>
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td class="border-0">
								<span class="small"><b>&nbsp;&nbsp;Profile only</b></span>
							</td>

							<td class="border-0">
								<span class="required">*</span>
								<span class="small">Prov/City/Mun.:</span>
							</td>
							<td class="border-0 dropdownLoc">
								<span class="small">
									<select class="selectpicker" id="provinceList" data-live-search="true" title="Province">
										
									</select>
									<input type="hidden" readonly name="province" class="provinceList" value="<?=$form1->Seminar->Location->Province->Code != 'N/A' ? $form1->Seminar->Location->Province->Code : ''; ?>" required>
			                    	<select class="selectpicker" id="muniList" data-live-search="true" title="City/Municipality">
										
									</select>
									<input type="hidden" required readonly name="city" class="muniList" value="<?=$form1->Seminar->Location->City->Code != 'N/A' ? $form1->Seminar->Location->City->Code : ''; ?>">
			                    </span>
							</td> 
						</tr>
						<tr>
							<td class="border-1 width-30 padding-0 back-eee" style="border-left: none">
								<?php if (!$is_pdf) : ?>
									<label class="cont border-t1">
										<input id="pmc" type="radio" name="type_of_class" value="3" 
											<?= $form1->Seminar->TypeOfClass->Type == 'PMC' ? 'checked' : '' ?>
										/>
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
										<input id="others" type="radio" name="type_of_class" value="7" 
											<?= $form1->Seminar->TypeOfClass->Type == 'Others' ? 'checked' : '' ?>
										/>
										<span class="checkmark"></span>
									</label>
								<?php endif; ?>
							</td>
							<td class="border-0">
								<span class="small"><b>&nbsp;&nbsp;Others, please specify </b>
									<?php
			                            echo HtmlHelper::inputPdf(
			                                $is_pdf,
			                                isset($form1->Seminar->TypeOfClass->Others) ? $form1->Seminar->TypeOfClass->Others : '',
			                                "text",
			                                "others",
			                                "padding-l10 underline width-20 disabled-others",
											"",
											"",
											""
			                            );
			                        ?>
			                    </span>
							</td>

							<td class="border-0">
								<span class="required">*</span>
								<span class="small">Barangay:</span>
							</td>
							<td class="border-0 dropdownLoc">
								<span class="small">
									<select class="selectpicker" id="brgyList" data-size="3" data-live-search="true" title="Barangay">
										
									</select>
									<input type="hidden" class="brgyList" readonly name="barangay" value="<?=$form1->Seminar->Location->Barangay->Code != 'N/A' ? $form1->Seminar->Location->Barangay->Code : ''; ?>" required>
			                    </span>
							</td>
						</tr>
						<tr>
							<td class="border-1 width-30 padding-0 back-eee" style="border-left: none">
								<?php if (!$is_pdf) : ?>
									<label class="cont border-t1">
										<input id="usapan" type="radio" name="type_of_class" value="4" 
											<?= $form1->Seminar->TypeOfClass->Type == 'Usapan' ? 'checked' : '' ?>
										/>
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
								<span class="required">*</span>
								<span class="small">Date Conducted:</span>
							</td>
							<td class="border-0">
								<span class="small">
									<?php $date_con = strtotime($form1->Seminar->DateConducted)?>
									<input type="text" name="date_conducted" value="<?= ($form1->Seminar->DateConducted != 'N/A' ? date('m/d/Y', $date_con) : ''); ?>" class="padding-l10 underline width-70 date_con" placeholder="MM/DD/YYYY" required readonly />
			                    </span>
							</td>							
						</tr>
					</table>
				</div>
			</div>

			<div class="padding-t20" style="page-break-inside: avoid" id="paged_form">
				<div class="table-responsive" style="overflow: hidden;">	
					<table class="table table-bordered margin-b0 formTable">
						<thead>
							<tr>
								<?php if (!$is_pdf): ?>
									<?php if ($isRegionalDataManager || $isFocalPerson && $status == 2): ?>
										<th rowspan="2" class="text-center">
											<label class="cont back-eee checkApprove" style="height: 37px;">
												<input type="checkbox" name="approve_all" id="checkAll" />
												<span class="checkmark"></span>
											</label>
										</th>
									<?php endif; ?>
								<?php endif; ?>
								<th rowspan="2" style="border-left: none; width: 2%;"></th>
								<th rowspan="2" class="text-center padding-0" style="width: 30%">
									<p class="small">
										<b>
											Name of Participants/Couple (Husband & 
											Wife) <br>PLEASE WRITE IN BOLD LETTERS <br>
											(First Name, Middle Initial, Last Name, Extension Name)<br> (1)
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
								<th rowspan="2" class="text-center" style="border-right: none; width: 4%; padding: 2px;">
									<p class="small">
										<b>Participant's <br>Signature</b>
									</p>
									<p class="small"><b>(13)</b></p>
								</th>
								<?php if(!$is_pdf): ?>
									<?php if($isEncoder): ?>
										<th rowspan="2" class="text-center" style="border-right: none">
											<p class="small">
												<b>Service Slip</b>
											</p>
										</th>
									<?php endif; ?>
								<?php endif; ?>
							</tr>
							<tr>
								<th class="text-center" style="width: 2%">
									<p class="small">
										<b>Sex <br> (M/F) <br> (2)</b>
									</p>
								</th>
								<th class="text-center" style="width: 2%">
									<p class="small">
										<b>Civil <br>Status <br> (3)</b>
									</p>
								</th>
								<th class="text-center" style="width: 15%">
									<p class="small">
										<b>Birthdate / Age <br> (MM-DD-YYYY) <br>(4)</b>
									</p>
								</th>
								<th class="text-center" style="width: 28%">
									<p class="small">
										<b>Address / Household ID Number<br>(5)</b>
									</p>
								</th>
								<th class="text-center" style="width: 2%">
									<p class="small">
										<b>
											Highest <br> 
											Educational <br> 
											Attainment <br>
											(6)
										</b>
									</p>
								</th>
								<th class="text-center" style="width: 2%">
									<p class="small">
										<b>
											No. of <br> 
											Children <br>
											(7)
										</b>
									</p>
								</th>
								<th class="text-center" style="width: 2%">
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
								<th class="text-center" style="width: 2%">
									<p class="small">
										<b>Type <br> (10)</b>
									</p>
								</th>
								<th class="text-center" style="width: 2%">
									<p class="small">
										<b>Status <br> (11)</b>
									</p>
								</th>
								<th class="text-center" style="width: 2%">
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
							<?php
								$ListCouples = $form1->ListCouple;
								$max = count($ListCouples);
								$i = 0;

								if($max < 10) {
									$max = 10;
								}

								for ($i = 0; $i < $max; $i++) { 

									$dummy = new CoupleClass();
									$couple = (empty($form1->ListCouple[$i]) ? $dummy : $form1->ListCouple[$i]);

									$bday = 'N/A';
									$bday2 = 'N/A';

									if ($couple->FirstEntry->Birthdate != 'N/A') {
										$bday = explode('-', $couple->FirstEntry->Birthdate);
										$bday = $bday[1].'-'.$bday[2].'-'.$bday[0];
									}

									if ($couple->SecondEntry->Birthdate != 'N/A') {
										$bday2 = explode('-', $couple->SecondEntry->Birthdate);
										$bday2 = $bday2[1].'-'.$bday2[2].'-'.$bday2[0];
									}
							?>
								<tr class="approveCheck tr1<?= $i?> <?= $couple->Id != 'N/A' ? $couple->IsActive != 'N/A' ? ' ' : 'isApprove' : '' ?>">
									<?php if (!$is_pdf): ?>
										<?php 
											$status = $this->input->get('status');
											if($isRegionalDataManager || $isFocalPerson && $status == 2): 
										?>
											<td rowspan="2" class="back-eee padding-0">
												<label class="cont">
													<input class="check" type="checkbox" <?= $couple->Id != 'N/A' ? $couple->IsActive != 'N/A' ? ' ' : 'checked' : '' ?> 
													name="approveCouple[<?= $i ?>]" value="" <?= $couple->Id != 'N/A' ? $couple->IsActive != 'N/A' ? ' ' : 'disabled' : '' ?>  > 
													<span class="checkmark"></span>
												</label>
											</td> 
										<?php endif; ?>
									<?php endif; ?>
									<td class="text-center criteria" style="border-left: none" rowspan="2">
										<input type="text" class="isSlipSave"  hidden />
										<p class="small"><?= $i + 1; ?></p>
										<div class="labelDiv">
											
										</div>
										<input type="hidden" class="fp_served<?= $i; ?>" value="<?= $couple->FpServed; ?>" />
									</td>
									
									<td class="small highlight-this">
										<div style="display: inline-flex; border: 1px solid transparent;">
											<input type="hidden" id="isDuplicate1[<?= $i; ?>]" name="isDuplicate1[<?= $i; ?>]" value="" />
											<input type="hidden" class="loopIndex1" value="<?= $i; ?>" />
											<?php
					                            echo HtmlHelper::inputPdf(
					                                $is_pdf,
					                                ($couple->Id != 'N/A' ? $couple->Id : ''),
					                                "hidden",
					                                "couple_id[".$i."]",
					                                "padding-l3 dupHighlight",
													"",
													"",
													""
					                            );
					                        ?>
											<?php
					                            echo HtmlHelper::inputPdf(
					                                $is_pdf,
					                                HtmlHelper::firstEntry_Id($couple->FirstEntry->Id, $couple->SecondEntry->Id),
					                                "hidden",
					                                "individual_id1[".$i."]",
					                                "padding-l3 dupHighlight",
													"",
													"",
													""
					                            );
					                        ?>
					                        <span class="required" hidden>*</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::firstEntry_FirstName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "textarea",
					                                "firstname1[".$i."]",
					                                "padding-l3 fname1 require-this",
					                                "FIRST",
					                                ""
					                            );
					                        ?>
					                        <span style="padding-top:25px">,</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::firstEntry_MiddleName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "textarea",
					                                "middlename1[".$i."]",
					                                "padding-l3",
					                                "MIDDLE",
					                                ""
					                            );
					                        ?>
					                        <span style="padding-top:25px">,</span>
					                        <span class="required" hidden>*</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::firstEntry_LastName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "textarea",
					                                "lastname1[".$i."]",
					                                "padding-l3 lname1 require-this",
					                                "LAST",
					                                ""
					                            );
					                        ?>
					                        <span style="padding-top:25px">,</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::firstEntry_ExtName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "text",
					                                "extname1[".$i."]",
					                                "padding-l3 text-center max-width10 width-35 extname1",
					                                "EXT",
					                                ""
					                            );
					                        ?>
					                    </div>
									</td>
									<td class="small-20 highlight-this">
										<span class="required" hidden>*</span>
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                                HtmlHelper::firstEntry_Sex($couple->FirstEntry->Sex, $couple->SecondEntry->Sex),
				                                "text",
				                                "sex1[".$i."]",
				                                "text-center gender1 dupHighlight require-this",
												"1",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 highlight-this">
										<span class="required" hidden>*</span>
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	HtmlHelper::firstEntry_Civil($couple->FirstEntry->CivilStatus, $couple->SecondEntry->CivilStatus),
				                                "text",
				                                "civil_status1[".$i."]",
				                                "text-center civil1 require-this",
												"1",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 highlight-this">
										<div style="display: inline-flex; border: 1px solid transparent;">
											<span class="required" hidden>*</span>
											<br><br>
					                        <?php
					                            echo HtmlHelper::inputMaskPdf(
					                            	$is_pdf,
					                            	HtmlHelper::firstEntry_Birthday($bday, $bday2),
					                                "text",
					                                "bday1[".$i."]",
					                                "text-center birthAge bday1 dupHighlight require-this",
					                                "'mask': '99-99-9999'",
					                                ""
					                            );
					                        ?>
					                        <span style="padding-top: 15px">/</span>
					                        <input type="text" name="age1[<?=$i?>]" maxlength="2" class="text-center getAge1" style="width: 50%;" readonly value="<?= HtmlHelper::firstEntry_BirthAge($couple->FirstEntry->Age, $couple->SecondEntry->Age) ?>" />

					                        <div class="duplicateBtn" hidden>
						                        <button data-placement="right" data-toggle="popover<?= $i; ?>" data-container="body" data-placement="left" data-html="true">
						                        	<i class="fa fa-exclamation-circle dupIcon" style="color: #e2919f;"></i>
						                        </button>					                        	
					                        </div>
										</div>								
									</td>
									<td class="small text-center" rowspan="2">										
				                        <?php
				                        	echo HtmlHelper::inputName(
				                            	$is_pdf,
				                            	($couple->Address_St != 'N/A' ? $couple->Address_St : ''),
				                                "text",
				                                "house_no_st[".$i."]",
				                                "padding-l10 add_st",
				                                "House No. & Street",
				                                ""
				                            );
				                        ?>
				                        <?php
				                        	echo HtmlHelper::inputName(
				                            	$is_pdf,
				                            	($couple->Address_Brgy != 'N/A' ? $couple->Address_Brgy : ''),
				                                "text",
				                                "brgy[".$i."]",
				                                "padding-l10 add_brgy",
				                                "Brgy",
				                                ""
				                            );
				                        ?>
				                        <?php
				                        	echo HtmlHelper::inputName(
				                            	$is_pdf,
				                            	($couple->Address_City != 'N/A' ? $couple->Address_City : ''),
				                                "text",
				                                "city[".$i."]",
				                                "padding-l10 add_city",
				                                "City / Municipality",
				                                ""
				                            );
				                        ?>
				                        <?php
				                        	echo HtmlHelper::inputName(
				                            	$is_pdf,
				                            	($couple->Address_HH_No != 'N/A' ? $couple->Address_HH_No : ''),
				                                "text",
				                                "household_id[".$i."]",
				                                "padding-l10 hh_no",
				                                "Household ID No.",
				                                ""
				                            );
				                        ?>
									</td>
									<td class="small-20 text-center">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	HtmlHelper::firstEntry_Education($couple->FirstEntry->HighestEducation, $couple->SecondEntry->HighestEducation),
				                                "text",
				                                "educ1[".$i."]",
				                                "text-center education1",
												"1",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	($couple->NumberOfChildren != 'N/A' ? $couple->NumberOfChildren : ''),
				                                "text",
				                                "no_of_children[".$i."]",
				                                "height-50 text-center noChildren",
												"2",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 text-center" rowspan="2">
										<input type="hidden" name="fp_id[<?=$i?>]" value="<?= ($couple->ModernFp->Id != 'N/A' ? $couple->ModernFp->Id : 0) ?>">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	($couple->ModernFp->MethodUsed != 'N/A' ? $couple->ModernFp->MethodUsed : ''),
				                                "text",
				                                "method[".$i."]",
				                                "height-50 text-center method8",
												"2",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	($couple->ModernFp->IntentionToShift != 'N/A' ? $couple->ModernFp->IntentionToShift : ''),
				                                "text",
				                                "fp_method[".$i."]",
				                                "height-50 text-center method9",
												"2",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	($couple->TraditionalFp->Type != 'N/A' ? $couple->TraditionalFp->Type : ''),
				                                "text",
				                                "type[".$i."]",
				                                "height-50 text-center typeFp",
												"1",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20" rowspan="2">
										<?php
											if ($couple->TraditionalFp->Status == 1) {
												$TraditionalFp_Status = 'A';
											} elseif ($couple->TraditionalFp->Status == 2) {
												$TraditionalFp_Status = 'B';
											} elseif ($couple->TraditionalFp->Status == 3) {
												$TraditionalFp_Status = 'C';
											} elseif ($couple->TraditionalFp->Status == 4) {
												$TraditionalFp_Status = 'D';
											} else {
												$TraditionalFp_Status = $couple->TraditionalFp->Status;
											}
										?>
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	($couple->TraditionalFp->Status != 'N/A' ? $TraditionalFp_Status : ''),
				                                "text",
				                                "status[".$i."]",
				                                "height-50 text-center status-trad",
												"1",
												"",
												""
											);
				                        ?>
				                        <div style="display: inline-flex">
					                        <span style="color: red" class="intention-required" hidden>*</span>
					                        <input type="text" disabled value="<?= ($couple->TraditionalFp->IntentionUse != 'N/A' ? $couple->TraditionalFp->IntentionUse : ''); ?>" class="height-50 text-center intention-use" maxlength="2" name="intention_use[<?= $i; ?>]" />
				                        </div>
									</td>
									<td class="small-20 text-center" rowspan="2">
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	($couple->TraditionalFp->ReasonForUse != 'N/A' ? $couple->TraditionalFp->ReasonForUse : ''),
				                                "text",
				                                "reason[".$i."]",
				                                "height-50 text-center reasonFp",
												"1",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small <?php if (!$is_pdf): ?> back-eee <?php endif;?>" style="border-right: none; padding: 0">
										<?php if (!$is_pdf) : ?>
											<label class="cont">
												<input type="checkbox" class="attended<?= $i; ?> attendeed1[<?= $i ?>]" name="attendee1[<?= $i ?>]" value="<?= ($couple->FirstEntry->Attendee == 1 ? 'attended' : '') ?>" />
												<span class="checkmark height-34"></span>
											</label>
										<?php endif; ?>
									</td>
									<?php if(!$is_pdf): ?>
										<?php if($isEncoder): ?>
											<td class="small text-center" rowspan="2">
												<input type="hidden" class="slipIndex" name="slipIndex" value="<?= $i; ?>">
												<button class="btn-slip" data-couple="<?= $couple->Id; ?>" data-couple-name="<?= HtmlHelper::firstEntry_Name($couple->FirstEntry->Name, $couple->SecondEntry->Name); ?>" data-address="<?= $couple->Address_St; ?>" data-toggle="tooltip" data-placement="left" title="View Service Slip">
													<i class="fa fa-file"></i>
												</button>
											</td>
										<?php endif; ?>
									<?php endif; ?>
								</tr>
								<tr class="secondRow tr2<?= $i; ?> <?= $couple->Id != 'N/A' ? $couple->IsActive != 'N/A' ? ' ' : 'isApprove' : '' ?>">
									<td class="small highlight-this">
										<div style="display: inline-flex; border: 1px solid transparent;">
											<input type="hidden" id="isDuplicate2[<?= $i; ?>]" name="isDuplicate2[<?= $i; ?>]" value="" />
											<input type="hidden" class="loopIndex2" value="<?= $i;?>" />
											<?php
					                            echo HtmlHelper::inputPdf(
					                            	$is_pdf,
					                                HtmlHelper::secondEntry_Id($couple->FirstEntry->Id, $couple->SecondEntry->Id),
					                                "hidden",
					                                "individual_id2[".$i."]",
					                                "padding-l3",
													"",
													""
					                            );
					                        ?>
					                        <span class="required" hidden>*</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::secondEntry_FirstName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "textarea",
					                                "firstname2[".$i."]",
					                                "padding-l3 fname2 require-this",
					                                "FIRST",
					                                ""
					                            );
					                        ?>
					                        <span style="padding-top:25px">,</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::secondEntry_MiddleName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "textarea",
					                                "middlename2[".$i."]",
					                                "padding-l3",
					                                "MIDDLE",
					                                ""
					                            );
					                        ?>
					                        <span style="padding-top:25px">,</span>
					                        <span class="required" hidden>*</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::secondEntry_LastName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "textarea",
					                                "lastname2[".$i."]",
					                                "padding-l3 lname2 require-this",
					                                "LAST",
					                                ""
					                            );
					                        ?>
					                        <span style="padding-top:25px">,</span>
					                        <?php
					                        	echo HtmlHelper::inputName(
					                            	$is_pdf,
					                            	HtmlHelper::secondEntry_ExtName($couple->FirstEntry->Name, $couple->SecondEntry->Name),
					                                "text",
					                                "extname2[".$i."]",
					                                "padding-l3 text-center max-width10 width-35 extname2",
					                                "EXT",
					                                ""
					                            );
					                        ?>
					                    </div>
									</td>
									<td class="small-20 highlight-this">
										<span class="required" hidden>*</span>
										<input type="hidden" value="" class="getSex1" name="getSex1" />
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                                HtmlHelper::secondEntry_Sex($couple->FirstEntry->Sex, $couple->SecondEntry->Sex),
				                                "text",
				                                "sex2[".$i."]",
				                                "text-center gender2 require-this",
												"1",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 highlight-this">
										<span class="required" hidden>*</span>
										<?php
				                            echo HtmlHelper::inputPdf(
				                            	$is_pdf,
				                            	HtmlHelper::secondEntry_Civil($couple->FirstEntry->CivilStatus, $couple->SecondEntry->CivilStatus),
				                                "text",
				                                "civil_status2[".$i."]",
				                                "text-center civil2 require-this",
												"1",
												"",
												""
				                            );
				                        ?>
									</td>
									<td class="small-20 highlight-this">
										<div style="display: inline-flex; border: 1px solid transparent;">
											<span class="required" hidden>*</span>
											<br><br>
											<?php
				                            	echo HtmlHelper::inputMaskPdf(
					                            	$is_pdf,
					                            	HtmlHelper::secondEntry_Birthday($bday, $bday2),
					                                "text",
					                                "bday2[".$i."]",
					                                "text-center birthAge bday2 require-this",
					                                "'mask': '99-99-9999'",
					                                ""
					                            );
				                        	?>
				                        	<span style="padding-top: 15px">/</span>
				                        	<input type="text" name="age2[<?=$i?>]" maxlength="2" style="width: 50%;" class="text-center getAge2" readonly value="<?= HtmlHelper::secondEntry_BirthAge($couple->FirstEntry->Age, $couple->SecondEntry->Age) ?>" />
										</div>
									</td>
									<td class="small-20 text-center">
										<?php
			                            echo HtmlHelper::inputPdf(
			                            	$is_pdf,
			                            	HtmlHelper::secondEntry_Education($couple->FirstEntry->HighestEducation, $couple->SecondEntry->HighestEducation),
			                                "text",
			                                "educ2[".$i."]",
			                                "text-center education2",
											"1",
											"",
											""
			                            );
			                        ?>
									</td>
									<td class="small back-eee" style="border-right: none; padding: 0">
										<?php if (!$is_pdf) : ?>
											<label class="cont">
												<input type="checkbox" class="attended<?= $i; ?> attendeed2[<?= $i ?>]" name="attendee2[<?= $i ?>]" value="<?= ($couple->SecondEntry->Attendee == 1 ? 'attended' : '') ?>" />
												<span class="checkmark height-35" ></span>
											</label>
										<?php endif; ?>
									</td>
								</tr>
							<?php } ?>
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
										A - Expressing Intention to Use Modern FP <br> 
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
							<input type="text" class="text-center" style="border-bottom: 1px solid black; width: 75%" name="prepared_by" />
						</td>
						<td class="border-0">
							<input type="text" class="text-center" style="border-bottom: 1px solid black; width: 75%" name="reviewed_by" />
						</td>
						<td class="border-0">
							<input type="text" class="text-center" style="border-bottom: 1px solid black; width: 75%" name="approved_by" />
						</td>
						<td class="border-0"></td>
					</tr>
					<tr>
						<td class="border-0 padding-l20"></td>
						<td class="border-0 padding-l20">
							<p style="width: 75%" class="text-center small">Name/Signature of RPM Team Member/s</p>
						</td>
						<td class="border-0 padding-l60">
							<p style="width: 75%" class="text-center small">Name & Signature</p>
						</td>
						<td class="border-0">
							<p style="width: 75%" class="text-center small">Name & Signature of Provincial/City Population Officer</p>
						</td>
						<td class="border-0"></td>
					</tr>
				</table>
			</div>
		</form>
	</div>
</div>

<?php if(!$is_pdf) : ?>
	<script>
		loadJs(base_url + 'NewAssets/inputMaskJs', function() {
			loadJs(base_url + 'assets/js/form.js');
		});
		loadJs(base_url + 'NewAssets/jqueryMaskJs');
		loadJs(base_url + 'NewAssets/inputExtJs');
		loadJs(base_url + 'NewAssets/bootstrapSelectJs');
		loadJs(base_url + 'NewAssets/jQueryUi');
	</script>
<?php endif; ?>