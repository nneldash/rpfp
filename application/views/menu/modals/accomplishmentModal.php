<?php
defined('BASEPATH') or exit('No direct script access allowed');
$current_year = date('Y');
?>
<link href="<?= base_url('NewAssets/sweetalertCss'); ?>" rel="stylesheet">

<div class="container-fluid">	
	<div class="row">
        <form id="accompGen" class="form-horizontal">
    		<label>Date From: </label>
    		<input class="form-control" name="accompDateFromSelect" type="date" required />
    		<br>
    		<label>Date To: </label>
    		<input class="form-control" name="accompDateToSelect" type="date" required />
    		<br>
    		<div style="text-transform: none; ">
                <input type="submit" class="save genAccompSubmit buttonload" name="saveAccomp" value="SUBMIT" />
                <button class="save buttonload loading" hidden><span><i class="fa fa-spinner fa-spin"></i></span></button>
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