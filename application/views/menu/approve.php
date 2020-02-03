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
    td {
        padding: 0!important;
        border: none!important;
    }
</style>

<br>
<div class="container-fluid">
    <div class="row">        
        <div class="col-md-12">    
            <form class="form-horizontal">
                <div class="col-md-6 table-responsive">
                    <table class="table nowrap dt-responsive table-condensed" cellspacing="0">
                        <tr>
                            <td><label>LOCATION:</label></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 10%"><label>Province:</label></td>
                            <td><input type="text" name="province_search"></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>City/Municipality:</label></td>
                            <td><input type="text" name="municipality_search"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>Barangay:</label></td>
                            <td><input type="text" name="barangay_search"></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style=""><label>Class Number:</label></td>
                            <td><input type="text" name="classno_search"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>Date Conducted:</label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>To:</label> </td>
                            <td><input type="date" name="dateto_search"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>From:</label></td>
                            <td><input type="date" name="datefrom_search"></td>
                        </tr>
                        
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td style="width: 6%;"><label>Name:</label></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 10%"><label>Province:</label></td>
                            <td><input type="text" name="province_search"></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>City/Municipality:</label></td>
                            <td><input type="text" name="municipality_search"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>Barangay:</label></td>
                            <td><input type="text" name="barangay_search"></p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style=""><label>Class Number:</label></td>
                            <td><input type="text" name="classno_search"></td>
                        </tr>
                        <tr>
                            <td><label>Date Conducted:</label></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>To:</label> <input type="date" name="dateto_search"></td>
                            <td><label>From:</label> <input type="date" name="datefrom_search"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label>From:</label></td>
                            <td><input type="date" name="datefrom_search"></td>
                        </tr>
                        
                    </table>
                </div>
                 <br>
                
                
                
                
                <br>

                <p><b>LOCATION:</b></p>
                <p>Province: <input type="text" name="province_search" style="width: 30%"></p>
                <p>City/Municipality: <input type="text" name="municipality_search" style="width: 30%"></p>
                <p>Barangay: <input type="text" name="barangay_search" style="width: 30%"></p>
                <br>
                <p>
                    Class Number: <input type="text" name="classno_search" style="width: 30%">
                    To: <input type="date" name="dateto_search" style="width: 15%">
                    From: <input type="date" name="datefrom_search" style="width: 15%">
                </p>
                <p>
                    Type of Class: <select style="width: 15%">
                        <option></option>
                        <option>4Ps</option>
                        <option>Profile</option>
                        <option>FBOs</option>
                        <option>PMC</option>
                        <option>Usapan</option>
                        <option>House to House</option>
                        <option>Others</option>
                    </select>
                </p>
                <br>
                <p>Name: <input type="text" name="name_search" style="width: 30%"></p>
                <p>
                    Age: <input type="number" name="agefrom_search" max="200" style="width: 5%"> To: <input type="number" name="agefrom_search" maxlen="200" style="width: 5%">
                </p>
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
                <p><input type="submit" name="search" value="Search" style="width: 10%"></p>
            </form>   
        </div>
    </div>    
</div>

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
