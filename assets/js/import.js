var base_url = window.location.origin + '/rpfp';
var XLSX = XLSX;
var XW = {
	msg: 'xlsx',
	worker: base_url + '/node_modules/xlsx/xlsxworker.js'
};

var global_wb;

var process_wb = (function() {
	var OUT = document.getElementById('out');
	var HTMLOUT = document.getElementById('htmlout');

	var get_format = (function() {
		var radios = "csv";
		return function() {
			for(var i = 0; i < radios.length; ++i) if(radios[i].checked || radios.length === 1) return radios[i].value;
		};
	})();

	var to_csv = function to_csv(workbook) {
		var result = [];
		workbook.SheetNames.forEach(function(sheetName) {
			var csv = XLSX.utils.sheet_to_csv(workbook.Sheets[sheetName]);
			if(csv.length){
				result.push("");
				result.push(csv);
			}
		});
		return result.join("\n");
	};

	return function process_wb(wb) {
		global_wb = wb;
		var output = "";
		switch(get_format()) {
			case "form": output = to_fmla(wb); break;
			case "html": output = to_html(wb); break;
			case "json": output = to_json(wb); break;
			default: output = to_csv(wb);
		}

		var str = output;
	    var array = str.split(",");

	    $('#importModal').modal('hide');

	    if(typeof array[101] !== '') $('#4ps').prop('checked', true);
	    if(typeof array[104] !== '') $('#house').prop('checked', true);
	    if(typeof array[117] !== '') $('#faith').prop('checked', true);
	    if(typeof array[120] !== '') $('#profile').prop('checked', true);
	    if(typeof array[133] !== '') $('#pmc').prop('checked', true);
	    if(typeof array[136] !== '') $('#others').prop('checked', true);
	   	if(typeof array[150] !== '') $('#usapan').prop('checked', true);

	   	if(typeof array[101] === '') $('#4ps').prop('checked', false);
	    if(typeof array[104] === '') $('#house').prop('checked', false);
	    if(typeof array[117] === '') $('#faith').prop('checked', false);
	    if(typeof array[120] === '') $('#profile').prop('checked', false);
	    if(typeof array[133] === '') $('#pmc').prop('checked', false);
	    if(typeof array[136] === '') $('#others').prop('checked', false);
	   	if(typeof array[150] === '') $('#usapan').prop('checked', false);
	    
	  //   if(array[101] !== '')  {
	  //   	$('#4ps').prop('checked', true);
	  //   } else if(array[104] !== '') {
			// $('#house').prop('checked', true);
	  //   } else if(array[117] !== '') {
	  //   	$('#faith').prop('checked', true);
	  //   } else if(array[120] !== '') {
 		// 	$('#profile').prop('checked', true);
	  //   } else if(array[133] !== '') {
	  //   	$('#pmc').prop('checked', true);
	  //   } else if(array[136] !== '') {
	  //   	$('#others').prop('checked', true);
	  //   } else if(array[150] !== '') {
			// $('#usapan').prop('checked', true);
	  //   } else {
	  //   	$('#4ps').prop('checked', false);
			// $('#house').prop('checked', false);
	  //   	$('#faith').prop('checked', false);
 		// 	$('#profile').prop('checked', false);
	  //   	$('#pmc').prop('checked', false);
	  //   	$('#others').prop('checked', false);
			// $('#usapan').prop('checked', false);
	  //   }

	    $('input[name=class_no]').val(array[112]);
	    $('input[name=province]').val(array[128]);
	    $('input[name=barangay]').val(array[145]);



	    $('input[name=date_conducted]').val('2019-02-11');


	    var i;
	    var inc = 32;
	    var a = 248;
	    var b = 264;

		for (i = 0; i < 10; i++) {
		    $('input[name="name_participant1['+ i +']"').val(array[a]);
		    $('input[name="sex1['+ i +']"').val(array[a+2]);
		    $('input[name="civil_status1['+ i +']"').val(array[a+3]);
		    $('input[name="age1['+ i +']"').val(array[a+4]);
		    $('input[name="address['+ i +']"').val(array[a+5]);
		    $('input[name="educ1['+ i +']"').val(array[a+6]);


		    $('input[name="no_of_children['+ i +']"').val(array[a+7]);
		    $('input[name="method['+ i +']"').val(array[a+8]);
		    $('input[name="fp_method['+ i +']"').val(array[a+9]);
		    $('input[name="type['+ i +']"').val(array[a+10]);
		    $('input[name="status['+ i +']"').val(array[a+11]);
		    $('input[name="reason['+ i +']"').val(array[a+12]);

	    	if(array[a+13] !== '') {
	    		$('input[name="type['+ i +']"').prop('checked', true);
	    	} else {
	    		$('input[name="type['+ i +']"').prop('checked', false);
	    	}

	    	$('input[name="name_participant2['+ i +']"').val(array[b]);
		    $('input[name="sex2['+ i +']"').val(array[b+2]);
		    $('input[name="civil_status2['+ i +']"').val(array[b+3]);
		    $('input[name="age2['+ i +']"').val(array[b+4]);
		    $('input[name="educ2['+ i +']"').val(array[b+6]);

	    	if(array[b+13] !== '') {
	    		$('input[name="type2['+ i +']"').prop('checked', true);
	    	} else {
	    		$('input[name="type2['+ i +']"').prop('checked', false);
	    	}

	    	var a = a + inc;
	    	var b = b + inc;
		}

		if(OUT.innerText === undefined) OUT.textContent = output;
		else OUT.innerText = output;
		if(typeof console !== 'undefined') console.log("output", new Date());
	};
})();

