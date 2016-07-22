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
	Let "er rip...
   ========================================================================== */

(function($){

	$(document).ready(function(){
		rhdInit();

		$(window).on("resize", function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
			}
		});
	});


	function rhdInit() {
		toggleBurger();
		headerSearch();
		fixGridLayout(".post-grid");
		//wpAdminBarPush();
	}


	function wpAdminBarPush() {
		if ( $("#navbar").css("position") == "fixed" ) {
			$("#wpadminbar").css({
				top: $("#masthead").height(),
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
		$(".navbar-search").data("expanded", true);

		//$(".close-search").fadeIn("fast");
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

		//$(".close-search").fadeOut("fast");
	}

})(jQuery);