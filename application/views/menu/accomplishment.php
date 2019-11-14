<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Accomplishment Report';
}

$count = count($accomplishment);
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">
<script src="<?= base_url('assets/js/accomplishment.js') ?>"></script>

<br>
<div style="text-transform: none; width: 15%;">
    <input type="submit" class="save" value="Generate Report" name="genAccomplishment" />
</div>
<br>
<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap accomplishmentList" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Report #</th>
            <th>Report Year | Month</th>
            <th>Date Conducted</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($count >= 1) { ?>
            <?php foreach ($accomplishment as $accomplished) : ?>
                <tr>
                    <td><?= $accomplished->ReportNo ?></td>
                    <td><?= $accomplished->ReportYear ?> - <?php if ($accomplished->ReportMonth != 0) { echo strftime("%b" ,mktime(0,0,0, $accomplished->ReportMonth )); } else { echo $accomplished->ReportMonth; } ?></td>
                    <td><?= date('F d, Y', strtotime($accomplished->DateProcessed)); ?></td>
                    <td class="text-center">
                        <a class="viewForm folderview" href="<?= base_url('forms/accomplishment?ReportNo='. $accomplished->ReportNo); ?>" target="_blank">
                        <button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
                            <i class="fa fa-folder-open"></i>
                        </button>					
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php } else { ?>
            <tr>
                <td class="text-center" colspan="4">No result(s) found.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready( function () {
        var table = $('.accomplishmentList').DataTable();
    });
</script>