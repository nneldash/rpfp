<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
?>


<div class="body-padding">
	<div class="row">
		<div class="col-md-12">
			<form id="form1" runat="server" class="form-horizontal">
				<input type="file" id="excelfile" />
				<br>
    			<input class="save" type="button" id="viewfile" value="Export To Table" onclick="ExportToTable()" />
				<table id="exceltable">
    			</table>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/importExcel.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>