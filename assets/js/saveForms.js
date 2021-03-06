function genForm()
{
	$(window).keydown(function(event){
	    if(event.keyCode == 13) {
			event.preventDefault();
			return false;
	    }
	});

	var formName = $('.formName').val();

	var MY_LINK = '#/Menu/pending';

	if (formName == 'genFormA'){ 
		MY_LINK = '#/Menu/forma';
	} else if (formName == 'genFormB') {
		MY_LINK = '#/Menu/formb';
	} else if (formName == 'genFormC') {
		MY_LINK = '#/Menu/formc';
	} else {
		MY_LINK = '#/Menu/pending';
	}

	$('.genFormSubmit').click(function() {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		var repData = $('form').serialize();
		var validate = checkRequired();

		if (validate == 1) {
			$('.genFormSubmit').attr('hidden', true);
			$('.loading-form').removeAttr('hidden', false);
			$('.loading-form').removeAttr('disabled', false);

			$.ajax({
				type: 'POST',
				data: repData,
				url: base_url + 'FormGeneration/' + formName
			}).done(function(result){
				if(result.is_save == true) {
					Swal.fire({
						type: 'success',
						text: 'Report successfully saved!',
						showCancelButton: false,
						showConfirmButton: true
					});
					$('#generateReportModal').modal('hide');
					reload(MY_LINK);
				} else {
					Toast.fire({
						type: 'error',
						title: 'No data to generate.'
					});
					$('#generateReportModal').modal('hide');
				}
			});
			return false;
		} else {
			Toast.fire({
				type: 'error',
				title: 'Fill the required fields'
			}); 
		}		
	});
}

function reload(MY_LINK)
{
	var active_a = $('ul.nav.side-menu li a[href="' + MY_LINK + '"]')[0];			
	active_a.click();
	var active_li = $(active_a.parentElement);
	active_li.addClass('active');
}

function checkRequired()
{
	var validate = 0;

	$.each($('select, option').filter('[required]'), function(key, value) {
		var item = $(value).val();

		if (item == '') {
			validate = 0;	
		} else {
			validate = 1;
		}
	});
	
	return validate;
}

function enableFields()
{
	$('select[name="repTypeSelect"]').change(function() {
		var repType = $(this).val();

		if (repType == 01) {
			$('.yearSelect').removeAttr('disabled');
			$('.yearSelect').attr('required', true);
			$('.year-label-req').removeAttr('hidden');

			$('.qtrSelect').val('');
			$('.qtrSelect').attr('disabled', true);
			$('.qtrSelect').removeAttr('required');
			$('.qtr-label-req').attr('hidden', true);

			$('.monthSelect').val('');
			$('.monthSelect').attr('disabled', true);
			$('.monthSelect').removeAttr('required');
			$('.month-label-req').attr('hidden', true);

		} else if (repType == 02) {
			$('.yearSelect').removeAttr('disabled');
			$('.yearSelect').attr('required', true);
			$('.year-label-req').removeAttr('hidden');

			$('.qtrSelect').removeAttr('disabled');
			$('.qtrSelect').attr('required', true);
			$('.qtr-label-req').removeAttr('hidden');

			$('.monthSelect').val('');
			$('.monthSelect').attr('disabled', true);
			$('.monthSelect').removeAttr('required');
			$('.month-label-req').attr('hidden', true);

		} else if (repType == 03) {
			$('.yearSelect').removeAttr('disabled');
			$('.yearSelect').attr('required', true);
			$('.year-label-req').removeAttr('hidden');

			$('.monthSelect').removeAttr('disabled');
			$('.monthSelect').attr('required', true);
			$('.month-label-req').removeAttr('hidden');

			$('.qtrSelect').val('');
			$('.qtrSelect').attr('disabled', true);
			$('.qtrSelect').removeAttr('required');
			$('.qtr-label-req').attr('hidden', true);

		} else {
			$('.yearSelect').val('');
			$('.yearSelect').attr('disabled', true);
			$('.yearSelect').removeAttr('required');
			$('.year-label-req').attr('hidden', true);
			
			$('.qtrSelect').val('');
			$('.qtrSelect').attr('disabled', true);
			$('.qtrSelect').removeAttr('required');
			$('.qtr-label-req').attr('hidden', true);

			$('.monthSelect').val('');
			$('.monthSelect').attr('disabled', true);
			$('.monthSelect').removeAttr('required');
			$('.month-label-req').attr('hidden', true);
		}
		
	});
}