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

// Search field globals
var searchW,
	searchPT,
	searchPR,
	searchPL,
	searchB,
	isExpanded;


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


		// Navbar search expansion
		setSearchDefaults();

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


	function setSearchDefaults() {
		searchW = $('#header-search .search-field').width();
		searchPT = $('#header-search .search-field').css('paddingTop');
		searchPR = $('#header-search .search-field').css('paddingRight');
		searchPL = $('#header-search .search-field').css('paddingLeft');
		searchB = $('#header-search .search-field').css('borderWidth');
		$('#header-search .search-field').css({
			width: 0,
			padding: 0,
			borderWidth: 0
		});

		isExpanded = false;
	}


	function expandSearchBar() {
		$('#navbar .widget_rhd_social_icons').fadeOut('fast');

		$('#header-search').css('zIndex', 999);

		$('#header-search .search-field')
			.animate({ borderWidth: searchB }, 100)
			.animate({
				width: searchW,
				paddingTop: searchPT,
				paddingRight: searchPR,
				paddingBottom: searchPT,
				paddingLeft: searchPL
			}, 'fast', 'easeOutExpo', function(){
				isExpanded = true;
				$('.close-search').fadeIn('fast');
			});
	}


	function collapseSearchBar() {
		$('#navbar .widget_rhd_social_icons').fadeIn('fast');

		$('#header-search .search-field').animate({
			width: 0,
			padding: 0,
			borderWidth: 0
		}, 'fast', 'easeOutExpo', function(){
			$('#header-search').css('zIndex', 0);
			isExpanded = false;
			$('.close-search').fadeOut('fast');
		});
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
