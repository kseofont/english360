(function ($) {
	$(document).ready(function () {
		const input_reload = $('#lcd-reload'),
			reload_value = input_reload.val();

		if (input_reload.length > 0) {
			if ( 0 < reload_value && reload_value < 2147483647 ) {
				setTimeout( function() {
					window.location.reload( true );
				}, reload_value );
			}
		}
	});

})(jQuery);


