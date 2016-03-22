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
	});


	function rhdInit() {
		// wpAdminBarPush();

		$.slidebars({
			siteClose: false,
		});

		toggleBurger();

		// Fix faux-flexbox
		// fixGridLayout();

		// Image Strip
		// postContent = $(".entry-content").html();

		// Check inline SVG support
		if ( ! Modernizr.inlinesvg) {
			$(".svg-fallback").show();
		}
	}


	function wpAdminBarPush() {
		$("#wpadminbar").css({
			top: $("#masthead").height(),
		});
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


	// Set Image Strip layout
	function setImageStrip() {
		$('<div id="image-strip"></div>').prependTo('#content');
		$('#content article').addClass('strip-active');

		$(".entry-content img").each(function(){
			if ( $(this).hasClass('alignnone') ) {
				$(this)
					.appendTo($("#image-strip"))
					.addClass("strip-active");
			}
		});
	}


	// Unset Image Strip layout
	function unsetImageStrip() {
		$("#image-strip").html('');

		$('#content article').removeClass('strip-active');
		$(".entry-content").removeClass('strip-active');

		$(".entry-content").html(postContent);
	}

})(jQuery);
