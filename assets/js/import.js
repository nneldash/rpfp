var base_url = window.location.origin + '/rpfp/';
var XLSX = XLSX;
var XW = {
	msg: 'xlsx',
	worker: base_url + 'assets/js/xlsxworker.js'
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

	   	var fourps 	= $.trim(array[101]);
	   	var house 	= $.trim(array[104]);
	   	var faith 	= $.trim(array[117]);
	   	var profile = $.trim(array[120]);
	   	var pmc 	= $.trim(array[133]);
	   	var others 	= $.trim(array[136]);
	   	var usapan 	= $.trim(array[150]);
	    
	    if(fourps.toUpperCase() === 'X')  {
	    	$('#4ps').attr('checked', 'checked');
	    } else if(house.toUpperCase() === 'X') {
			$('#house').attr('checked', 'checked');
	    } else if(faith.toUpperCase() === 'X') {
	    	$('#faith').attr('checked', 'checked');
	    } else if(profile.toUpperCase() === 'X') {
 			$('#profile').attr('checked', 'checked');
	    } else if(pmc.toUpperCase() === 'X') {
	    	$('#pmc').attr('checked', 'checked');
	    } else if(others.toUpperCase() === 'X') {
	    	$('#others').attr('checked', 'checked');
	    	$('input[name="others"]').attr('disabled', false);
	    	$('input[name="others"]').val(array[140]);
	    } else if(usapan.toUpperCase() === 'X') {
			$('#usapan').attr('checked', 'checked');
	    } else {
	    	$('#4ps').attr('checked', false);
			$('#house').attr('checked', false);
	    	$('#faith').attr('checked', false);
 			$('#profile').attr('checked', false);
	    	$('#pmc').attr('checked', false);
	    	$('#others').attr('checked', false);
			$('#usapan').attr('checked', false);
	    }

	    $('input[name=class_no]').val(array[112]);

	    var barangay = array[145];
	    getFullLocation(barangay);

	    var now = new Date(array[161]);
		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);

		var date_conducted = now.getFullYear()+"-"+(month)+"-"+(day);

	    $('input[name=date_conducted]').val(date_conducted);
	    $('input[name=prepared_by]').val(array[790]);
	    $('input[name=reviewed_by]').val(array[795]);
	    $('input[name=approved_by]').val(array[801]);

	    var i;
	    var inc = 38;
	    var a = 248;
	    var b = 267;

		for (i = 0; i < 10; i++) {
			var fname1 = array[a].split('"');
			var ename1 = array[a+3].split('"');

			var fname2 = array[b].split('"');
			var ename2 = array[b+3].split('"');

			var bdayAge1 = array[a+7].split(' ');
			var age1 = bdayAge1[1];

			var bday1 = bdayAge1[0].split('/');
			var bday1 = bday1[0]+bday1[1]+bday1[2];

			var bdayAge2 = array[b+7].split(' ');
			var age2 = bdayAge2[1];
			
			var bday2 = bdayAge2[0].split('/');
			var bday2 = bday2[0]+bday2[1]+bday2[2];

			var addHHN = array[a+8].split('/');
			var address = addHHN[0].split('_');

			var addHHN = addHHN[1].split(' ');

			$('textarea[name="firstname1['+ i +']"').val(fname1[1]);
			$('textarea[name="middlename1['+ i +']"').val(array[a+1]);
			$('textarea[name="lastname1['+ i +']"').val(array[a+2]);
			$('input[name="extname1['+ i +']"').val(ename1[0]);
			
		    $('input[name="sex1['+ i +']"').val(array[a+5]);
		    $('input[name="civil_status1['+ i +']"').val(array[a+6]);
		    $('input[name="bday1['+ i +']"').val(bday1);
		    $('input[name="age1['+ i +']"').val(age1);

		    $('input[name="house_no_st['+ i +']"').val(address[0]);
		    $('input[name="brgy['+ i +']"').val(address[1]);
		    $('input[name="city['+ i +']"').val(address[2]);
		    $('input[name="household_id['+ i +']"').val(addHHN[1]);

		    $('input[name="educ1['+ i +']"').val(array[a+9]);

		    $('input[name="no_of_children['+ i +']"').val(array[a+10]);
		    $('input[name="method['+ i +']"').val(array[a+11]);
		    $('input[name="fp_method['+ i +']"').val(array[a+12]);
		    $('input[name="type['+ i +']"').val(array[a+13]);
		    $('input[name="status['+ i +']"').val(array[a+14]);
		    $('input[name="reason['+ i +']"').val(array[a+15]);

	    	if(array[a+16] !== '') {
	    		$('input[name="attendee1['+ i +']"').prop('checked', true);
	    	} else {
	    		$('input[name="attendee1['+ i +']"').prop('checked', false);
	    	}

	    	$('textarea[name="firstname2['+ i +']"').val(fname2[1]);
			$('textarea[name="middlename2['+ i +']"').val(array[b+1]);
			$('textarea[name="lastname2['+ i +']"').val(array[b+2]);
			$('input[name="extname2['+ i +']"').val(ename2[0]);

		    $('input[name="sex2['+ i +']"').val(array[b+5]);
		    $('input[name="civil_status2['+ i +']"').val(array[b+6]);
		    $('input[name="bday2['+ i +']"').val(bday2);
		    $('input[name="age2['+ i +']"').val(age2);
		    $('input[name="educ2['+ i +']"').val(array[b+9]);
		    $('input[name="intention_use['+ i +']"').val(array[b+14]);

	    	if(array[b+16] !== '') {
	    		$('input[name="attendee2['+ i +']"').prop('checked', true);
	    	} else {
	    		$('input[name="attendee2['+ i +']"').prop('checked', false);
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

	uploadFile();
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
}

function uploadFile() {
	$('#xlf').change(function(){
		var file = _("xlf").files[0];
		var formdata = new FormData();
		formdata.append("xlf", file);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.open("POST", "");
		ajax.send(formdata);
	});
}

function progressHandler(event) {
	_("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function getFullLocation(barangay)
{
	$.ajax({
		type: 'POST',
		cache: true,
		url: base_url + 'location/getFullLocation',
		data: {
			'barangay' : barangay
		}
	}).done(function(result) {
		$('input[name="province"]').val(result.ProvinceCode);
		$('input[name="city"]').val(result.CityCode);
		$('input[name="barangay"]').val(result.BarangayCode);
	});
}