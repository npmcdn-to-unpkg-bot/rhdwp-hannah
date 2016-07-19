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


/* ==========================================================================
	Globals
   ========================================================================== */

function initPackery() {
	$packery = jQuery(".post-grid.packery").packery({
		initLayout: false,
		percentPosition: true,
		columnWidth: '.post-grid-sizer',
		gutter: '.post-gutter-sizer',
		itemSelector: '.post-grid-item'
	});

	return $packery;
}

// Empty var for global Packery instance
var $grid;


/* ==========================================================================
	Let "er rip...
   ========================================================================== */

(function($){

	$(document).ready(function(){
		rhdInit();

		$(window).on("resize", function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
				rhdInstagramFooterResize();
				rhdFeaturedHeight();
			}
		});
	});


	function rhdInit() {
		$grid = initPackery();

		toggleBurger();
		headerSearch();
		fixGridLayout();
		wpAdminBarPush();
		layoutPackery();
		rhdFeaturedHeight();

		if ( !viewportIsSmall() ) {
			rhdFeaturedHeight();
			rhdInstagramFooterResize();
		}
	}


	function wpAdminBarPush() {
		if ( $("#navbar").css("position") == "fixed" ) {
			$("#wpadminbar").css({
				top: $("#navbar").height(),
			});
		}
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


	function layoutPackery() {
		$grid.imagesLoaded().progress(function(){
			$grid.packery();
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


	function rhdFeaturedHeight() {
		var newHt = $(".featured-links").height();
		$("#featured-content .soliloquy-item").imagesLoaded(function(){
			$("#featured-content .soliloquy-viewport").height(newHt);
		});
	}


	function rhdInstagramFooterResize() {
		var sliderHt;

		$("#footer-widget-area .soliloquy .soliloquy-slider .soliloquy-image-slide").imagesLoaded(function(){
			sliderHt = $("#footer-widget-area .soliloquy .soliloquy-slider").height();
			$("#footer-widget-area .widget_sp_image").height(sliderHt);
		});
	}


	function headerSearch() {
		$(".navbar-search .search-submit").click(function(e){
			e.preventDefault();

			if ( !$(".navbar-search").data("expanded") ) {
				expandSearchBar();
			} else {
				// Check that input isn"t just whitespace
				var searchStr = $(".navbar-search .search-field").val().replace(/^\s+/, "").replace(/\s+$/, "");

				if ( searchStr === "" ) {
					collapseSearchBar();
				} else {
					// Run the search
					$(".navbar-search form").submit();
				}
			}
		});

		// Close header search by clicking "X," clicking away from #navbar, or hitting the ESC key
		$(".close-search").click(function(e){
			e.preventDefault();
			collapseSearchBar();
		});

		$(document).keyup(function(e) {
			if ( e.keyCode == 27 && $(".navbar-search").data("expanded", true) ) {
				collapseSearchBar();
			}
		});

		$(document).mouseup(function(e){
			var $container = $(".navbar-search");

			if (!$container.is(e.target) && $container.has(e.target).length === 0) {
				collapseSearchBar();
			}
		});
	}


	function expandSearchBar() {
		$(".navbar-search").css("zIndex", 999);

		if ( !viewportIsSmall() ) {
			$("#navbar").addClass("search-is-active");
			$("#site-navigation-container").animate({opacity: 0.1}, "fast");
		}

		$(".navbar-search .search-submit, .navbar-search .search-field").addClass("is-active");
		$(".navbar-search .search-field").focus();
		$(".navbar-search").data("expanded", true);

		$(".close-search").fadeIn("fast");
	}


	function collapseSearchBar() {
		if ( !viewportIsSmall() ) {
			$("#navbar").removeClass("search-is-active");
			$("#site-navigation-container").animate({opacity: 1});
		}

		$(".navbar-search .search-submit, .navbar-search .search-field").removeClass("is-active");
		$(".navbar-search")
			.css("zIndex", 0)
			.data("expanded", false);

		$(".close-search").fadeOut("fast");
	}

})(jQuery);