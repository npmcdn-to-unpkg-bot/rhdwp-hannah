(function($){
	rhdInit();
	
	/* Sub-Menu rollover */
	$("#site-navigation .menu-item-has-children").hover(function(){
		$(this).children(".sub-menu").visibilityToggle();
	});

})(jQuery);