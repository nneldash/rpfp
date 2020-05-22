<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Accomplishment Report';
}

?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<div class="col-md-12" style="padding: 0 0 20px">
    <div class="col-md-3" style="text-transform: none; padding: 0">
        <input type="submit" class="save genAccomp" value="Generate Report" name="genAccomplishment" />
    </div>
    <div class="col-md-3" style="text-transform: none; padding: 0">
        <input type="submit" class="delete" name="deleteButton" value="Delete Selected" hidden />
    </div>
    <div class="col-md-6"></div>
</div>

<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap accomplishmentList" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="checkAll" />
            </th>
            <th>Report #</th>
            <th>Encoded From</th>
            <th>Encoded To</th>
            <th>Date Processed</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accomplishment as $accomplished) : ?>
            <?php if ($accomplished->ReportNo != 'N/A') { ?>
                <tr>
                    <td>
                        <input class="checkSelect" name="reportNo" type="checkbox" value="<?= $accomplished->ReportNo ?>" />
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
        loadJs(base_url + 'assets/js/modals.js', function(){
            clickModalAccomp();
            deleteReport();
        });
    });

    $(".accomplishmentList").DataTable({
        "lengthMenu": [
            [12, 24, 36, 48, 60],
            ['12', '24', '36', '48', '60']
        ]
    });
</script>