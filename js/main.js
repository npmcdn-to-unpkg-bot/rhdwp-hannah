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
	var parallax;

	$(document).ready(function(){
		'use strict';

		rhdInit();

		$(window).on("resize", function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
				parallax.reload();
			}

			setFullWidthDimensions();
		});

		$(window).on("scroll", function(){
			if ( !viewportIsSmall() )
				rhdShowHideFeaturedImage();
		});
	});


	function rhdInit() {
		toggleBurger();
		fixGridLayout(".post-grid");
		wpAdminBarPush();
		setFullWidthDimensions();

		if ( !viewportIsSmall() )
			rhdShowHideFeaturedImage();
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


	function setFullWidthDimensions() {
		var navHt = $("#navbar").height();

		$(".rhd-full-width-thumbnail-container").imagesLoaded().done(function(){
			if ( !viewportIsSmall() ) {
				$(".fixed-bg").css({
					'top': navHt,
					'height': $(window).height() - navHt
				});
			}

//			$(".fixed-bg + .full-width-page").css('marginTop', $(".fixed-bg").height() + navHt);
			$(".rhd-page-header-cta-container").css({
				'height': $(".fixed-bg").height() + 'px',
				'marginTop': navHt
			});
			parallax = new Scrollax().init();
		});
	}


	function rhdShowHideFeaturedImage() {
		var st = $(window).scrollTop();

		if ( st > $(".fixed-bg").height() ) {
			$(".fixed-bg").css('visibility', 'hidden');
		} else {
			$(".fixed-bg").css('visibility', 'initial');
		}
	}
})(jQuery);