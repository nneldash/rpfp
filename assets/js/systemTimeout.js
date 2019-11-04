
$(document).ready(function() {
	set_timer();
	$('body').attr('onmousemove', 'reset_timer()');
	$('body').attr('onclick', 'reset_timer()');
	$('body').attr('onkeypress', 'reset_timer()');
	$('body').attr('onscroll', 'reset_timer()');
});

function set_timer() {
	timer = setTimeout(auto_logout, 1800000);
}

function reset_timer() {
	if (timer != 0) {
		clearTimeout(timer);
		timer = 0;
		timer = setTimeout(auto_logout, 1800000);
	}
}

function auto_logout() {
	window.location.href = base_url + '/login/logoffSystem?timeout=1';
}
