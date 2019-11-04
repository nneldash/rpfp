<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'RPFP Online | Pending';
}
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<script>loadCss(base_url + '/assets/css/style.css');</script>
<script>loadCss(base_url + '/assets/css/form.css');</script>

<br>
<table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Class #</th>
            <th>Type Class</th>
            <th>Barangay</th>
            <th>Date Conducted</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($pending as $pendings) : ?>
            <tr>
                <td id="classNo"><?= $pendings->ClassNo ?></td>
                <td><?= $pendings->TypeClass ?></td>
                <td><?= $pendings->Barangay; ?></td>
                <td><?= date('F d, Y', strtotime($pendings->DateConduct)); ?></td>
                <td class="text-center">					
                    <button class="btn btn-primary btn-pending-listing" data-toggle="tooltip" data-placement="left" title="View List">
                        <i class="fa fa-list"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    loadJs(base_url + '/NewAssets/templateJs',
        function() { loadJs(base_url + '/assets/js/listCouples.js'); }
    );

    <?php
    if (!empty($reload)) {
        ?>
        $("#datatable-responsive").DataTable();
        <?php
    }
    ?>    
</script>
