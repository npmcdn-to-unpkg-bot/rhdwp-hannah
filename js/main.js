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

		// Navbar search expansion
		isExpanded = false;

		$('#header-search .search-submit').click(function(e){
			if (!isExpanded) {
				e.preventDefault();
				expandSearchBar();
			}
		});

		// Close header search by clicking 'X' or ESC
		$('.close-search').click(function(e){
			e.preventDefault();
			collapseSearchBar();
		});

		$(document).keyup(function(e) {
			if ( e.keyCode == 27 && isExpanded ) {
				collapseSearchBar();
			}
		});

		$(window).on('resize', function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
			}
		});
	});


	function rhdInit() {
		// wpAdminBarPush();

		toggleBurger();

		// Fix faux-flexbox
		fixGridLayout();

		// Disable old blogspot image links
		killBlogspotLinks();
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


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $(".c-hamburger");

		toggles.click(function(e){
			e.preventDefault();
			$(this).toggleClass('is-active');

			$('.nav-dropdown').slideToggle();
		});
	}


	function resetToggleBurger() {
		$('.nav-dropdown').removeAttr('style');
		$("#hamburger").removeClass('is-active');
	}


	// Faux-flexbox "fix" template (edit for varying column numbers)
	function fixGridLayout() {
		var gridCount = $('.post-grid .post-grid-item').length;

		if ( gridCount % 3 == 2 ) {
			$('.post-grid-item:last-of-type, .post-grid-item:nth-last-of-type(2)').css('float', 'left');
			$('.post-grid-item:last-of-type').css('margin-left', '3.5%');
		}
	}


	function expandSearchBar() {
		$('#navbar .widget_rhd_social_icons').fadeOut('fast');

		$('#header-search, #header-search .search-field, #header-search .search-submit').addClass('is-active');

		$('#header-search .search-field').focus();

		$('.close-search').fadeIn('fast');

		isExpanded = true;
	}


	function collapseSearchBar() {
		$('#navbar .widget_rhd_social_icons').fadeIn('fast');

		$('#header-search, #header-search .search-field, #header-search .search-submit').removeClass('is-active');

		$('.close-search').fadeOut('fast');
		isExpanded = false;
	}


	function killBlogspotLinks() {
		$('.entry-content img').each(function(){
			var a = $(this).parents('a');
			var link = a.attr('href');

			if ( link.indexOf('blogspot') >= 0 )
				$(this).unwrap('a');
		});
	}

})(jQuery);
