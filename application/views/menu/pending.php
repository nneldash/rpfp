<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Pending';
}

?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css/form.css'); ?>" rel="stylesheet" />

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
        <?php foreach ($pending as $pendings) : ?>
            <?php if ($pendings->ClassNo != 'N/A') { ?>
                <tr>
					<td><?= $pendings->ClassNo; ?></td>
					<td><?= $pendings->TypeClass; ?></td>
					<td><?= $pendings->Barangay; ?></td>
					<td><?= date('F d, Y', strtotime($pendings->DateConduct)); ?></td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-approve-listing" data-toggle="tooltip" data-placement="left" title="View List">
                            <i class="fa fa-list"></i>
                        </button>					
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="5">No result(s) found.</td>
                </tr>
            <?php } ?>
        <?php endforeach; ?>
    </tbody>
</table>

<button id="refresh">refresher</button>
<script>
    loadJs(base_url + 'NewAssets/templateJs', function() {
        loadJs(base_url + 'assets/js/listCouples.js');
        loadJs(base_url + 'NewAssets/datatableJs', function() {
            loadJs(base_url + 'NewAssets/datatableBtJs', function() {
                loadJs(base_url + 'NewAssets/datatableRpJs', function() {
                    loadJs(base_url + 'NewAssets/datatableBtrpJs.js', function() {
                        loadJs(base_url + 'assets/js/pending.js', function() {
                            if (<?= (!empty($reload) ? 'true' : 'false') ?>) {
                                refresh_now();
                            }
                        });
                    });
                });
            });
        });
    });
</script>
