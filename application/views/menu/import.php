
<div hidden id="drop"></div>
<input type="file" name="xlfile" id="xlf" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
<br>
<progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
<h5 class="text-center" id="status"></h5>
<p id="loaded_n_total" hidden></p>

<textarea hidden id="b64data"></textarea>
<input hidden type="button" id="dotext" value="" onclick="b64it();"/><br />
<b hidden></b>
<input hidden type="checkbox" name="useworker" checked>
<input hidden type="checkbox" name="userabs" checked>

<div id="out" hidden></div>
<div id="htmlout" hidden></div>

<style>
    .waiting {
        cursor: wait!important;
    }
</style>
<script>
    loadJs(base_url + '/NewAssets/cpExcel', function() {
        loadJs(base_url + '/NewAssets/shimJs', function() {
            loadJs(base_url + '/NewAssets/jsZip', function() {
                loadJs(base_url + '/NewAssets/xlsxJs', function() {
                    loadJs(base_url + '/assets/js/import.js');
                });
            });
        });
    });

    $('#xlf').attr('disabled', true);	
	var xlf = $('#xlf').attr('disabled', true);
    xlf.addClass('waiting');
	setTimeout(function(){
	    xlf.attr('disabled', false);
        xlf.removeClass('waiting');
	}, 3000);
</script>
