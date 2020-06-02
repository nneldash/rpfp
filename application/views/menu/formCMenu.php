<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | RPFP Form C Report List';
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

<div class="col-md-12" style="padding: 0 0 20px">
    <div class="col-md-3" style="text-transform: none; padding: 0">
        <button class="genReportC save" data-toggle="tooltip" data-placement="left" title="Generate Report" name="genFormC">
            <i class="fa fa-plus"></i>
        </button>
        <button class="delete" name="deleteButton" data-toggle="tooltip" data-placement="left" title="Delete Report" hidden>
            <i class="fa fa-trash"></i>
        </button>
    </div>
    <div class="col-md-9"></div>    
</div>

<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap formCList" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>
                <input id="checkAll" type="checkbox" />
                <input type="hidden" name="reportName" value="formC" />
            </th>
            <th>Report #</th>
            <th>Report Code</th>
            <th>Report Year | Month</th>
            <th>Date Generated</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($form_C as $key => $formc) : ?>
            <?php if ($formc->ReportID != 'N/A') { ?>
                <tr>
                    <td>
                        <input class="checkSelect" name="reportNo[<?= $key ?>]" type="checkbox" value="<?= $formc->ReportNo ?>" />
                    </td>
                    <td><?= $formc->ReportID ?></td>
                    <td><?= $formc->ReportNo ?></td>
                    <td><?= $formc->ReportYear ?> - <?= $formc->ReportCode ?></td>
                    <td><?= date('F d, Y', strtotime($formc->DateProcessed)); ?></td>
                    <td class="text-center">
                        <a class="viewForm folderview" href="<?= base_url('forms/formc?RegionalOffice='. $formc->RegionalOffice.'&ReportNo='. $formc->ReportNo.'&ReportMonth='. $formc->ReportCode.'&ReportYear='. $formc->ReportYear); ?>" target="_blank">
                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
                            <i class="fa fa-folder-open"></i>
                        </button>					
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="5">No result(s) found.</td>
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
                clickModalReportC();
                deleteReport();
            });
        });
    });

    $(".formCList").DataTable({
        "lengthMenu": [
            [12, 24, 36, 48, 60],
            ['12', '24', '36', '48', '60']
        ]
    });
</script>