/* ==========================================================================
	Setup
   ========================================================================== */

var isSingle = ( jQuery("body").hasClass("single") ) ? true : false,
	isGrid = ( jQuery("main").hasClass("grid") === true ) ? true : false,
	isPaged = jQuery("body").hasClass("paged");

// wp_data object
var homeUrl = wp_data.home_url,
	themeDir = wp_data.theme_dir,
	imgDir = wp_data.img_dir;

var isFrontPage = ( jQuery("body").hasClass("front-page") === true ) ? true : false;
var isMobile = ( jQuery("body").hasClass("mobile") === true ) ? true : false;
var isTablet = ( jQuery("body").hasClass("tablet") === true ) ? true : false;
var isDesktop = ( jQuery("body").hasClass("desktop") === true ) ? true : false;

// Search field globals
var searchW,
	searchPT,
	searchPR,
	searchPL,
	searchB,
	isExpanded;

/* ==========================================================================
	Let "er rip...
   ========================================================================== */

(function($){

	$(document).ready(function(){
		rhdInit();

		// Metabar dropdowns
		$(".rhd-dropdown-title").click(function(e){
			e.preventDefault();

			var $this = $(this),
				$dd = $this.siblings("ul");

			$dd.slideToggle();
		});

		// Navbar search expansion
		isExpanded = false;

		$(window).on("resize", function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
			}
		});
	});


	function rhdInit() {
		wpAdminBarPush();

		/*
		$.slidebars({
			siteClose: false,
		});
		*/

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


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $("#hamburger");

		toggles.click(function(e){
			e.preventDefault();
			$(this).toggleClass("is-active");

			$(".nav-dropdown").slideToggle();
		});
	}


	function resetToggleBurger() {
		$(".nav-dropdown").removeAttr("style");
		$("#hamburger").removeClass("is-active");
	}


	// Faux-flexbox "fix" template (edit for varying column numbers)
	function fixGridLayout() {
		var gridCount = $(".post-grid .post-grid-item").length;

		if ( gridCount % 3 == 2 ) {
			$(".post-grid-item:last-of-type, .post-grid-item:nth-last-of-type(2)").css("float", "left");
			$(".post-grid-item:last-of-type").css("margin-left", "3.5%");
		}
	}


	function expandSearchBar() {
		$("#navbar .widget_rhd_social_icons").fadeOut("fast");

		$(".navbar-search, .navbar-search .search-field, .navbar-search .search-submit").addClass("is-active");

		$(".navbar-search .search-field").focus();

		$(".close-search").fadeIn("fast");

		isExpanded = true;
	}


	function collapseSearchBar() {
		$("#navbar .widget_rhd_social_icons").fadeIn("fast");

		$(".navbar-search, .navbar-search .search-field, .navbar-search .search-submit").removeClass("is-active");

		$(".close-search").fadeOut("fast");
		isExpanded = false;
	}


	function killBlogspotLinks() {
		$(".entry-content img").each(function(){
			var a = $(this).parents("a");
			var link = a.attr("href");

			if ( link.indexOf("blogspot") >= 0 )
				$(this).unwrap("a");
		});
	}
})(jQuery);