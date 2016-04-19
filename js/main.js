/* ==========================================================================
	Setup
   ========================================================================== */

var $window = jQuery(window),
	$body = jQuery('body'),
	$main = jQuery('#main');

var isSingle = ( $body.hasClass('single') ) ? true : false,
	isGrid = ( $main.hasClass('grid') === true ) ? true : false,
	isPaged = $body.hasClass('paged');

// wp_data object
var homeUrl = wp_data.home_url,
	themeDir = wp_data.theme_dir,
	imgDir = wp_data.img_dir;

var isFrontPage = ( $body.hasClass('front-page') === true ) ? true : false;
var isMobile = ( $body.hasClass('mobile') === true ) ? true : false;
var isTablet = ( $body.hasClass('tablet') === true ) ? true : false;
var isDesktop = ( $body.hasClass('desktop') === true ) ? true : false;


/* ==========================================================================
	Let 'er rip...
   ========================================================================== */

(function($){

	$(document).ready(function(){
		rhdInit();
	});


	function rhdInit() {
		// wpAdminBarPush();

		toggleBurger();
		fixGridLayout();
	}


	function wpAdminBarPush() {
		$("#wpadminbar").css({
			top: $("#masthead").height(),
		});
	}


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $(".c-hamburger"),
			$nav = $("#site-navigation-container");

		$nav.data('height', $nav.height()+"px");
		$nav.css('height', '0');

		toggles.on( 'click', function(e){
			e.preventDefault();
			var $this = $(this);
			$this.toggleClass('is-active');

			if ( $this.hasClass('is-active') )
				$nav.animate({
					height: $nav.data('height')
				}, 'slow', 'swing');
			else
				$nav.animate({
					height: '0'
				}, 'slow', 'swing');
		});
	}


	// Faux-flexbox "fix" template (edit for varying column numbers)
	function fixGridLayout() {
		var gridCount = $('.projects-grid .projects-grid-item').length;

		if ( gridCount % 3 == 2 ) {
			$('.projects-grid-item:last-of-type, .projects-grid-item:nth-last-of-type(2)').css('float', 'left');
			$('.projects-grid-item:last-of-type').css('margin-left', '0.5%');
		}
	}

})(jQuery);
