/**
 * https://gist.github.com/solepixel/9b555388d56a32ee2ec7
 **/

(function( $ ){

	'use strict';

	function auto_fit_soliloquy( parent_selector ){
		// resize the slider container
		var $soliloquy = $( parent_selector + ' .soliloquy-container'),
			$all_items = $('.soliloquy-slider,.soliloquy-viewport,.soliloquy-item', $soliloquy ),
			$container = $('.soliloquy-item', $soliloquy ),
			window_height = $(window).height();

		$all_items.css('height', window_height ).css('overflow','hidden');

		// set image size
		var th = $container.height(), // box height
			tw = $container.width(), // box width
			$im = $('.soliloquy-image', $container ), // image
			ih = $im.height(), // inital image height
			iw = $im.width(); // initial image width

		if ( ih > iw ) { // if portrait
			$im.addClass('ww').removeClass('wh'); // set width 100%
		} else { // if landscape
			$im.addClass('wh').removeClass('ww'); // set height 100%
		}

		// set image offset
		var nh = $im.height(), // new image height
			nw = $im.width(), // new image width
			hd = ( nh - th ) / 2, // half dif img/box height
			wd = ( nw - tw ) / 2; // half dif img/box width

		if ( nh < nw ) { // if portrait
			$im.css({
				'margin-left': '-' + wd + 'px',
				'margin-top': 0,
				'max-width': 'none'
			}); // offset left
		} else { // if landscape
			$im.css({
				'margin-top': '-' + hd + 'px',
				'margin-left': 0,
				'max-width': 'none'
			}); // offset top
		}
	}

	// document ready event
	$(function(){
		auto_fit_soliloquy( '.featured-content-slider' );
	});

	// window resize event
	$(window).on('resize', function(){
		auto_fit_soliloquy( '.featured-content-slider' );
	});

})( jQuery );