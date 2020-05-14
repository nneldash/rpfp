<?php
defined('BASEPATH') or exit('No direct script access allowed');
$current_year = date('Y');
?>
<style>
    .text-required {
        color: red;
        font-size: 14px;
    }
</style>
<link href="<?= base_url('NewAssets/sweetalertCss'); ?>" rel="stylesheet">

<div class="container-fluid">	
	<div class="row">
        <form id="accompGen" class="form-horizontal">
    		<label> 
                <span class="text-required">*</span> 
                Date From: 
            </label>
    		<input class="form-control" name="accompDateFromSelect" type="date" required max="9999-12-31" />
    		<br>
    		<label> 
                <span class="text-required">*</span> 
                Date To: 
            </label>
    		<input class="form-control" name="accompDateToSelect" type="date" required max="9999-12-31" />
    		<br>
    		<div style="text-transform: none; ">
                <input type="submit" class="save genAccompSubmit buttonload" name="saveAccomp" value="SUBMIT" />
                <button class="save buttonload loading-accomp" hidden disabled>
                    <span><i class="fa fa-spinner fa-spin"></i></span>
                </button>
            </div>
        </form>
	</div>
</div>
<script>
	loadJs(base_url + 'NewAssets/sweetalertJs', function(){
        loadJs(base_url + 'assets/js/saveAccomplishment.js', function(){
            genAccomp();
        });
    });
</script>