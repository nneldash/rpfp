<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | RPFP Form B Report List';
}

$array = '';
foreach ($form_B as $key => $formb) {
    $array = $formb;
}

if (!$isFocal) {
    $columns = 6;
} else {
    $columns = 5;
}
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('NewAssets/fontAwesome'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css'); ?>" rel="stylesheet">
<link href="<?= base_url('NewAssets/sweetalertCss'); ?>" rel="stylesheet">

<style>
    .swal2-container{
        top: 0px!important;
    }
</style>

<div class="loading" id="loading-wrapper" >
    <div id="loading-text" role="status"></div>
</div>
<?php if (!$isFocal): ?>
    <div class="col-md-12" style="padding: 0 0 20px">
        <div class="col-md-3" style="text-transform: none; padding: 0">
            <button class="genReportB save" data-toggle="tooltip" data-placement="left" title="Generate Report" name="genFormB">
                <i class="fa fa-plus"></i>
            </button>
            <button class="delete" name="deleteButton" data-toggle="tooltip" data-placement="left" title="Delete Report" hidden>
                <i class="fa fa-trash"></i>
            </button>
        </div>
        <div class="col-md-9"></div>    
    </div>
<?php endif; ?>

<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap formBList" cellspacing="0" width="100%">
    <thead>
        <tr>
            <?php if (!$isFocal): ?>
                <th>
                    <?php if (!empty($array)) : ?>
                        <input id="checkAll" type="checkbox" />
                        <input type="hidden" name="reportName" value="formB" />
                    <?php endif; ?>
                </th>
            <?php endif; ?>
            <th>Report #</th>
            <th>Report Code</th>
            <th>Report Year | Month</th>
            <th>Date Generated</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($form_B as $key => $formb) : ?>
            <?php if ($formb->ReportID != 'N/A') { ?>
                <tr>
                    <?php if (!$isFocal): ?>
                        <td>
                            <input class="checkSelect" name="reportNo[<?= $key ?>]" type="checkbox" value="<?= $formb->ReportNo ?>" />
                        </td>
                    <?php endif; ?>
                    <td><?= $formb->ReportID ?></td>
                    <td><?= $formb->ReportNo ?></td>
                    <td><?= $formb->ReportYear ?> - <?= $formb->ReportCode ?></td>
                    <td><?= date('F d, Y', strtotime($formb->DateProcessed)); ?></td>
                    <td class="text-center">
                    <a class="viewForm folderview" href="<?= base_url('forms/formb?RegionalOffice='. $formb->RegionalOffice.'&ReportNo='. $formb->ReportNo.'&ReportMonth='. $formb->ReportCode.'&ReportYear='. $formb->ReportYear); ?>" target="_blank">
                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
                            <i class="fa fa-folder-open"></i>
                        </button>					
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="<?= $columns; ?>">No result(s) found.</td>
                    <?php if (!$isFocal): ?>
                        <td class="text-center none"></td>
                    <?php endif; ?>
                    <td class="text-center none"></td>
                    <td class="text-center none"></td>
                    <td class="text-center none"></td>
                    <td class="text-center none"></td>
                </tr>
            <?php } ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    loadJs(base_url + 'NewAssets/templateJs', function() {
        loadJs(base_url + 'NewAssets/sweetalertJs', function(){
            loadJs(base_url + 'assets/js/modals.js', function(){
                clickModalReportB();
                deleteReport();
            });
        });
    });

    $(".formBList").DataTable({
        "lengthMenu": [
            [12, 24, 36, 48, 60],
            ['12', '24', '36', '48', '60']
        ]
    });
</script>