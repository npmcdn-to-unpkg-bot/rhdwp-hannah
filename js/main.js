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

var $posts; // Prep for packery instance
var isPackery = false;

var packeryOpts = { initLayout: false, percentPosition: true, itemSelector: ".type-post", columnWidth: ".rhd-excerpt-post", gutter: ".rhd-post-gutter" };


/* ==========================================================================
	Public Functions
   ========================================================================== */

function viewIsMobile() {
	if ( $window.width() < 640 ) return true;
	else return false;
}


function viewIsMedium() {
	if ( $window.width() < 960 ) return true;
	else return false;
}


function packeryPosts( $posts ) {
	if ( viewIsMedium() ) {
		if ( $posts.data('packery') ) {
			$posts.packery('destroy');
		}

		isPackery = false;
	} else  {
		if ( isPackery === true ) {
			$posts.imagesLoaded(function(){
				$posts.packery('reloadItems');
			});
		} else {
			$posts.imagesLoaded(function(){
				// packeryOpts has 'initLayout: false', so manually lay out after init
				$posts
					.packery(packeryOpts)
					.packery('layout');

				if ( jQuery('.blog-container article').not(':visible') ) {
					jQuery('.blog-container article').animate({
						opacity: 1
					});
				}
			});
		}
		isPackery = true;
	}
}


function packeryAppend( $posts, $html ) {
	if ( !viewIsMedium() ) {
		$posts
			.append($html)
			.imagesLoaded(function(){
				$posts.packery('appended', $html);
			});
	} else {
		$posts.append($html);
	}
}


/* ==========================================================================
	jQuery no-conflict
   ========================================================================== */

(function($){
	$(document).ready(function() {
		rhdInit();

		// Metabar dropdowns
		$('.rhd-dropdown-title').click(function(e){
			e.preventDefault();

			var $this = $(this),
				$dd = $this.siblings('ul');

			$dd.slideToggle(300, 'swing');

			/*
			$(document).on('click', function(){
				if ( $dd.is(':visible')) {
					$dd.slideUp(300, 'swing');
				}
			});
			*/
		});


		// Resize event
		$window.on('resize', function(){
			mobileStyles();
			packeryPosts($posts);
		});


		// Packery load
		$('.blog-container article').css('opacity', 0);
		$posts = $('.blog-container').packery(packeryOpts);
		packeryPosts($posts);


		// Gallery load + hover
		$('.post-12063 .gallery')
			.css('opacity', 0)
			.imagesLoaded(function(){
				$('.post-12063 .gallery').animate({
					opacity: 1
				}, 'slow');
			});

		$('.post-12063 .gallery-item').each(function(){
			var url = $(this).find('a').attr('href');

			$(this).find('.wp-caption-text a').attr('href', url);
		});
	});


	function rhdInit() {
		toggleBurger();
		mobileStyles();
	}


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $(".c-hamburger");
		var nav = $("#site-navigation-container");

		toggles.click(function(e){
			e.preventDefault();
			$(this).toggleClass('is-active');
			nav.slideToggle();
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


	function mobileStyles() {
		if ( viewIsMobile() ) {
			if ( !$("#site-navigation-conatiner").hasClass('mobile') ) {
				var borderHt = parseInt( $("#masthead").css("marginTop") );
				var mastHt = $("#masthead").height();

				var navOffset = borderHt + mastHt + "px";

				$("#site-navigation-container")
					.css({
						top: navOffset
					})
					.addClass('mobile');
			}

			$("body").addClass( 'mobile-viewport' );
		} else {
			$("#site-navigation-container")
				.attr('style', '')
				.removeClass('mobile');

			$('body').removeClass( 'mobile-viewport' );
		}
	}

})(jQuery);