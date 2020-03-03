<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | RPFP Form B Report List';
}
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('NewAssets/fontAwesome'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css'); ?>" rel="stylesheet">

<div class="col-md-12" style="padding: 0 0 20px">
    <div class="col-md-3" style="text-transform: none; padding: 0">
        <input type="submit" class="save genReportB" value="Generate Report" name="genFormB" />
    </div>
    <div class="col-md-9"></div>
</div>

<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap formBList" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Report #</th>
            <th>Report Year | Month</th>
            <th>Date Generated</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($form_B as $formb) : ?>
            <?php if ($formb->ReportID != 'N/A') { ?>
                <tr>
                    <td><?= $formb->ReportID ?></td>
                    <td><?= $formb->ReportYear ?> - <?php if ($formb->ReportMonth != 0) { echo strftime("%b" ,mktime(0,0,0, $formb->ReportMonth )); } else { echo $formb->ReportMonth; } ?></td>
                    <td><?= date('F d, Y', strtotime($formb->DateProcessed)); ?></td>
                    <td class="text-center">
                    <a class="viewForm folderview" href="<?= base_url('forms/formb?ReportMonth='. $formb->ReportMonth.'&ReportYear='. $formb->ReportYear); ?>" target="_blank">
                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
                            <i class="fa fa-folder-open"></i>
                        </button>					
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="4">No result(s) found.</td>
                </tr>
            <?php } ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    loadJs(base_url + 'NewAssets/templateJs', function() {
        loadJs(base_url + 'assets/js/modals.js', function(){
            clickModalReportB();
        });
    });

    $(".formBList").DataTable({
        "lengthMenu": [
            [12, 24, 36, 48, 60],
            ['12', '24', '36', '48', '60']
        ]
    });
</script>