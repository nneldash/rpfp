<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php if ($is_pdf): ?>
	<link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">

	<style>
		@page {
			margin: 5% 10% 0;
		}
		thead, tfoot {
			background: #5981ad;
		    color: #fff;
		}
		tfoot {
		    font-style: italic;
		    font-weight: bold;
		}
	</style>
<?php endif; ?>
	
<link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/form.css') ?>" rel="stylesheet">

<div class="right_col" role="main">
	<div class="clearfix"></div>
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        	<div class="x_panel">
              	<div class="x_content">
              		<div class="container">              			
	              		<?php if (!$is_pdf): ?>
		              		<div id="rightButton">
			        			<a href="<?= base_url('menu/printSummary') ?>" class="save" target="_blank">
			                        <span>PRINT</span>
			                    </a>
							</div>
						<?php endif; ?>
			        	<h5 class=" text-center">ACCOMPLISHMENT REPORT OF RPFP COUPLES PROFILE ENCODED</h5>
			        	<div class="table-responsive">
			        		<table class="table table-bordered table-condensed">
			        			<thead style="background-color: #5981ad;">
			        				<tr>
			        					<th class="text-center">RPFP Class Number</th>
			        					<th class="text-center">Encoded Couples</th>
			        					<th class="text-center">Approved Couples</th>
			        					<th class="text-center">Duplicates</th>
			        					<th class="text-center">Invalids</th>
			        				</tr>
			        			</thead>
			        			<tbody>
			        				<tr>
			        					<td>4PS-BUL-ORMIN-19-04-5112</td>
			        					<td class="text-right">151</td>
			        					<td class="text-right">149</td>
			        					<td class="text-right">2</td>
			        					<td class="text-right">58</td>
			        				</tr>
			        				<tr>
			        					<td>H2H-BAN-ROM-19-04-5113</td>
			        					<td class="text-right">33</td>
			        					<td class="text-right">33</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-CAL-ORMIN-19-06-5114</td>
			        					<td class="text-right">28</td>
			        					<td class="text-right">28</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>H2H-SJOSE-OCCI-19-01-5115</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>H2H-SJOSE-OCCI-19-02-5116</td>
			        					<td class="text-right">16</td>
			        					<td class="text-right">16</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>H2H-SJOSE-OCCI-19-03-5117</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>H2H-SJOSE-OCCI-19-04-5118</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-RIZ-OCCI-19-01-5119</td>
			        					<td class="text-right">14</td>
			        					<td class="text-right">14</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<!-- <tr>
			        					<td>N4PS-RIZ-OCCI-19-02-5120</td>
			        					<td class="text-right">20</td>
			        					<td class="text-right">20</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-RIZ-OCCI-19-03-5121</td>
			        					<td class="text-right">13</td>
			        					<td class="text-right">13</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-RIZ-OCCI-19-04-5122</td>
			        					<td class="text-right">14</td>
			        					<td class="text-right">14</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-RIZ-OCCI-19-05-5123</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-RIZ-OCCI-19-06-5124</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>4PS-MAG-OCCI-19-07-5125</td>
			        					<td class="text-right">58</td>
			        					<td class="text-right">57</td>
			        					<td class="text-right">1</td>
			        					<td class="text-right">1</td>
			        				</tr>
			        				<tr>
			        					<td>4PS-MAG-OCCI-19-07-5126</td>
			        					<td class="text-right">100</td>
			        					<td class="text-right">100</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">47</td>
			        				</tr>
			        				<tr>
			        					<td>4PS-MAG-OCCI-19-07-5127</td>
			        					<td class="text-right">167</td>
			        					<td class="text-right">164</td>
			        					<td class="text-right">3</td>
			        					<td class="text-right">42</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-MOG-MAR-19-06-5128</td>
			        					<td class="text-right">34</td>
			        					<td class="text-right">34</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">3</td>
			        				</tr>
			        				<tr>
			        					<td>4PS-MOG-MAR-19-06-5129</td>
			        					<td class="text-right">36</td>
			        					<td class="text-right">36</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">5</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-MOG-MAR-19-07-5130</td>
			        					<td class="text-right">36</td>
			        					<td class="text-right">36</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-MOG-MAR-19-07-5131</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-MOG-MAR-19-06-5132</td>
			        					<td class="text-right">22</td>
			        					<td class="text-right">22</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>H2H-BOAC-MAR-19-06-5133</td>
			        					<td class="text-right">15</td>
			        					<td class="text-right">15</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>PMC-BOAC-MAR-19-07-5134</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">9</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-BUEN-MAR-19-06-5135</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-BUEN-MAR-19-05-5136</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">10</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-BOAC-MAR-19-07-5137</td>
			        					<td class="text-right">19</td>
			        					<td class="text-right">19</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr>
			        				<tr>
			        					<td>N4PS-BOAC-MAR-19-06-5138</td>
			        					<td class="text-right">12</td>
			        					<td class="text-right">12</td>
			        					<td class="text-right">0</td>
			        					<td class="text-right">0</td>
			        				</tr> -->
			        			</tbody>
			        			<tfoot>
			        				<tr>
			        					<td class="text-center"><b><i>Sub-total</i></b></td>
			        					<td class="text-center"><b><i>873</i></b></td>
			        					<td class="text-center"><b><i>867</i></b></td>
			        					<td class="text-center"><b><i>6</i></b></td>
			        					<td class="text-center"><b><i>156</i></b></td>
			        				</tr>
			        				<tr>
			        					<td colspan="3" class="text-center" style="border-right: 0;">
			        						<b>GRAND TOTAL <br> (Approved Couples)</b>
			        					</td>
			        					<td colspan="2" class="text-right" style="border-left: 0; padding-right: 4%;">
			        						<h4><b>867</b></h4>
			        					</td>
			        				</tr>
			        			</tfoot>
			        		</table>
			        	</div>
              		</div>
		        </div>
		    </div>
		</div>
	</div>
</div>

