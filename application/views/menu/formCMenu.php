<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | RPFP Form C Report List';
}
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('NewAssets/fontAwesome'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css'); ?>" rel="stylesheet">

<div class="col-md-12" style="padding: 0 0 20px">
    <div class="col-md-3" style="text-transform: none; padding: 0">
        <input type="submit" class="save genReportC" value="Generate Report" name="genFormC" />
    </div>
    <div class="col-md-3" style="text-transform: none; padding: 0">
        <input type="submit" class="delete" name="deleteButton" value="Delete Selected" hidden />
    </div>
    <div class="col-md-6"></div>
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
        loadJs(base_url + 'assets/js/modals.js', function(){
            clickModalReportC();
            deleteReport();
        });
    });

    $(".formCList").DataTable({
        "lengthMenu": [
            [12, 24, 36, 48, 60],
            ['12', '24', '36', '48', '60']
        ]
    });
</script>