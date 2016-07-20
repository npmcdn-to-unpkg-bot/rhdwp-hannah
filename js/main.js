/* ==========================================================================
	Setup
   ========================================================================== */

var $window = jQuery(window),
	$body = jQuery("body"),
	$main = jQuery("#main");

var isSingle = ( $body.hasClass("single") ) ? true : false,
	isGrid = ( $main.hasClass("grid") === true ) ? true : false,
	isPaged = $body.hasClass("paged");

// wp_data object
var homeUrl = wp_data.home_url,
	themeDir = wp_data.theme_dir,
	imgDir = wp_data.img_dir;

var isFrontPage = ( $body.hasClass("front-page") === true ) ? true : false;
var isMobile = ( $body.hasClass("mobile") === true ) ? true : false;
var isTablet = ( $body.hasClass("tablet") === true ) ? true : false;
var isDesktop = ( $body.hasClass("desktop") === true ) ? true : false;


/* ==========================================================================
	Let "er rip...
   ========================================================================== */

(function($){

	$(document).ready(function(){
		rhdInit();

		$(window).on("resize", function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
			}

			rhdSquarestagram();
		});
	});


	function rhdInit() {
		wpAdminBarPush();

		toggleBurger();
		headerSearch();
		rhdSquarestagram();

		// Fix faux-flexbox
		fixGridLayout( '.post-grid' );
		fixGridLayout( '.archive-grid' );
	}


	function wpAdminBarPush() {
		$("#wpadminbar").css({
			top: $("#masthead").height(),
		});
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
	function fixGridLayout( gridClass ) {
		var across = 4;
		var mLeft = "3.5%";

		$(gridClass).each(function(){
			// Check for multiple grids on a page using IDs
			var curGrid = $(this).attr('id');
			if ( typeof curGrid !== typeof undefined && curGrid !== false )
				curGrid = "#" + curGrid + " "; // Notice trailing space...
			else
				curGrid = "";

			var gridCount = $(curGrid + ".post-grid-item").length;

			if ( gridCount % across !== 0 ) {
				console.log( curGrid + " gridCount: " + gridCount );
				while ( gridCount > across ) {
					gridCount -= across;
				}

				if ( gridCount == 3 ) {
					$(curGrid + ".post-grid-item:last-of-type, " + curGrid + ".post-grid-item:nth-last-of-type(2), " + curGrid + ".post-grid-item:nth-last-of-type(3)").css("float", "left");
					$(curGrid + ".post-grid-item:last-of-type, " + curGrid + ".post-grid-item:nth-last-of-type(2)").css("margin-left", mLeft);
				} else if ( gridCount == 2 ) {
					$(curGrid + ".post-grid-item:last-of-type, " + curGrid + ".post-grid-item:nth-last-of-type(2)").css("float", "left");
					$(curGrid + ".post-grid-item:last-of-type").css("margin-left", mLeft);
				}
			}
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

		$(".close-search").fadeIn("fast");

		$(".navbar-search").data("expanded", true);
	}


	function collapseSearchBar() {
		if ( !viewportIsSmall() ) {
			$("#navbar").removeClass("search-is-active");
			$("#site-navigation-container").animate({opacity: 1});
		}

		$(".navbar-search .search-submit, .navbar-search .search-field").removeClass("is-active");

		$(".navbar-search").css("zIndex", 0);

		$(".close-search").fadeOut("fast");

		$(".navbar-search").data("expanded", false);
	}


	function rhdSquarestagram() {
		var itemW = $("#footer-widget-area .soliloquy-item").width();
		$("#footer-widget-area .soliloquy-item").height( itemW );

		console.log('run');
	}

})(jQuery);
