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

		// Metabar dropdowns
		$('.rhd-dropdown-title').click(function(e){
			e.preventDefault();

			var $this = $(this),
				$dd = $this.siblings('ul');

			$dd.slideToggle();
		});
		
		// Nav dropdown
		$('#hamburger').click(function(){
			$('#site-navigation-container').slideToggle();
		});
		
		// Desktop sidebar min height lock
		setSidebarMinHt();
		
		$window.resize(function(){
			setSidebarMinHt();
		});
	});


	function rhdInit() {
		toggleBurger();

		// Fix faux-flexbox
		fixGridLayout();
	}


	function wpAdminBarPush() {
		$("#wpadminbar").css({
			top: $("#masthead").height(),
		});
	}
	
	
	function viewportIsSmall() {
		if ( $(window).width() < 640 )
			return true;
		else
			return false;
	}
	
	
	function getSidebarMinHt() {
		var safety = 16; // Added margin
		var h = safety + $('#page-featured-image').height() + parseInt($('#page-featured-image').css('marginBottom')) + $('#page-title-large').height() + $('#colophon-large').height() + parseInt($('#colophon-large').css('marginTop')) + parseInt($('#colophon-large').css('marginBottom'));
		
		return h;
	}
	
	
	function setSidebarMinHt() {
		$('#secondary').css('minHeight', getSidebarMinHt());
	}


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $(".c-hamburger");

		toggles.click(function(e){
			e.preventDefault();
			$(this).toggleClass('is-active');
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
})(jQuery);
