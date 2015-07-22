/* ==========================================================================
	Setup
   ========================================================================== */

var $mast = jQuery('#masthead'),
	$navCont = jQuery('#site-navigation-container'),
	$nav = jQuery('#site-navigation'),
	$hamburger = jQuery('#hamburger'),
	$content = jQuery('#content'),
	$main = jQuery('#main');

var gray = "#565656";

var isSingle = ( jQuery('body').hasClass('single') ) ? true : false,
	isGrid = ( $main.hasClass('grid') === true ) ? true : false,
	isPaged = jQuery('body').hasClass('paged');

// wp_data object
var homeUrl = wp_data.home_url,
	themeDir = wp_data.theme_dir,
	imgDir = wp_data.img_dir;

var isFrontPage,
	isMobile,
	isTablet,
	isDesktop;


/* ==========================================================================
	Let 'er rip...
   ========================================================================== */

(function($){

	$(document).ready(function(){
		rhdInit();

		console.log(isFrontPage);

		// fitText
		if ( $('#page-title-big').length )
			fitText(document.getElementById('page-title-big'), 0.8);

		if ( $('#front-page-title-caption').length )
			fitText(document.getElementById('front-page-title-caption'), 1.6);

		// skrollr
		$(".front-page .entry-header, .single .entry-header, .page .entry-header")
			.attr('data-start', 'background-position: 0px 25%;')
			.attr('data-top-bottom', 'background-position: 0px -75%;');
		var $s = skrollr.init({
			forceHeight: false,
			smoothScrolling: true,
			smoothScrollingDuration: -100
		});

		// WPCF7 Form
		$('.wpcf7 input, .wpcf7 textarea').each(function(){
			var $this = $(this),
				$formLabel = $this.parent('span').siblings('label'),
				$labelText = $formLabel.text();

			$formLabel.hide();
			$this.attr('placeholder', $labelText);
		});

		$('.wpcf7 br').remove();

		// #contact link animated scroll
		$('a[href="#contact"]').click(function(e){
			e.preventDefault();

			$('html, body').animate({
				scrollTop: $("#contact").offset().top + $mast.height()
			}, 1000, 'easeInOutSine');
		});

		// Metabar dropdowns
		$('.rhd-dropdown-title').click(function(e){
			e.preventDefault();

			var $this = $(this),
				$dd = $this.siblings('ul');

			$dd.slideToggle();
		});

		if ( isFrontPage ) {
			// initial
			frontPageNavHandler();

			$(window).scroll(function(){
				frontPageNavHandler();
			});
		}

		// initial
		$(".front-page .entry-header").css('height', $("#splash").height());
		resizeCanvas();
	});


	function rhdInit() {
		isFrontPage = ( jQuery('body').hasClass('front-page') === true ) ? true : false;
		isMobile = ( $('body').hasClass('mobile') === true ) ? true : false;
		isTablet = ( $('body').hasClass('tablet') === true ) ? true : false;
		isDesktop = ( $('body').hasClass('desktop') === true ) ? true : false;

		wpadminbarPush();

		$.slidebars({
			siteClose: false,
		});
		toggleBurger();

		$(window).resize(function(){
			resizeCanvas();
		});
	}


	function wpadminbarPush() {
		$("#wpadminbar").css({
			top: '50px',
		});
	}


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $(".cmn-toggle-switch");

		toggles.click(function(e){
			e.preventDefault();
			$(this).toggleClass('active');
		});
	}


	function setupDrawPoly( e ){
		var canvas;

		if ( e.length ) {
			canvas = [];
			canvas.container = e;
			canvas.self = e.children('canvas');
			canvas.ctx = canvas.self.get(0).getContext('2d');
			canvas.w = e.width();
			canvas.h = e.height();

			return canvas;
		} else {
			return false;
		}
	}


	function drawPolyTL(){
		var canvas = setupDrawPoly( $('#poly-tl') );

		if ( canvas ) {
			canvas
				.self
					.width( canvas.w )
					.height( canvas.h );

			var path = new Path2D();
			path.moveTo(0, 0);
			path.lineTo( canvas.w, canvas.h );
			path.lineTo( 0, canvas.h );
			canvas.ctx.fillStyle = gray;
			canvas.ctx.fill(path);
		}
	}

	function drawPolyTR(){
		var canvas = setupDrawPoly( $('#poly-tr') );

		if ( canvas ) {
			canvas
				.self
					.width( canvas.w )
					.height( canvas.h );

			var path = new Path2D();
			path.moveTo( canvas.w, 0 );
			path.lineTo( 0, canvas.h );
			path.lineTo( canvas.w, canvas.h );
			canvas.ctx.fillStyle = gray;
			canvas.ctx.fill(path);
		}
	}

	function drawPolyBL(){
		var canvas = setupDrawPoly( $('#poly-bl') );

		if ( canvas ) {
			canvas
				.self
					.width( canvas.w )
					.height( canvas.h );

			var path = new Path2D();
			path.moveTo(0, 0);
			path.lineTo( canvas.w, 0 );
			path.lineTo( 0, canvas.h );
			canvas.ctx.fillStyle = gray;
			canvas.ctx.fill(path);
		}
	}

	function drawPolyBR(){
		var canvas = setupDrawPoly( $('#poly-br') );

		if ( canvas ) {
			canvas
				.self
					.width( canvas.w )
					.height( canvas.h );

			var path = new Path2D();
			path.moveTo(0, 0);
			path.lineTo( canvas.w, canvas.h );
			path.lineTo( canvas.w, 0 );
			canvas.ctx.fillStyle = gray;
			canvas.ctx.fill(path);
		}
	}

	function resizeCanvas(){
		if ( $(window).width() > 640 ) {
			$(window).show();
			$(".poly canvas").each(function(){
				$(this).attr( 'width', $(this).parent().width() );
				$(this).attr( 'height', $(this).parent().height() );
			});

			drawPolyTL();
			drawPolyTR();
			drawPolyBL();
			drawPolyBR();
		} else {
			$(window).hide();
		}
	}

	function frontPageNavHandler(){
		var $logo = $("#front-page-title > img");

		if ( !$logo.visible( true ) ) {
			$mast.slideDown();
			console.log('down');
		} else {
			$mast.slideUp();
			console.log('up');
		}
	}


})(jQuery);