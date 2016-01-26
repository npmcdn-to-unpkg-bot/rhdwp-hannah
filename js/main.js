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

		// setTimeout(onLoadScroll, 1000);

		// Burger
		var toggles = $(".c-hamburger");

		toggles.click(function(e){
			e.preventDefault();
			$(this).toggleClass('is-active');
		});

		// Portfolio filter
		$(".portfolio-link a").on('click', function(e){
			e.preventDefault();

			$(".portfolio-link").removeClass('portfolio-current');

			$(this).parent('.portfolio-link').addClass('portfolio-current');
			var cat = $(this).data('slug');
			filterPortfolio(cat);

			return false;
		});
	});


	function rhdInit() {
		$.slidebars({
			siteClose: false,
		});
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


	/**
	 * filterPortfolio function.
	 */
	function filterPortfolio( cat ) {
		var oldContent = '';
		var newContent = '';

		$.ajax({
			url: wp_data.ajax_url,
			type: 'post',
			data: {
				action: 'ajax_filter',
				cat: cat
			},
			beforeSend: function() {
				oldContent = $("#rhd-portfolio").html();
				var ht = $("#rhd-portfolio").height() / 2;
				$("#rhd-portfolio").css('minHeight', ht);
				$("#rhd-portfolio").stop().fadeOut(500);
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
				newContent = '<p class="filter-results-msg">An error has occured. Please <a href="#" onclick="window.location.reload();return false;">reload the page</a> and try again."</p>' + oldContent;
			},
			complete: function() {
				$("#rhd-portfolio")
					.html( newContent )
					.stop()
					.fadeIn(500);
			}
		});
	}
})(jQuery);