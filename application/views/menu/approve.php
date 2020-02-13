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
<a class="searchDropdown text-right" data-toggle="collapse" data-parent="#accordion" href="#searchCouple">
    Hide/Show Search
</a>
<form class="form-horizontal form-label-left" id="search_form"> 
    <div class="col-md-12 collapse in" id="searchCouple">
        <div class="col-md-6 col-xs-12">
            <div class="x_title">
                <h3>Class</h3>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <!-- <div class="form-group">
                    <label>Location</label>
                </div> -->

                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Province</label>
                    <div class="col-md-7 col-xs-12">
                        <select class="selectpicker" id="provinceList" data-live-search="true" title="">
                        
                        </select>
                        <input type="hidden" readonly name="province_search" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">City/Municipality</label>
                    <div class="col-md-7 col-xs-12">
                        <select class="selectpicker" id="muniList" data-live-search="true" title="">

                        </select>
                        <input type="hidden" readonly name="municipality_search" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Barangay</label>
                    <div class="col-md-7 col-xs-12">
                        <select class="selectpicker" id="brgyList" data-live-search="true" title="">
                        
                        </select>
                        <input type="hidden" readonly name="barangay_search" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Class Number</label>
                    <div class="col-md-7 col-xs-12">
                        <input type="text" name="classno_search">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Date Conducted</label>
                    <label class="control-label col-md-2 col-xs-12">From</label>
                    <div class="col-md-5 col-xs-12">
                        <input type="date" max="9999-12-31" name="datefrom_search">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12"></label>
                    <label class="control-label col-md-2 col-xs-12">To</label>
                    <div class="col-md-5 col-xs-12">
                        <input type="date" max="9999-12-31" name="dateto_search">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Type of Class</label>
                    <div class="col-md-7 col-xs-12">
                        <select class="form-control" name="typeclass_search">
                            <option value=""></option>
                            <option value="1">4Ps</option>
                            <option value="2">FBOs</option>
                            <option value="3">PMC</option>
                            <option value="4">Usapan</option>
                            <option value="5">House to House</option>
                            <option value="6">Profile</option>
                            <option value="7">Others</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="x_title">
                <h3>Couples</h3>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Name</label>
                    <div class="col-md-7 col-xs-12">
                        <input type="text" name="name_search">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Age</label>
                    <label class="control-label col-md-2 col-xs-12">From</label>
                    <div class="col-md-5 col-xs-12">
                        <input type="text" name="agefrom_search" maxlength="3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12"></label>
                    <label class="control-label col-md-2 col-xs-12">To</label>
                    <div class="col-md-5 col-xs-12">
                        <input type="text" name="ageto_search" maxlength="3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-xs-12">Number of Children</label>
                    <div class="col-md-7 col-xs-12">
                        <input type="text" name="no_children_search" maxlength="3">
                    </div>
                </div>
                <div class="x_title">
                    <h3>FP Details</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-xs-12">FP Type</label>
                        <div class="col-md-7 col-xs-12">
                            <select name="fptype_search" class="form-control fp_type">
                                <option value=""></option>
                                <option value="modernfp_user">FP User</option>
                                <option value="non_fp_user">Non-FP User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-xs-12">FP Status</label>
                        <div class="col-md-7 col-xs-12">
                            <select name="fpstatus_search" class="form-control">
                                <option value="1"></option>
                                <option value="2">Unmet Need</option>
                                <option value="3">Served Unmet Needd</option>
                                <option value="4">Shifters</option>
                                <option value="5">Served Shifters</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="for_modernfp_user"></p>
                    </div>
                    <div class="form-group">
                        <p class="non_fp_intention_status"></p>
                    </div>
                    <div class="form-group">
                        <p class="with_intention"></p>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-4 col-xs-12 text-center">
            <br>
            <input class="btn btn-primary search_now" type="submit" name="search" value="Search">
        </div>
        <br><br>
    </div>
</form>

<hr>
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
</div>

<script>
    loadJs(base_url + 'NewAssets/bootstrapSelectJs');
    loadJs(base_url + 'NewAssets/templateJs', function() {
        loadJs(base_url + 'assets/js/listCouples.js', function(){
            removeSearch();
            listCoupleModal();
            liveSearch();
            getProvinces();
            fpType();
            numbersOnly();
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
