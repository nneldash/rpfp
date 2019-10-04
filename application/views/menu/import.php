
<div hidden id="drop"></div>
<input type="file" name="xlfile" id="xlf" />
<br>
<div class="progress progress_sm">
	<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
</div>

<textarea hidden id="b64data"></textarea>
<input hidden type="button" id="dotext" value="" onclick="b64it();"/><br />
<b hidden></b>
<input hidden type="checkbox" name="useworker" checked>
<input hidden type="checkbox" name="userabs" checked>

<div id="out" hidden></div>
<div id="htmlout" hidden></div>

<script src="<?= base_url('node_modules/xlsx/dist/cpexcel.js'); ?>"></script>
<script src="<?=base_url('node_modules/xlsx/dist/shim.min.js'); ?>"></script>
<script src="<?=base_url('node_modules/xlsx/dist/jszip.js'); ?>"></script>
<script src="<?=base_url('node_modules/xlsx/dist/xlsx.js'); ?>"></script>

<script src="<?=base_url('assets/js/import.js'); ?>"></script>