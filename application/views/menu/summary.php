<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('NewAssets/datatablesBootstrap') ?>" rel="stylesheet">
<link href="<?= base_url('NewAssets/datatablesResponsive') ?>" rel="stylesheet">

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
        <tr>
            <td>RPFP-TAC-2019-00001</td>
            <td>4Ps</td>
            <td>Barangay 92 (Apitong)</td>
            <td>February 11, 2019</td>
            <td class="text-center">
                <a href="<?= base_url('forms?rpfpId='.md5(1)); ?>" target="_blank">
                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>
                </a>
            </td>
        </tr>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('NewAssets/datatableJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableBtJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableRpJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/datatableBtrpJs')?>"></script>