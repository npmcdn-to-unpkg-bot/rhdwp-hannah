/* ==========================================================================
	Setup
   ========================================================================== */

var gray = "#565656";

var isSingle = ( jQuery('body').hasClass('single') ) ? true : false,
	isGrid = ( jQuery('#main').hasClass('grid') === true ) ? true : false,
	isPaged = jQuery('body').hasClass('paged');

var $packery,
	packeryIsActive = false;

var $skrollr,
	skrollrIsActive = false;

// wp_data object
var homeUrl = wp_data.home_url,
	themeDir = wp_data.theme_dir,
	imgDir = wp_data.img_dir;

var isFrontPage,
	isMobile,
	isTablet,
	isDesktop;

var sb;


/* ==========================================================================
	Let 'er rip...
   ========================================================================== */

(function($){
	$(document).ready(function(){
		rhdInit();

		// fitText
		if ( $('#page-title-big').length )
			fitText(document.getElementById('page-title-big'), 0.8);

		if ( $('#front-page-title-caption').length )
			fitText(document.getElementById('front-page-title-caption'), 1.5);

		// Skrollr setup
		$(".front-page .entry-header, .single .entry-header, .page .entry-header")
			.attr('data-start', 'background-position: 0px 25%;')
			.attr('data-top-bottom', 'background-position: 0px -60%;');

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

			// Check Slidebars, close if open
			if ( sb.slidebars.active( 'right' ) === true ) {
				sb.slidebars.close();
				$(".cmn-toggle-switch").removeClass('active');
			}

			$('html, body').animate({
				scrollTop: $("#contact").offset().top + $('#masthead').height()
			}, 1000, 'easeInOutQuart');
		});

		// Metabar dropdowns
		$('.rhd-dropdown-title').click(function(e){
			e.preventDefault();

			var $this = $(this),
				$dd = $this.siblings('ul');

			$dd.slideToggle('fast');
		});

		if ( isFrontPage ) {
			// initial
			frontPageLogoHandler();

			$(window).scroll(function(){
				frontPageLogoHandler();
			});
		}


		// initial
		$(".front-page .entry-header").css('height', $("#splash").height());
		resizeCanvas();


		// Packery and Skrollr init
		if ( 640 <= $(window).width() ) {
			packeryInit();
			skrollrInit();
		}

		// Resize events
		$(window).resize(function(){
			resizeCanvas();

			if ( $(window).width() < 640 ) {
				skrollrDestroy();

				if ( packeryIsActive ) {
					$packery.packery('destroy');
					packeryIsActive = false;
				}
			} else {
				packeryInit();


				skrollrInit();
			}
		});
	});


	function rhdInit() {
		isFrontPage = ( jQuery('body').hasClass('front-page') === true ) ? true : false;
		isMobile = ( $('body').hasClass('mobile') === true ) ? true : false;
		isTablet = ( $('body').hasClass('tablet') === true ) ? true : false;
		isDesktop = ( $('body').hasClass('desktop') === true ) ? true : false;

		wpadminbarPush();

		sb = new $.slidebars({
			siteClose: false,
		});

		toggleBurger();
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

	function frontPageLogoHandler(){
		var $logo = $("#front-page-title > img"),
			$topLogo = $("#site-brand");

		if ( !$logo.visible( true ) ) {
			$topLogo.stop().animate({
				opacity: 1
			}, 'slow', 'easeOutQuart');
		} else {
			$topLogo.stop().animate({
				opacity: 0
			}, 'slow', 'easeInQuart');
		}
	}

	function packeryInit() {
		$packery = $(".blog-index #content");

		$packery.imagesLoaded( function(){
			$packery.packery({
				itemSelector: '.post',
				percentPosition: true,
				gutter: '.gutter-sizer'
			});
		});

		packeryIsActive = true;
	}

	function skrollrInit() {
		$skrollr = skrollr.init({
			forceHeight: false,
			smoothScrolling: true,
			smoothScrollingDuration: -100
		});

		skrollrIsActive = true;
	}

	function skrollrDestroy() {
		if ( $skrollr ) {
			$skrollr.destroy();

			skrollrIsActive = false;
		}
	}

})(jQuery);