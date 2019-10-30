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
	        	<a href="<?= base_url('menu/printSummary') ?>" class="save" target="_blank">
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
        				<tr>
        					<td style="padding-left: 10px;">
        						4PS-BUL-ORMIN-19-04-5112
        					</td>
        					<td style="padding-right: 10px;" class="text-right">151</td>
        					<td style="padding-right: 10px;" class="text-right">149</td>
        					<td style="padding-right: 10px;" class="text-right">2</td>
        					<td style="padding-right: 10px;" class="text-right">58</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">H2H-BAN-ROM-19-04-5113</td>
        					<td style="padding-right: 10px;" class="text-right">33</td>
        					<td style="padding-right: 10px;" class="text-right">33</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-CAL-ORMIN-19-06-5114</td>
        					<td style="padding-right: 10px;" class="text-right">28</td>
        					<td style="padding-right: 10px;" class="text-right">28</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">H2H-SJOSE-OCCI-19-01-5115</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">H2H-SJOSE-OCCI-19-02-5116</td>
        					<td style="padding-right: 10px;" class="text-right">16</td>
        					<td style="padding-right: 10px;" class="text-right">16</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">H2H-SJOSE-OCCI-19-03-5117</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">H2H-SJOSE-OCCI-19-04-5118</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-RIZ-OCCI-19-01-5119</td>
        					<td style="padding-right: 10px;" class="text-right">14</td>
        					<td style="padding-right: 10px;" class="text-right">14</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-RIZ-OCCI-19-02-5120</td>
        					<td style="padding-right: 10px;" class="text-right">20</td>
        					<td style="padding-right: 10px;" class="text-right">20</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-RIZ-OCCI-19-03-5121</td>
        					<td style="padding-right: 10px;" class="text-right">13</td>
        					<td style="padding-right: 10px;" class="text-right">13</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-RIZ-OCCI-19-04-5122</td>
        					<td style="padding-right: 10px;" class="text-right">14</td>
        					<td style="padding-right: 10px;" class="text-right">14</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-RIZ-OCCI-19-05-5123</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-RIZ-OCCI-19-06-5124</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">4PS-MAG-OCCI-19-07-5125</td>
        					<td style="padding-right: 10px;" class="text-right">58</td>
        					<td style="padding-right: 10px;" class="text-right">57</td>
        					<td style="padding-right: 10px;" class="text-right">1</td>
        					<td style="padding-right: 10px;" class="text-right">1</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">4PS-MAG-OCCI-19-07-5126</td>
        					<td style="padding-right: 10px;" class="text-right">100</td>
        					<td style="padding-right: 10px;" class="text-right">100</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">47</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">4PS-MAG-OCCI-19-07-5127</td>
        					<td style="padding-right: 10px;" class="text-right">167</td>
        					<td style="padding-right: 10px;" class="text-right">164</td>
        					<td style="padding-right: 10px;" class="text-right">3</td>
        					<td style="padding-right: 10px;" class="text-right">42</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-MOG-MAR-19-06-5128</td>
        					<td style="padding-right: 10px;" class="text-right">34</td>
        					<td style="padding-right: 10px;" class="text-right">34</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">3</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">4PS-MOG-MAR-19-06-5129</td>
        					<td style="padding-right: 10px;" class="text-right">36</td>
        					<td style="padding-right: 10px;" class="text-right">36</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">5</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-MOG-MAR-19-07-5130</td>
        					<td style="padding-right: 10px;" class="text-right">36</td>
        					<td style="padding-right: 10px;" class="text-right">36</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-MOG-MAR-19-07-5131</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-MOG-MAR-19-06-5132</td>
        					<td style="padding-right: 10px;" class="text-right">22</td>
        					<td style="padding-right: 10px;" class="text-right">22</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">H2H-BOAC-MAR-19-06-5133</td>
        					<td style="padding-right: 10px;" class="text-right">15</td>
        					<td style="padding-right: 10px;" class="text-right">15</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">PMC-BOAC-MAR-19-07-5134</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">9</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-BUEN-MAR-19-06-5135</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-BUEN-MAR-19-05-5136</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">10</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-BOAC-MAR-19-07-5137</td>
        					<td style="padding-right: 10px;" class="text-right">19</td>
        					<td style="padding-right: 10px;" class="text-right">19</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
        				<tr>
        					<td style="padding-left: 10px;">N4PS-BOAC-MAR-19-06-5138</td>
        					<td style="padding-right: 10px;" class="text-right">12</td>
        					<td style="padding-right: 10px;" class="text-right">12</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        					<td style="padding-right: 10px;" class="text-right">0</td>
        				</tr>
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