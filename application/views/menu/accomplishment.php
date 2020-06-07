<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Accomplishment Report';
}

$array = '';
foreach ($accomplishment as $key => $accomplished) {
    $array = $accomplished;
}

?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">
<link href="<?= base_url('NewAssets/sweetalertCss'); ?>" rel="stylesheet">

<style>
    .swal2-container{
        top: 0px!important;
    }
</style>

<div class="col-md-12" style="padding: 0 0 20px">
    <div class="col-md-3" style="text-transform: none; padding: 0">
        <button class="genAccomp save" data-toggle="tooltip" data-placement="left" title="Generate Report" name="genAccomplishment">
            <i class="fa fa-plus"></i>
        </button>
        <button class="delete" name="deleteButton" data-toggle="tooltip" data-placement="left" title="Delete Report" hidden>
            <i class="fa fa-trash"></i>
        </button>
    </div>
    <div class="col-md-9"></div>    
</div>

<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap accomplishmentList" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>
                <?php if (!empty($array)) : ?>
                    <input type="checkbox" id="checkAll" />
                    <input type="hidden" name="reportName" value="accompReport" />
                <?php endif; ?>
            </th>
            <th>Report #</th>
            <th>Encoded From</th>
            <th>Encoded To</th>
            <th>Date Processed</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accomplishment as  $key => $accomplished) : ?>
            <?php if ($accomplished->ReportNo != 'N/A') { ?>
                <tr>
                    <td>
                        <input class="checkSelect" name="reportNo[<?= $key ?>]" type="checkbox" value="<?= $accomplished->ReportNo ?>" />
                    </td>
                    <td><?= $accomplished->ReportNo ?></td>
                    <td><?= date('F d, Y', strtotime($accomplished->DateFrom)); ?></td>
                    <td><?= date('F d, Y', strtotime($accomplished->DateTo)); ?></td>
                    <td><?= date('F d, Y', strtotime($accomplished->DateProcessed)); ?></td>
                    <td class="text-center">
                        <a class="viewForm folderview" href="<?= base_url('forms/accomplishment?ReportNo='. $accomplished->ReportNo); ?>" target="_blank">
                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
                            <i class="fa fa-folder-open"></i>
                        </button>					
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="6">No result(s) found.</td>
                    <td class="text-center none"></td>
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
                clickModalAccomp();
                deleteReport();
            });
        });
    });

    $(".accomplishmentList").DataTable({
        "lengthMenu": [
            [12, 24, 36, 48, 60],
            ['12', '24', '36', '48', '60']
        ]
    });
</script>