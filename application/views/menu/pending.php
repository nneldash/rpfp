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
            <th>Province</th>
            <th>Municipality / City</th>
            <th>Barangay</th>
            <th>Number of Couples</th>
            <th>Date Conducted</th>
            <th>Encoded By</th>
            <th style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody>      
        <?php foreach ($pending as $pendings) : ?>
            <?php if ($pendings->ClassNo != 'N/A') { ?>
                <tr>
					<td><?= $pendings->ClassNo; ?></td>
					<td><?= $pendings->TypeClass; ?></td>
                    <td><?= $pendings->Province; ?></td>
                    <td><?= $pendings->Municipality; ?></td>
					<td><?= $pendings->Barangay; ?></td>
                    <td><?= $pendings->CouplesEncoded; ?></td>
					<td><?= date('F d, Y', strtotime($pendings->DateConduct)); ?></td>
                    <td><?= $pendings->FirstName .' '. $pendings->LastName; ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('forms?rpfpId='. $pendings->RpfpClass.'&status=2'); ?>" target="_blank">
                            <button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>				
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
        loadJs(base_url + 'assets/js/listCouples.js', function(){
            listCoupleModal();
        });
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
