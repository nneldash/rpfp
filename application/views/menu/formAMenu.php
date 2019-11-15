<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'RPFP Online | Form A Data List';
}
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="NewAssets/fontAwesome" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<br>
<div style="text-transform: none; width: 15%;">                    
    <input type="submit" class="save" value="Generate Report" name="genReportA" />
</div>
<br>
<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Report #</th>
            <th>Report Year | Month</th>
            <th>Date Generated</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($form_A as $forma) : ?>
            <?php if ($forma->ReportID != 'N/A') { ?>
                <tr>
                    <td><?= $forma->ReportID ?></td>
                    <td><?= $forma->ReportYear ?> - <?php if ($forma->ReportMonth != 0) { echo strftime("%b" ,mktime(0,0,0, $forma->ReportMonth )); } else { echo $forma->ReportMonth; } ?></td>
                    <td><?= date('F d, Y', strtotime($forma->DateProcessed)); ?></td>
                    <td class="text-center">
                        <a class="viewForm folderview" href="<?= base_url('forms/forma'); ?>" target="_blank">
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

<?php
if (!empty($reload)) {
    ?>
    <script>$("#datatable-responsive").DataTable();</script>
    <?php
}
?>    
