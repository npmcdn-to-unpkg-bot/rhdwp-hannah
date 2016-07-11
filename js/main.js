/* ==========================================================================
	Setup
   ========================================================================== */

var $body = jQuery('body'),
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

		$('#header-search .search-submit').click(function(e){
			e.preventDefault();

			if ( !$("#header-search").data('expanded') ) {
				expandSearchBar();
			} else {
				// Check that input isn't just whitespace
				var searchStr = $('#header-search .search-field').val().replace(/^\s+/, '').replace(/\s+$/, '');

				if ( searchStr === '' ) {
					collapseSearchBar();
				} else {
					// Run the search
					$("#header-search form").submit();
				}
			}
		});

		// Close header search by clicking 'X' or ESC
		$('.close-search').click(function(e){
			e.preventDefault();
			collapseSearchBar();
		});

		$(document).keyup(function(e) {
			if ( e.keyCode == 27 && $("#header-search").data('expanded') ) {
				collapseSearchBar();
			}
		});

		$(window).on('resize', function(){
			if ( !viewportIsSmall() ) {
				resetToggleBurger();
			}
		});

		$(document).mouseup(function(e){
			var $container = $("#header-search");

			if (!$container.is(e.target) && $container.has(e.target).length === 0) {
				collapseSearchBar();
			}
		});
	});


	function rhdInit() {
		// wpAdminBarPush();

		toggleBurger();

		// Fix faux-flexbox
		fixGridLayout();

		// Disable old blogspot image links
		killBlogspotLinks();

		// Set header search form state
		$("#header-search").data('expanded', false);

		// Scroll-fade mini logo
		hideShowMiniLogo();
	}


	function wpAdminBarPush() {
		$("#wpadminbar").css({
			top: $("#masthead").height(),
		});
	}


	function viewportIsSmall() {
		if ( $(window).width() < 640 )
			return true;
		else
			return false;
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


	function resetToggleBurger() {
		$('.nav-dropdown').removeAttr('style');
		$("#hamburger").removeClass('is-active');
	}


	// Faux-flexbox "fix" template (edit for varying column numbers)
	function fixGridLayout() {
		var across = 4;
		var mLeft = "3.5%";

		$(".post-grid").each(function(){
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


	function expandSearchBar() {
		$('#navbar .widget_rhd_social_icons').fadeOut('fast');

		$('#header-search, #header-search .search-field, #header-search .search-submit').addClass('is-active');

		$('.close-search').fadeIn('fast');

		setTimeout(function(){
			$("#header-search .search-field").focus();
		}, 0);

		$("#header-search").data('expanded', true);
	}


	function collapseSearchBar() {
		$('#navbar .widget_rhd_social_icons').fadeIn('fast');

		$('#header-search, #header-search .search-field, #header-search .search-submit').removeClass('is-active');

		$('.close-search').fadeOut('fast');
		$("#header-search").data('expanded', false);
	}


	function killBlogspotLinks() {
		$('.entry-content a img').each(function(){
			var a = $(this).parents('a');
			var bsLink = a.attr('href');

			if ( bsLink.indexOf('blogspot') >= 0 )
				$(this).unwrap('a');
		});
	}


	function hideShowMiniLogo() {
		$(window).scroll(function(){
			if ( !viewportIsSmall() ) {
				if ( !$("#site-title").visible() ) {
					$(".site-title-mini, #site-navigation-container").addClass("scrolled");
				} else {
					$(".site-title-mini, #site-navigation-container").removeClass("scrolled");
				}
			}
		});
	}

})(jQuery);
