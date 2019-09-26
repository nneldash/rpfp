var base_url = window.location.origin + '/rpfp';
$(function() {
  	checkbox();
});

function checkbox()
{
	if ($('.no4-check').is(':checked')) {
		$('.no4-input').removeAttr('disabled');
		$('.no5-input').attr('disabled', 'disabled');
	} else {
		$('.no4-input').attr('disabled', 'disabled');
	}

	$('input[type=radio]').click(function(){
		if ($('.no4-check').is(':checked')) {
			$('.no4-input').removeAttr('disabled');
		} else {
			$('.no4-input').attr('disabled', 'disabled');
			$(".no4-input").val("");
		}
		
		$('.no5-input').attr('disabled', 'disabled');
		$(".no5-input").val("");
	});
}