<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');

$forma_list = ReportFormA::getFromVariable($form_A);
?>

<?php if ($is_pdf) { ?>
    <link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
    <style>
        .small {
            font-size: 12px!important;
        }
        .padding-b8 {
            padding-bottom: 0px;
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


<div class="body-padding" style="padding-top: 0%;">    
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
                    FOR THE PERIOD <span style="text-transform: uppercase;"><?= ($forma_list->Header != 0 ? date('F', $forma_list->From) . ' - ' : '' ) ?> <?= date('F, Y', $forma_list->To) ?> </span><br>
                    POPCOM <?= ($forma_list->RegionalOffice != '' ? 'Regional Office '. $forma_list->RegionalOffice : 'Central Office' ) ?> <br>
                    DEMAND GENERATION ACTIVITIES
                </b>
            </p>
        </div>
        
        <?php if (!$is_pdf) : ?>
            <div id="leftButton">
                <a href="<?= base_url('menu/formA') ?>" class="save">
                    <span>BACK</span>
                </a>
            </div>
            <div id="rightButton">
                <a href="<?= base_url('forms/viewforma?RegionalOffice=' . $this->input->get('RegionalOffice') . '&ReportNo=' . $this->input->get('ReportNo') . '&ReportMonth=' . $this->input->get('ReportMonth') . '&ReportYear=' . $this->input->get('ReportYear')); ?>" 
                    class="save" 
                    target="_blank">
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
                                <p class="small">
                                    Total Couples/<br>
                                    Individuals <br>
                                    Reached
                                </p>                                    
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
                    <?php

                    $sub_total = new FormAClass();
                    $grand_total = new FormAClass();
                    $forma = new FormAClass();
                    $num_entries = count($forma_list);
                    $x = 1;
                    $y = 1;
                    $z = 1;
                    $num_grand_total = 16;

                    foreach ($forma_list as $key => $forma) {
                        $forma->DateText = date('F', strtotime(strtoupper( date('Y', $forma_list->From)) .'-' . $forma->ReportDate . '-1'));
                    ?>
                    
                    <tr>
                            <td class="text-center">
                                <p class="small">
                                    <b>
                                    <?= $forma->DateText ?>
                                    <b>
                                </p>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->Class4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->ClassNon4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->ClassUsapan); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->ClassPMC); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->ClassH2H); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->ClassProfiled); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->TotalSessions); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->TargetCouples); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->WRA4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->WRANon4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->WRAUsapan); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->WRAPMC); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->WRAH2H); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->WRAProfiled); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->TotalWRA); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->SoloMale); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->SoloFemale); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->CoupleAttendee); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($forma->TotalReached); ?>
                            </td>
                        </tr>
                    <?php
                        $sub_total->Class4Ps = (int)$sub_total->Class4Ps + (int)$forma->Class4Ps;
                        $sub_total->ClassNon4Ps = (int)$sub_total->ClassNon4Ps + (int)$forma->ClassNon4Ps;
                        $sub_total->ClassUsapan = (int)$sub_total->ClassUsapan ;
                        $sub_total->ClassPMC = (int)$sub_total->ClassPMC + (int)$forma->ClassPMC;
                        $sub_total->ClassH2H = (int)$sub_total->ClassH2H + (int)$forma->ClassH2H;
                        $sub_total->ClassProfiled = (int)$sub_total->ClassProfiled + (int)$forma->ClassProfiled;
                        $sub_total->TargetCouples = (int)$sub_total->TargetCouples + (int)$forma->TargetCouples;
                        $sub_total->WRA4Ps = (int)$sub_total->WRA4Ps + (int)$forma->WRA4Ps;
                        $sub_total->WRANon4Ps = (int)$sub_total->WRANon4Ps + (int)$forma->WRANon4Ps;
                        $sub_total->WRAUsapan = (int)$sub_total->WRAUsapan + (int)$forma->WRAUsapan;
                        $sub_total->WRAPMC = (int)$sub_total->WRAPMC + (int)$forma->WRAPMC;
                        $sub_total->WRAH2H = (int)$sub_total->WRAH2H + (int) $forma->WRAH2H;
                        $sub_total->WRAProfiled = (int)$sub_total->WRAProfiled +  (int)$forma->WRAProfiled;
                        $sub_total->SoloMale = (int)$sub_total->SoloMale + (int)$forma->SoloMale;
                        $sub_total->SoloFemale = (int)$sub_total->SoloFemale + (int)$forma->SoloFemale;
                        $sub_total->CoupleAttendee = (int)$sub_total->CoupleAttendee + (int)$forma->CoupleAttendee;
                        $sub_total->TotalReached = (int)$sub_total->TotalReached + (int)$forma->TotalReached;

                        $grand_total->Class4Ps = (int)$grand_total->Class4Ps + (int)$forma->Class4Ps;
                        $grand_total->ClassNon4Ps = (int)$grand_total->ClassNon4Ps + (int)$forma->ClassNon4Ps;
                        $grand_total->ClassUsapan = (int)$grand_total->ClassUsapan + (int)$forma->ClassUsapan;
                        $grand_total->ClassPMC = (int)$grand_total->ClassPMC + (int)$forma->ClassPMC;
                        $grand_total->ClassH2H = (int)$grand_total->ClassH2H + (int)$forma->ClassH2H;
                        $grand_total->ClassProfiled = (int)$grand_total->ClassProfiled + (int)$forma->ClassProfiled;
                        $grand_total->TargetCouples = (int)$grand_total->TargetCouples + (int)$forma->TargetCouples;
                        $grand_total->WRA4Ps = (int)$grand_total->WRA4Ps + (int)$forma->WRA4Ps;
                        $grand_total->WRANon4Ps = (int)$grand_total->WRANon4Ps + (int)$forma->WRANon4Ps;
                        $grand_total->WRAUsapan = (int)$grand_total->WRAUsapan + (int)$forma->WRAUsapan;
                        $grand_total->WRAPMC = (int)$grand_total->WRAPMC + (int)$forma->WRAPMC;
                        $grand_total->WRAH2H = (int)$grand_total->WRAH2H + (int)$forma->WRAH2H;
                        $grand_total->WRAProfiled = (int)$grand_total->WRAProfiled + (int)$forma->WRAProfiled;
                        $grand_total->SoloMale = (int)$grand_total->SoloMale + (int)$forma->SoloMale;
                        $grand_total->SoloFemale = (int)$grand_total->SoloFemale + (int)$forma->SoloFemale;
                        $grand_total->CoupleAttendee = (int)$grand_total->CoupleAttendee + (int)$forma->CoupleAttendee;
                        $grand_total->TotalReached = (int)$grand_total->TotalReached + (int)$forma->TotalReached;

                        if ($z == 3) {
                    ?>
                            <tr>
                                <td class="text-center">
                                    <p class="small">
                                        <b>
                                            Subtotal
                                        <b>
                                    </p>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->Class4Ps); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->ClassNon4Ps); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->ClassUsapan); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->ClassPMC); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->ClassH2H); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->ClassProfiled); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->TotalSessions); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->TargetCouples); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->WRA4Ps); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->WRANon4Ps); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->WRAUsapan); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->WRAPMC); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->WRAH2H); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->WRAProfiled); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->TotalWRA); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->SoloMale); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->SoloFemale); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->CoupleAttendee); ?>
                                </td>
                                <td style="text-align: right; padding-right: 10px;">
                                    <?php echo HtmlHelper::dashInputPdf($sub_total->TotalReached); ?>
                                </td>
                            </tr>
                    <?php
                            $x++;
                            /** subtotal here */
                            $z = 1;
                            $sub_total->Class4Ps = 0;
                            $sub_total->ClassNon4Ps = 0;
                            $sub_total->ClassUsapan = 0;
                            $sub_total->ClassPMC = 0;
                            $sub_total->ClassH2H = 0;
                            $sub_total->ClassProfiled = 0;
                            $sub_total->TargetCouples = 0;
                            $sub_total->WRA4Ps = 0;
                            $sub_total->WRANon4Ps = 0;
                            $sub_total->WRAUsapan = 0;
                            $sub_total->WRAPMC = 0;
                            $sub_total->WRAH2H = 0;
                            $sub_total->WRAProfiled = 0;
                            $sub_total->SoloMale = 0;
                            $sub_total->SoloFemale = 0;
                            $sub_total->CoupleAttendee = 0;
                            $sub_total->TotalReached = 0;
                        } else {
                            $y++;
                            $z++;
                        }
                    }
                        if ($y < 3) {
                    ?>
                        <tr>
                            <td class="text-center">
                                <p class="small">
                                    <b>
                                        Subtotal
                                    <b>
                                </p>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->Class4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->ClassNon4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->ClassUsapan); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->ClassPMC); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->ClassH2H); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->ClassProfiled); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->TotalSessions); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->TargetCouples); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->WRA4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->WRANon4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->WRAUsapan); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->WRAPMC); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->WRAH2H); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->WRAProfiled); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->TotalWRA); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->SoloMale); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->SoloFemale); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->CoupleAttendee); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($sub_total->TotalReached); ?>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                        <tr>
                            <td class="text-center">
                                <p class="small">
                                    <b>
                                        Grand Total
                                    <b>
                                </p>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->Class4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->ClassNon4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->ClassUsapan); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->ClassPMC); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->ClassH2H); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->ClassProfiled); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->TotalSessions); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->TargetCouples); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->WRA4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->WRANon4Ps); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->WRAUsapan); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->WRAPMC); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->WRAH2H); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->WRAProfiled); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->TotalWRA); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->SoloMale); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->SoloFemale); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->CoupleAttendee); ?>
                            </td>
                            <td style="text-align: right; padding-right: 10px;">
                                <?php echo HtmlHelper::dashInputPdf($grand_total->TotalReached); ?>
                            </td>
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
            <?php if(!$is_pdf) : ?>
                <div class="text-right">
    				<p><?= date('M d, Y h:ia')?></p>
    			</div>
            <?php endif; ?>
        </div>
    </div>
</div>