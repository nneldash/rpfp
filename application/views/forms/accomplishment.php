<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php if ($is_pdf): ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
<?php endif; ?>
<style>
	@page {
		margin: 5% 10% 0;
	}
	.table-bordered > tbody > tr > td,
	.table-bordered > thead > tr > th,
	.table-bordered > tfoot > tr > td,
	.table-bordered {
		border: 1px solid #000;
	}
</style>
	
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<div class="body-padding">	
	<div class="container">
		<div class="row">
			<div class="col padding-r3p padding-b8">
				<h5 class=" text-center">ACCOMPLISHMENT REPORT OF RPFP COUPLES PROFILE ENCODED</h5>
			</div>
		</div>		
		<?php if(!$is_pdf) : ?>
		    <div id="rightButton">
	        	<a href="<?= base_url('menu/printAccomplishment') ?>" class="save" target="_blank">
                    <span>PRINT</span>
                </a>
		    </div>
	    <?php endif; ?>
        <div class="padding-t20" <?php if(!$is_pdf) : ?>style="margin: 0 10%;"<?php endif; ?>>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed">
        			<thead>
        				<tr>
        					<th class="text-center" style="width: 30%;"><p>RPFP Class Number</p></th>
        					<th class="text-center" style="width: 20%;"><p>Encoded Couples</p></th>
        					<th class="text-center" style="width: 20%;"><p>Approved Couples</p></th>
        					<th class="text-center" style="width: 20%;"><p>Duplicates</p></th>
        					<th class="text-center" style="width: 20%;"><p>Invalids</p></th>
        				</tr>
        			</thead>
        			<tbody>
						<?php foreach ($accomplishment as $accomplished) : ?>
							<tr>
								<td><?= $accomplished->ReportNo ?></td>
								<td><?= $accomplished->ReportYear ?> - <?php if ($accomplished->ReportMonth != 0) { echo strftime("%b" ,mktime(0,0,0, $accomplished->ReportMonth )); } else { echo $accomplished->ReportMonth; } ?></td>
								<td><?= date('F d, Y', strtotime($accomplished->DateProcessed)); ?></td>
								<td class="text-center">
									<a class="viewForm folderview" href="<?= base_url('forms/accomplishment'); ?>" target="_blank">
									<button class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="View">
										<i class="fa fa-folder-open"></i>
									</button>					
								</td>
							</tr>
						<?php endforeach; ?>
    				</tbody>
        			<tfoot>
        				<tr>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							Sub-total
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							873
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							867
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							6
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							156
        						</p>
        					</td>
        				</tr>
        				<tr>
        					<td colspan="2" class="text-center" style="border-right: 0;">
        						<p class="text-bold">GRAND TOTAL <br> (Approved Couples)</p>
        					</td>
        					<td style="border-right: 0; border-left: 0;"></td>
        					<td colspan="2" class="text-right" style="border-left: 0; padding-right: 4%;">
        						<h4 class="text-bold">867</h4>
        					</td>
        				</tr>
        			</tfoot>
        		</table>
        	</div>
        </div>
    </div>
</div>