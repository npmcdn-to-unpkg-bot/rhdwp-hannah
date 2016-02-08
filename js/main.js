/* ==========================================================================
	Setup
   ========================================================================== */

var $window = jQuery(window),
	$body = jQuery('body'),
	$main = jQuery('#main');

var isSingle = ( $body.hasClass('single') ) ? true : false,
	isGrid = ( $main.hasClass('grid') === true ) ? true : false,
	isPaged = $body.hasClass('paged');

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

		// Burger
		var toggles = $(".c-hamburger");

		toggles.click(function(event){
			event.preventDefault();
			$(this).toggleClass('is-active');
		});

		// Portfolio filter
		$(".portfolio-link a").on('click', function(event){
			event.preventDefault();

			$(".portfolio-link").removeClass('portfolio-current');

			$(this).parent('.portfolio-link').addClass('portfolio-current');
			var cat = $(this).data('slug');
			filterPortfolio(cat);
		});

		// Portfolio pulldown
		$(".portfolio-pulldown").on('click', function(event){
			event.preventDefault();

			$(".portfolio-category-list").slideToggle();
		});

		// Portfolio title character hacks
		$(".type-portfolio .page-title:contains('&amp;'), .type-portfolio .page-title:contains('&'), .portfolio-link a:contains('&amp;'), .portfolio-link a:contains('&')").html(function(i, html){
			return html.replace(/&amp;/g, '<span class="fonthack">&amp;</span>');
		});

		$(".type-portfolio .page-title:contains('/'), .portfolio-link a:contains('/')").html(function(i, html){
			return html.replace(/\//g, '<span class="fonthack">/</span>');
		});

		$(".type-portfolio .page-title:contains('\'), .portfolio-link a:contains('\')").html(function(i, html){
			return html.replace(/\\/g, '<span class="fonthack">\</span>');
		});
	});


	function rhdInit() {
		$.slidebars({
			siteClose: false,
		});

		fixFlexbox();
	}


	function onLoadScroll() {
		$('html, body').animate({
			'scrollTop' : '80%'
		}, 'slow', 'swing');
	}


	function wpAdminBarPush() {
		$("#wpadminbar").css({
			top: $("#masthead").height(),
		});
	}


	function fixFlexbox() {
		$(".grid-area").each(function(){
			var $this = $(this);
			var i = $this.children('.grid-item').length;

			if ( i % 3 == 2 ) {
				$('.grid-area .grid-item:last-child, .grid-area .grid-item:nth-last-child(2)').css('float', 'left');
				$('.grid-area .grid-item:last-child').css('marginLeft', '2%');
			}
		});
	}


	/**
	 * filterPortfolio function.
	 */
	function filterPortfolio( cat ) {
		var newContent = '';

		$.ajax({
			url: wp_data.ajax_url,
			type: 'post',
			data: {
				action: 'ajax_filter',
				cat: cat
			},
			beforeSend: function() {
				$(".grid-area")
					.stop()
					.fadeOut(500);
			},
			success: function(html) {
				if ( html.indexOf('no-results') < 0 ) {	// If not the content-none page...
					newContent = $.parseHTML(html);
				} else {								// Else, if query turns up empty...
					newContent = '<p class="filter-results-msg">No results.</p>';
				}
			},
			error: function() {
				// Restore the original content
				newContent = '<p class="filter-results-msg">An error has occured. Please <a href="#" onclick="window.location.reload();return false;">reload the page</a> and try again."</p>';
			},
			complete: function() {
				$("#rhd-portfolio .grid-area").html( newContent );

				fixFlexbox();

				$("#rhd-portfolio .grid-area")
					.stop()
					.fadeIn(500);
			}
		});
	}
})(jQuery);