var setfmt = window.setfmt = function setfmt() { if(global_wb) process_wb(global_wb); };

var do_file = (function() {
	var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;
	var domrabs = document.getElementsByName("userabs")[0];
	if(!rABS) domrabs.disabled = !(domrabs.checked = false);

	var use_worker = typeof Worker !== 'undefined';
	var domwork = document.getElementsByName("useworker")[0];
	if(!use_worker) domwork.disabled = !(domwork.checked = false);

	var xw = function xw(data, cb) {
		var worker = new Worker(XW.worker);
		worker.onmessage = function(e) {
			switch(e.data.t) {
				case 'ready': break;
				case 'e': console.error(e.data.d); break;
				case XW.msg: cb(JSON.parse(e.data.d)); break;
			}
		};
		worker.postMessage({d:data,b:rABS?'binary':'array'});
	};

	return function do_file(files) {
		rABS = domrabs.checked;
		use_worker = domwork.checked;
		var f = files[0];
		var reader = new FileReader();
		reader.onload = function(e) {
			if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
			var data = e.target.result;
			if(!rABS) data = new Uint8Array(data);
			if(use_worker) xw(data, process_wb);
			else process_wb(XLSX.read(data, {type: rABS ? 'binary' : 'array'}));
		};
		if(rABS) reader.readAsBinaryString(f);
		else reader.readAsArrayBuffer(f);
	};
})();

(function() {
	var drop = document.getElementById('drop');
	if(!drop.addEventListener) return;

	function handleDrop(e) {
		e.stopPropagation();
		e.preventDefault();
		do_file(e.dataTransfer.files);
	}

	function handleDragover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.dataTransfer.dropEffect = 'copy';
	}

	drop.addEventListener('dragenter', handleDragover, false);
	drop.addEventListener('dragover', handleDragover, false);
	drop.addEventListener('drop', handleDrop, false);
})();

(function() {
	var xlf = document.getElementById('xlf');
	if(!xlf.addEventListener) return;
	function handleFile(e) { do_file(e.target.files); }
	xlf.addEventListener('change', handleFile, false);
})();

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36810333-1']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

// UPLOAD LOADER
function _(el) {
	return document.getElementById(el);
	alert(el);
}

function uploadFile() {
	var file = _("xlf").files[0];
	var formdata = new FormData();
	formdata.append("xlf", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.open("POST", "");
	ajax.send(formdata);
}

function progressHandler(event) {
	_("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}
