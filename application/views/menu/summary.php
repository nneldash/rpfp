<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Accomplishment Report';
}
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<script>loadCss(base_url + '/assets/css/style.css');</script>
<script>loadCss(base_url + '/assets/css/form.css');</script>

<br>
<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap accomplishmentReport" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Report #</th>
            <th>Report Year | Month</th>
            <th>Date Conducted</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- <?php foreach ($accomplishment as $accomplished) : ?>
            <tr>
                <td><?= $accomplished->ReportNo ?></td>
                <td><?= $accomplished->ReportYear ?> - <?= $accomplished->ReportMonth ?></td>
                <td><?= date('F d, Y', strtotime($accomplished->DateProcessed)); ?></td>
                <td class="text-center">
                    <button class="btn btn-primary btn-accomplishment" data-toggle="tooltip" data-placement="left" title="View">
                        <i class="fa fa-view"></i>
                    </button>					
                </td>
            </tr>
        <?php endforeach; ?> -->
    </tbody>
</table>

<script>
    $(document).ready( function () {
        var table = $('.accomplishmentReport').DataTable();
    });
</script>