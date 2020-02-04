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
<form class="form-horizontal form-label-left" id="search_form"> 
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="x_title">
                <h3>Class</h3>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <!-- <div class="form-group">
                    <label>Location</label>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-md-3">Province</label>
                    <div class="col-md-7">
                        <select class="selectpicker" id="provinceList" data-live-search="true" title="">

                        </select>
                        <input type="hidden" readonly name="province_search" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">City/Municipality</label>
                    <div class="col-md-7">
                        <select class="selectpicker" id="muniList" data-live-search="true" title="">

                        </select>
                        <input type="hidden" readonly name="municipality_search" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Barangay</label>
                    <div class="col-md-7">
                        <select class="selectpicker" id="brgyList" data-live-search="true" title="">

                        </select>
                        <input type="hidden" readonly name="barangay_search" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Class Number</label>
                    <div class="col-md-7">
                        <input type="text" name="classno_search">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Date Conducted</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">From</label>
                    <div class="col-md-7">
                        <input type="date" name="datefrom_search">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">To</label>
                    <div class="col-md-7">
                        <input type="date" name="dateto_search">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Type of Class</label>
                    <div class="col-md-7">
                        <select class="form-control" name="typeclass_search">
                            <option value=""></option>
                            <option value="4ps">4Ps</option>
                            <option value="profile">Profile</option>
                            <option value="fbo">FBOs</option>
                            <option value="pmc">PMC</option>
                            <option value="usapan">Usapan</option>
                            <option value="house_to_house">House to House</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="x_title">
                <h3>Couples</h3>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-md-3">Name</label>
                    <div class="col-md-7">
                        <input type="text" name="name_search"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Age</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">From</label>
                    <div class="col-md-7">
                        <input type="text" name="agefrom_search" class="numbers_only" maxlength="2">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">To</label>
                    <div class="col-md-7">
                        <input type="text" name="ageto_search" class="numbers_only" maxlength="2">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Number of Children</label>
                    <div class="col-md-7">
                        <input type="text" name="no_children_search" class="numbers_only" maxlength="3">
                    </div>
                </div>
            </div>
            <div class="x_title">
                <h3>FP Details</h3>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-md-3">FP Type</label>
                    <div class="col-md-7">
                        <select name="fptype_search" class="form-control fp_type">
                            <option value=""></option>
                            <option value="fp_user">FP User</option>
                            <option value="non_fp_user">Non-FP User</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <p class="for_fp_user"></p>
                </div>
                <div class="form-group">
                    <p class="non_fp_intention_status"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-md-offset-4 text-center">
        <br>
        <input class="btn btn-primary search_now" type="submit" name="search" value="Search">
    </div>
</form>
<br><br>
<div class="table-search-results">
    <table id="datatable-responsive" class="table table-condensed table-striped table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Class #</th>
                <th>Type of Class</th>
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
