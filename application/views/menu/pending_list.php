<?php
defined('BASEPATH') or exit('No direct script access allowed');

?>

<div class="table-search-results">
    <table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Class #</th>
                <th>Type Class</th>
                <th>Province</th>
                <th>Municipality / City</th>
                <th>Barangay</th>
                <th>Number of Couples</th>
                <th>Number of Couples Served</th>
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
                        <td class="text-center"><?= $pendings->CouplesEncoded; ?></td>
                        <td class="text-center"><?= ( $pendings->CouplesServed > 0 ? $pendings->CouplesServed : '0' ) ?></td>
                        <td><?= date('F d, Y', strtotime($pendings->DateConduct)); ?></td>
                        <td><?= ucfirst($pendings->FirstName) .' '. ucfirst($pendings->LastName); ?></td>
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
                        <td class="text-center" colspan="9">No result(s) found.</td>
                        <td class="text-center none"></td>
                        <td class="text-center none"></td>
                        <td class="text-center none"></td>
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
</div>

<script>
    <?php
    if (!empty($reload)) {
        ?>
        // $("#datatable-responsive").DataTable();
        <?php
    }
    ?>    
</script>