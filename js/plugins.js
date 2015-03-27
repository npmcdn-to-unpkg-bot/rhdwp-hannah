// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.

/* ==========================================================================
	Conditionals and Globals
   ========================================================================== */

var isFrontPage = ( jQuery("body").hasClass("front-page") === true ) ? true : false;
var isMobile = ( jQuery("body").hasClass("mobile") === true ) ? true : false;
var isTablet = ( jQuery("body").hasClass("tablet") === true ) ? true : false;

// wp_data object
var homeUrl = wp_data.home_url,
	themeDir = wp_data.theme_dir,
	imgDir = wp_data.img_dir;


/* ==========================================================================
   Visiblity Toggle
   ========================================================================== */

jQuery.fn.visible = function() {
    return this.css('visibility', 'visible');
};

jQuery.fn.invisible = function() {
    return this.css('visibility', 'hidden');
};

jQuery.fn.visibilityToggle = function() {
    return this.css('visibility', function(i, visibility) {
        return (visibility == 'visible') ? 'hidden' : 'visible';
    });
};


/* ==========================================================================
	YouTube Resizer
   ========================================================================== */

function rhd_youtube_responsivizer() {
	var $allVideos = $("iframe[src^='//www.youtube.com']"),

	// The element that is fluid width
	$fluidEl = $(".entry-content");
	
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
		var $el = $(this);
		$el
		.width(newWidth)
		.height(newWidth * $el.data('aspectRatio'));
	});
	
	// Kick off one resize to fix all videos on page load
	}).resize();
}

/* ==========================================================================
	Functions
   ========================================================================== */

function rhdInit() {
	//wpadminbarPush();
	rhd_youtube_responsivizer();
}


function wpadminbarPush() {	
	jQuery("#wpadminbar").css({
		top: '50px',
	});
}