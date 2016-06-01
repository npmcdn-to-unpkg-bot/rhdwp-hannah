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
		
		// Nav dropdown
		$('#hamburger').click(function(){
			$('#site-navigation-container').slideToggle();
		});
		
		// FitText title
		$("#site-title-large").fitText(0.9);
		
		// Desktop sidebar min height lock
		if ( !viewportIsSmall() )
			sidebarScroll();
		
		$window.scroll(function(){
			if ( !viewportIsSmall() )
				sidebarScroll();
		});
		
		$window.resize(function(){
			if ( !viewportIsSmall() )
				sidebarScroll();
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
	
	
	function sidebarScroll() {
		// Make sure not already at top...
		if ( $window.scrollTop() >= 0 ) {
			$('#secondary').imagesLoaded().done(function(i){
				if ( $('#secondary').height() <= ( $window.scrollTop() + $window.height() ) ) {
					$('#secondary').css({
						position: 'fixed',
						top: $window.height() - $('#secondary').height(),
						left: 0
					});
				} else {
					$('#secondary').removeAttr('style');
				}
				
				if ( $window.height() < ( $('#secondary').height() + 15 ) ) {
					$('#colophon-large').css({
						position: 'relative',
						bottom: '0'
					});
				} else {
					$('#colophon-large').removeAttr('style');
				}
			});
		}
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
