<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Approve';
}

?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>

<link href="<?= base_url('NewAssets/fontAwesome'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css/form.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('NewAssets/bootstrapSelectCss'); ?>" rel="stylesheet">	
<style>
    .dropdownLoc {
        padding-bottom: 0!important;
        padding-top: 7px!important;
    }
</style>

<br>
<form id="search_form">
    <p><b>LOCATION:</b></p>
    <p class="dropdownLoc">
        Province: <select class="selectpicker" id="provinceList" data-live-search="true" title="" style="width: 30%">

        </select>
        <input type="hidden" readonly name="province_hidden" value="" style="width: 15%">
    </p>
    <p>
        City/Municipality: <select class="selectpicker" name="muni_search" id="muniList" data-live-search="true" title="" style="width: 30%">
    
        </select>
        <input type="hidden" readonly name="muni_hidden" value="" style="width: 15%">
    </p>
    <p>
        Barangay: <select class="selectpicker" name="brgy_search" id="brgyList" data-live-search="true" title="" style="width: 30%">

        </select>
        <input type="hidden" readonly name="brgy_hidden" value="" style="width: 15%">
    </p>
    <br>
    <p>
        Class Number: <input type="text" name="classno_search" style="width: 30%">
        To: <input type="date" name="dateto_search" style="width: 15%">
        From: <input type="date" name="datefrom_search" style="width: 15%">
    </p>
    <p>
        Type of Class: <select name="type_of_class" style="width: 15%">
            <option value=""></option>
            <option value="4ps">4Ps</option>
            <option value="profile">Profile</option>
            <option value="fbo">FBOs</option>
            <option value="pmc">PMC</option>
            <option value="usapan">Usapan</option>
            <option value="house_to_house">House to House</option>
            <option value="others">Others</option>
        </select>
    </p>
    <br>
    <p>Name: <input type="text" name="name_search" style="width: 30%"></p>
    <p>
        Age: <input type="number" name="agefrom_search" max="200" style="width: 5%"> To: <input type="number" name="ageto_search" maxlen="200" style="width: 5%">
    </p>
    <p>Number of Children: <input type="number" name="no_children_search" style="width: 5%"></p>
    <br>
    <p>
        FP Type: <select name="fptype_search" style="width: 15%" class="fp_type">
            <option value=""></option>
            <option value="fp_user">FP User</option>
            <option value="non_fp_user">Non-FP User</option>
        </select>
    </p>
    <p class="for_fp_user"></p>
    <p class="non_fp_intention_status"></p>
    <br>
    <p><input type="submit" name="search" class="search_now" value="Search" style="width: 10%"></p>
</form>   
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
        <?php foreach ($approve as $approved) : ?>
            <?php if ($approved->ClassNo != 'N/A') { ?>
                <tr>
					<td><?= $approved->ClassNo; ?></td>
                    <td><?= $approved->TypeClass; ?></td>
                    <td><?= $approved->Province; ?></td>
                    <td><?= $approved->Municipality; ?></td>
                    <td><?= $approved->Barangay; ?></td>
                    <td><?= $approved->CouplesEncoded; ?></td>
                    <td><?= date('F d, Y', strtotime($approved->DateConduct)); ?></td>
                    <td><?= ucfirst($approved->FirstName) .' '. ucfirst($approved->LastName); ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('forms?rpfpId='. $approved->RpfpClass.'&status=0'); ?>" target="_blank">
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

<script>
    loadJs(base_url + 'NewAssets/bootstrapSelectJs');
    loadJs(base_url + 'NewAssets/templateJs', function() {
        loadJs(base_url + 'assets/js/listCouples.js', function(){
            listCoupleModal();
            liveSearch();
            getProvinces();
            fpType();
            searchNow();
        });
    });

    <?php
    if (!empty($reload)) {
        ?>
        $("#datatable-responsive").DataTable();
        <?php
    }
    ?>    
</script>
