(function($){
	$(document).ready(function(){
		if ( wp_data.parallax === true ) {
			parallax = new Scrollax().init();
		}
	});
})(jQuery);