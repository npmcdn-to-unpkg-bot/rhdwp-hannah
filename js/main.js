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

		// Metabar dropdowns
		$('.rhd-dropdown-title').click(function(e){
			e.preventDefault();

			var $this = $(this),
				$dd = $this.siblings('ul');

			$dd.slideToggle();
		});


		// "Image Strip"
		if ( $('#content').hasClass( 'image-strip-active' ) ) {
			if ( $window.width() > 800 )
				setImageStrip();

			$window.on('resize', function(){
				if ( $window.width() > 800 )
					setImageStrip();
				else
					unsetImageStrip();
			});
		}

		// Navbar search expansion
		searchW = $('#header-search .search-field').width();
		searchPT = $('#header-search .search-field').css('paddingTop');
		searchPR = $('#header-search .search-field').css('paddingRight');
		searchPL = $('#header-search .search-field').css('paddingLeft');
		searchB = $('#header-search .search-field').css('borderWidth');
		$('#header-search .search-field').css({
			width: 0,
			padding: 0,
			borderWidth: 0
		});
		isExpanded = false;

		$('#header-search .search-submit').click(function(e){
			if (!isExpanded) {
				e.preventDefault();

				$('#header-search .search-field')
					.animate({ borderWidth: searchB }, 100)
					.animate({
						width: searchW,
						paddingTop: searchPT,
						paddingRight: searchPR,
						paddingBottom: searchPT,
						paddingLeft: searchPL
					}, 'fast', 'easeOutExpo', function(){
						isExpanded = true;
					});
			}
		});
	});


	function rhdInit() {
		// wpAdminBarPush();

		/*
		$.slidebars({
			siteClose: false,
		});
		*/

		toggleBurger();

		// Fix faux-flexbox
		fixGridLayout();

		// Image Strip
		postContent = $(".entry-content").html();
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

			$('.nav-dropdown').slideToggle();
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
