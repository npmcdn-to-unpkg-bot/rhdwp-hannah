/* ==========================================================================
	Setup
   ========================================================================== */

var isSingle = ( jQuery("body").hasClass("single") ) ? true : false,
	isGrid = ( jQuery("main").hasClass("grid") === true ) ? true : false,
	isPaged = jQuery("body").hasClass("paged");

var isFrontPage = ( jQuery("body").hasClass("front-page") === true ) ? true : false;
var isMobile = ( jQuery("body").hasClass("mobile") === true ) ? true : false;
var isTablet = ( jQuery("body").hasClass("tablet") === true ) ? true : false;
var isDesktop = ( jQuery("body").hasClass("desktop") === true ) ? true : false;


/* ==========================================================================
	Let "er rip...
   ========================================================================== */

(function($){
	$(document).ready(function(){
		'use strict';

		rhdInit();

		$(window).on("resize", function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
			}

			setFullWidthDimensions();
		});

		$(window).on("scroll", function(){
			showHideFeaturedImage();
		});
	});


	function rhdInit() {
		toggleBurger();
		fixGridLayout(".post-grid");
		wpAdminBarPush();
		setFullWidthDimensions();

		showHideFeaturedImage();
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
		var across = 3;
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


	function setFullWidthDimensions() {
		$("#navbar, .rhd-full-width-thumbnail-container").imagesLoaded().done(function(){
			var navHt = $("#navbar").height();

			if ( !viewportIsSmall() ) {
				$(".fixed-bg").css({
					'top': navHt,
					'height': $(window).height() - navHt
				});

				$(".default-thumb").css({
					'marginTop': navHt
				});
			}

			$(".rhd-page-overlay-cta-container").css({
				'height': $(".fixed-bg").height(),
				'marginTop': navHt
			});
		});
	}


	// Show/hide to prevent overscrolling the undergrundle...
	function showHideFeaturedImage() {
		var st = $(window).scrollTop();

		if ( st > $(".fixed-bg").height() ) {
			$(".fixed-bg").css('visibility', 'hidden');
		} else {
			$(".fixed-bg").css('visibility', 'initial');
		}
	}
})(jQuery);