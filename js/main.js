/* ==========================================================================
	Setup
   ========================================================================== */

var $window = jQuery(window),
	$body = jQuery('body'),
	$mast = jQuery('#masthead'),
	$branding = jQuery('#branding'),
	$navCont = jQuery('#site-navigation-container'),
	$nav = jQuery('#site-navigation'),
	$hamburger = jQuery('#hamburger'),
	$content = jQuery('#content'),
	$main = jQuery('#main');

var isSingle = ( $body.hasClass('single') ) ? true : false,
	isGrid = ( $main.hasClass('grid') === true ) ? true : false,
	isPaged = $body.hasClass('paged');

var maxHeight;

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

		rhdAlpineCrop();

		$window.on('resize', function(){
			rhdAlpineCrop();
			stretchGridItems();
		});

		$("#hamburger").on('click', function(){
			$("#site-navigation-container").slideToggle();
		});

		stretchGridItems( true );
	});


	function rhdInit() {
		// wpAdminBarPush();

		toggleBurger();
		maxHeight = -1;

		// Fix faux-flexbox
		fixGridLayout();

		$( document.body ).on( 'post-load', function () {
			fixGridLayout();
			stretchGridItems( false );
		});
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
		var gridCount = 0;

		$('.post-grid').each(function(){
			gridCount = $(this).children('article').length;

			if ( gridCount % 3 == 2 ) {
				$(this).children('article:last-of-type, .post-grid article:nth-last-of-type(2)').css('float', 'left');
				$(this).children('article:last-of-type').css('margin-left', '5%');
			}
		});
	}


	// Alpine Photo Tile (Pinterest)
	function rhdAlpineCrop() {
		$('.AlpinePhotoTiles-link').each(function(){
			$(this).height( $(this).width() );
		});
	}


	// Stretch grid images to fit croptangle
	function stretchGridItems( setMaxHeight ) {
		if ( setMaxHeight === true ) {
			$('.post-grid article img, .related-post img').each(function() {
				// Reset height
				$(this).css('height', 'auto');

				maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
			});
		}

		$('.post-grid article img, .related-post img').each(function() {
			if ( $(this).height() != maxHeight ) {
				$(this).height(maxHeight);
				$(this).css('width','auto');
			}
		});
	}

})(jQuery);