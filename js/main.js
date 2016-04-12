var mobileW = 640;


/* ==========================================================================
	Let 'er rip...
   ========================================================================== */

(function($){
	$(document).ready(function(){
		rhdInit();

		$(window).on('resize', function(){
			if ( !windowIsMobile() ) {
				if ($(".c-hamburger").is('.is-active')) {
					$(".c-hamburger").removeClass('is-active');
				}
			} else {
				$$('#site-navigation-container').slideUp(0);
			}
		});
	});


	function rhdInit() {
		toggleBurger();
		fixGridLayout();
	}


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $(".c-hamburger");

		toggles.on( 'click', function(e){
			e.preventDefault();
			$(this).toggleClass('is-active');
			$('#site-navigation-container').slideToggle();
		});
	}


	// Faux-flexbox "fix" template (edit for varying column numbers)
	function fixGridLayout() {
		var gridCount = $('.post-grid .post-grid-item').length;

		if ( gridCount % 3 == 2 ) {
			$('.post-grid-item:last-of-type, .post-grid-item:nth-last-of-type(2)').css('float', 'left');
			$('.post-grid-item:last-of-type').css('margin-left', '3.5%');
		}
	}


	function windowIsMobile() {
		return $(window).width() <= mobileW ? true : false;
	}

})(jQuery);
