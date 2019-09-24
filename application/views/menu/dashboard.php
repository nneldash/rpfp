<?php
    $current_year = date('Y');
?>

<style>
	.border-1 {
		border: 1px solid #333;
	}
	p {
		margin-bottom: 0;
	}
	h5 {
		margin-top: 20px;
		margin-bottom: 0;
	}
	.fa {
		margin-left: 5%;
	}
	.btn-hover {
		border-radius: 0;
    	background: #2a3e53;
	}
	.btn-hover:hover {
		color: #333;
	    border: 1px solid #2a3e53;
	    background: #fff;
	}
	.margin-t7 {
		margin-top: 7px;
	}
</style>

<div class="col-md-3 col-sm-12 col-xs-12 border-1">              			
	<div class="row">
		<div class="col-sm-12">
			<h4>Statistics Snapshot</h4>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-9 col-sm-9">
			<p>Couples encoded as of FY <?= $current_year; ?></p>
			<p>Couples encoded as of Jan 1 to Aug 16, <?= $current_year; ?></p>
		</div>
		<div class="col-xs-3 col-sm-3 text-right">
			<p>1,563,385</p>
			<p>270,532</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<h5>Type of Participant for Yr <?= $current_year; ?></h5>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-9 col-sm-9">              				
			<p><i class="fa fa-angle-double-right"></i> &nbsp; 4Ps:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Non-4Ps:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; FBOs:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; PMC:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Usapan Serye:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Others:</p>
		</div>
		<div class="col-xs-3 col-sm-3 text-right">
			<p>140,462</p>
			<p>60,817</p>
			<p>196</p>
			<p>45,671</p>
			<p>7,020</p>
			<p>16,366</p>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-9 col-sm-9">
			<h5><b>Summary of FP Users</b></h5>
		</div>
		<div class="col-xs-3 col-sm-3 text-right">
			<h5 style="color: red;"><b>TOTAL</b></h5>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<h5>Non-Modern FP Users for Yr <?= $current_year; ?></h5>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-9 col-sm-9">
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Withdrawal:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Rhythm: </p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Calendar:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Abstinence:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Herbal:</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; No Method:</p>
		</div>
		<div class="col-xs-3 col-sm-3 text-right">
			<p>10,681</p>
			<p>3,373</p>
			<p>6,415</p>
			<p>1,243</p>
			<p>1,106</p>
			<p>120,920</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<h5>Intention to Use for Yr <?= $current_year; ?></h5>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-9 col-sm-9">
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Intention to Use FP Method</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Undecided</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; Currently Pregnant</p>
			<p><i class="fa fa-angle-double-right"></i> &nbsp; No Intention to Use FP Method</p>
		</div>
		<div class="col-xs-3 col-sm-3 text-right">
			<p>27,427</p>
			<p>43,274</p>
			<p>6,607</p>
			<p>63,178</p>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-9">
	<div class="row">
		<form class="form-horizontal form-label-left">
			<div class="form-group">
				<br>
				<label class="control-label col-md-9 col-sm-9 col-xs-12 text-right margin-t7">Choose Year</label>
				<div class="input-group col-md-3 col-sm-3 col-xs-12">
					<select class="form-control">
						<?php for ($i = $current_year; $i > 2011; $i--): ?>
	                        <option value="<?=$i?>"><?= $i?></option>
	                    <?php endfor?>
					</select>
					<span class="input-group-btn">
						<button type="button" class="btn btn-primary btn-hover">Go</button>
					</span>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<br>
		<h4 class="text-center">PERCENTAGE OF COUPLES ENCODED FOR YEAR <?= $current_year; ?></h4>
		<div id="graph"></div>
	</div>
</div>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script>
    Morris.Bar({
		element: 'graph',
		data: [
			{ region: 'R1', 	value: 3.57 },
		    { region: 'R2', 	value: 55.73 },
		    { region: 'R3', 	value: 69.8 },
		    { region: 'R4A', 	value: 14.91 },
		    { region: 'R4B', 	value: 5.19 },
		    { region: 'R5', 	value: 24.81 },
		    { region: 'R6', 	value: 16.45 },
		    { region: 'R7', 	value: 35.66 },
		    { region: 'R8', 	value: 44.56 },
		    { region: 'R9', 	value: 56.95 },
		    { region: 'R10', 	value: 40.48 },
		    { region: 'R11', 	value: 11.08 },
		    { region: 'R12', 	value: 51.43 },
		    { region: 'ARMM', 	value: 19.69 },
		    { region: 'CAR', 	value: 49.12 },
		    { region: 'CARAGA', value: 28.17 },
		    { region: 'NCR', 	value: 42.48 }
		],
		xkey: 'region',
		ykeys: ['value'],
		labels: ['value'],
		barColors: ['#2a3e53'],
		xLabelMargin: 10
    });
</script>