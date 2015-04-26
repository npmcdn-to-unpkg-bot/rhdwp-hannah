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

// wp_data object
var homeUrl = wp_data.home_url,
	themeDir = wp_data.theme_dir,
	imgDir = wp_data.img_dir;

var isFrontPage = ( $body.hasClass('front-page') === true ) ? true : false;
var isMobile = ( $body.hasClass('mobile') === true ) ? true : false;
var isTablet = ( $body.hasClass('tablet') === true ) ? true : false;


/* ==========================================================================
	Let 'er rip... (DOM Ready)
   ========================================================================== */

(function($){
	rhdInit();

})(jQuery);


/* ==========================================================================
	Functions
   ========================================================================== */

function rhdInit() {
	//wpadminbarPush();

	if ( wp_data.inc_slidebars === true )
		$.slidebars();

	if ( wp_data.inc_packery === true ) {
		// Packery Initialization + Options
	}

	rhd_youtube_responsivizer();
}


function wpadminbarPush() {
	jQuery("#wpadminbar").css({
		top: '50px',
	});
}


function rhd_youtube_responsivizer() {
	var $allVideos = jQuery("iframe[src^='//www.youtube.com']"),

	// The element that is fluid width
	$fluidEl = jQuery(".entry-content");

	// Figure out and save aspect ratio for each video
	$allVideos.each(function() {

	jQuery(this)
		.data('aspectRatio', this.height / this.width)

		// and remove the hard coded width/height
		.removeAttr('height')
		.removeAttr('width');
	});

	// When the window is resized
	jQuery(window).resize(function() {

		var newWidth = $fluidEl.width();

		// Resize all videos according to their own aspect ratio
		$allVideos.each(function() {
			var $el = jQuery(this);
			$el
			.width(newWidth)
			.height(newWidth * $el.data('aspectRatio'));
		});

	// Kick off one resize to fix all videos on page load
	}).resize();
}
