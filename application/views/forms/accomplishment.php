<?php
defined('BASEPATH') or exit('No direct script access allowed');
$accomp_no = $this->input->get('ReportNo');
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
				<h3 class=" text-center">ACCOMPLISHMENT REPORT OF RPFP COUPLES PROFILE ENCODED</h3>
			</div>
		</div>		
		<?php if(!$is_pdf) : ?>
		    <div id="rightButton">
	        	<a href="<?= base_url('menu/printAccomplishment?ReportNo='. $accomp_no) ?>" class="save" target="_blank">
                    <span>PRINT</span>
                </a>
		    </div>
	    <?php endif; ?>
        <div class="padding-t20" <?php if(!$is_pdf) : ?>style="margin: 0 10%;"<?php endif; ?>>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed">
        			<thead>
        				<tr>
        					<th class="text-center" style="width: 40%;"><p>RPFP Class Number</p></th>
        					<th class="text-center" style="width: 10%;"><p>Encoded Couples</p></th>
        					<th class="text-center" style="width: 10%;"><p>Approved Couples</p></th>
        					<th class="text-center" style="width: 10%;"><p>Pending Couples</p></th>
        					<th class="text-center" style="width: 10%;"><p>Served Couples</p></th>
        					<th class="text-center" style="width: 10%;"><p>Duplicates</p></th>
        					<th class="text-center" style="width: 10%;"><p>Invalids</p></th>
        				</tr>
        			</thead>
        			<tbody>
						<?php
							$total_class = 0;
							$encoded_couples = 0;
							$approved_couples = 0;
							$pending_couples = 0;
							$served_couples = 0;
							$duplicates = 0;
						foreach ($accomplishment as $accomplished) : ?>
							<tr>
								<td><?= $accomplished->ClassNo ?></td>
								<?php $total_class++ ?>
								<td>
									<?php 
										if($accomplished->EncodedCouples != 'N/A') {
											echo $accomplished->EncodedCouples;
											$encoded_couples+= $accomplished->EncodedCouples;
										} else {
											echo 0;
										}
									?>
								</td>
								<td>
									<?php 
										if($accomplished->ApprovedCouples != 'N/A') {
											echo $accomplished->ApprovedCouples;
											$approved_couples+= $accomplished->ApprovedCouples; 
										} else {
											echo 0;
										}
									?>
								</td>
								<td>
									<?php 
										if($accomplished->PendingCouples != 'N/A') {
											echo $accomplished->PendingCouples;
											$pending_couples+= $accomplished->PendingCouples; 
										} else {
											echo 0;
										}
									?>
								</td>
								<td>
									<?php 
										if($accomplished->ServedCouples != 'N/A') {
											echo $accomplished->ServedCouples;
											$served_couples+= $accomplished->ServedCouples; 
										} else {
											echo 0;
										}
									?>
								</td>
								<td>
									<?php 
										if($accomplished->Duplicates != 'N/A') {
											echo $accomplished->Duplicates;
											$duplicates+= $accomplished->Duplicates; 
										} else {
											echo 0;
										}
									?>
								</td>
								<td> </td>
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
        							<?= $encoded_couples ?>
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							<?= $approved_couples ?>
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							<?= $pending_couples ?>
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							<?= $served_couples ?>
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							<?= $duplicates ?>
        						</p>
        					</td>
        					<td class="text-center">
        						<p class="text-bold text-italic">
        							
        						</p>
        					</td>
        				</tr>
        				<tr>
        					<td colspan="1" class="text-center" style="border-right: 0;">
        						<p class="text-bold">TOTAL <br> (Classes)</p>
        					</td>
        					<td style="border-right: 0; border-left: 0;"></td>
        					<td colspan="1" class="text-right" style="border-left: 0; padding-right: 4%;">
        						<h4 class="text-bold">
        							<?= $total_class ?>
								</h4>
        					</td>
        					<td colspan="2" class="text-center" style="border-right: 0;">
        						<p class="text-bold">GRAND TOTAL <br> (Approved Couples)</p>
        					</td>
        					<td style="border-right: 0; border-left: 0;"></td>
        					<td colspan="2" class="text-right" style="border-left: 0; padding-right: 4%;">
        						<h4 class="text-bold">
        							<?= $approved_couples ?>
								</h4>
        					</td>
        				</tr>
        			</tfoot>
        		</table>
			</div>
			<div class="text-right">
				<p><?= date('M d, Y h:sa')?></p>
			</div>
        </div>
    </div>
</div>