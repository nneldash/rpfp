<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Pending';
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

<div class="loading" id="loading-wrapper" >
    <div id="loading-text" role="status"></div>
</div>
<a class="searchDropdown text-right" data-toggle="collapse" data-parent="#accordion" href="#searchCouple">
    Hide/Show Search
</a>
<form class="form-horizontal form-label-left" id="search_form"> 
    <div class="col-md-12" id="searchCouple">
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
        <div class="col-md-4 col-md-offset-4 col-xs-12 text-center">
            <br>
            <input class="btn btn-primary search_now" type="submit" name="search" value="Search">
        </div>
        <br><br>
    </div>
</form>

<hr>
<script>
    loadJs(base_url + 'NewAssets/bootstrapSelectJs');
    loadJs(base_url + 'NewAssets/templateJs', function() {
        loadJs(base_url + 'assets/js/listCouples.js', function(){
            // $('#datatable-responsive').DataTable();
            removeSearch();
            listCoupleModal();
            liveSearch();
            getProvinces();
            pendingSearchNow();
        });
    });
</script>
