<?php
defined('BASEPATH') or exit('No direct script access allowed');
$current_year = date('Y');
?>
<link href="<?= base_url('NewAssets/sweetalertCss'); ?>" rel="stylesheet">

<div class="container-fluid">	
	<div class="row">
		<label>Report Year: </label>
		<select class="form-control" id="repYearSelect" required>
			<option id="repYear" value="">Year</option>
			<?php for ($i = $current_year; $i > 2017; $i--): ?>
                <option id="repYear" value="<?=$i?>"><?= $i?></option>
            <?php endfor?>
		</select>
		<br>
		<label>Report Month: </label>
		<select class="form-control" id="repMonthSelect" required>
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
            <input type="button" class="save genAccompSubmit" value="Submit" name="genAccompReport" />
        </div>
	</div>
</div>
<script type="text/javascript" src="<?= base_url('assets/js/saveAccomplishment.js')?>"></script>
<script>
	loadJs(base_url + 'NewAssets/sweetalertJs');
</script>