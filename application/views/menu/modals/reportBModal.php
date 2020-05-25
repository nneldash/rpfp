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
        <form id="reportGen" class="form-horizontal">
            <input style="text-transform: none;" class="formName" type="hidden" value="genFormB" />
            <label> 
                <span class="text-required">*</span> 
                Report Type: 
            </label>
    		<select class="form-control" name="repTypeSelect" required>
    			<option id="repType" value="">Type</option>
                <option id="repType" value="01">Annually</option>
                <option id="repType" value="02">Quarterly</option>
                <option id="repType" value="03">Monthly</option>
    		</select>
            <br>
            <label> 
                <span class="text-required year-label-req" hidden>*</span> 
                Report Year: 
            </label>
    		<select class="form-control yearSelect" name="repYearSelect" disabled>
    			<option id="repYear" value="">Year</option>
    			<?php for ($i = $current_year; $i > 2017; $i--): ?>
                    <option id="repYear" value="<?=$i?>"><?= $i?></option>
                <?php endfor?>
    		</select>
            <br>
            <label> 
                <span class="text-required qtr-label-req" hidden>*</span> 
                Report Quarter: 
            </label>
    		<select class="form-control qtrSelect" name="repQuarterSelect" disabled>
    			<option id="repQuarter" value="">Quarter</option>
                <option id="repQuarter" value="01">1st Quarter</option>
                <option id="repQuarter" value="02">2nd Quarter</option>
                <option id="repQuarter" value="03">3rd Quarter</option>
                <option id="repQuarter" value="04">4th Quarter</option>
    		</select>
            <br>
            <label> 
                <span class="text-required month-label-req" hidden>*</span> 
                Report Month: 
            </label>
    		<select class="form-control monthSelect" name="repMonthSelect" disabled>
    			<option id="repMonth" value="">Month</option>
                <option id="repMonth" value="01">January</option>
                <option id="repMonth" value="02">February</option>
                <option id="repMonth" value="03">March</option>
                <option id="repMonth" value="04">April</option>
                <option id="repMonth" value="05">May</option>
                <option id="repMonth" value="06">June</option>
                <option id="repMonth" value="07">July</option>
                <option id="repMonth" value="08">August</option>
                <option id="repMonth" value="09">September</option>
                <option id="repMonth" value="10">October</option>
                <option id="repMonth" value="11">November</option>
                <option id="repMonth" value="12">December</option>
    		</select>
    		<br>
    		<div style="text-transform: none; ">
                <input type="submit" class="save genFormSubmit buttonload" name="saveAccomp" value="SUBMIT" />
                <button class="save buttonload loading-form" hidden disabled>
                    <span><i class="fa fa-spinner fa-spin"></i></span>
                </button>
            </div>
        </form>
	</div>
</div>
<script>
	loadJs(base_url + 'NewAssets/sweetalertJs', function(){
        loadJs(base_url + 'assets/js/saveForms.js', function(){
            genForm();
            enableFields();
        });
    });
</script>