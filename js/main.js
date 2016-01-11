(function($){
	var themeDir = data.theme_dir;
	var isMobile = ( $('body').hasClass('mobile') === true ) ? true : false;
	var isTablet = ( $('body').hasClass('tablet') === true ) ? true : false;

	var postContent = null;

	$(document).ready(function(){
		rhdInit();

		// Sub Nav Hoverage
		$("#site-navigation .menu-item-has-children").hover(function(){
			$(this).find('.menu-item').stop().show();
		}, function(){
			$(this).find('.menu-item').stop().hide();
		});


		$("#masthead").imagesLoaded(function(){
			var navTop = $('#navbar').offset().top;

			$(window).scroll(function(){
				if ( $(window).scrollTop() - navTop >= 0 ) {
					$('#navbar, #page').addClass('sticky');
				} else {
					$('#navbar, #page').removeClass('sticky');
				}
			});
		});


		// "Image Strip"
		if ( $('.entry-content img').length ) {
			if ( $('body').hasClass('page') && !$("body, #primary").is( '.blog-area' ) && !$("body").hasClass('no-image-strip') ) {
				if ( $(window).width() > 800 )
					setImageStrip();

				$(window).on('resize', function(){
					if ( $(window).width() > 800 )
						setImageStrip();
					else
						unsetImageStrip();
				});
			}
		}


		// Click Events
		$("#signup").on('click', function(e){
			e.preventDefault();
			$("#ninja-mailchimp").slideToggle();
		});

		$("body").on('click', '#roster-link a', function(){
			tableWindow();
		});


		checkCrappyLoginBox();
		$(window).on('resize', checkCrappyLoginBox );

		// AJAX pages auto load first glossary element
		$("#glossary-area a").first().trigger("click");

		//UNHIDE LOST PASSWORD
/*
		$("#lostpasswordform").show();
		$("#lostpasswordform .nav").hide();
*/
	});


	function setImageStrip() {
		if ( $('#content article img.alignnone').length ) {
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
	}

	function unsetImageStrip() {
		if ( $("#image-strip").length ) {
			$("#image-strip").remove();

			$('#content article').removeClass('strip-active');
			$(".entry-content").removeClass('strip-active');

			$(".entry-content").html(postContent);
		}
	}


	function rhdInit() {
		wpAdminBarPush();

		$.slidebars({
			siteClose: false
		});

		toggleBurger();

		// Fix faux-flexbox
		fixGridLayout();

		postContent = $(".entry-content").html();
	}


	function wpAdminBarPush() {
		$("#page").css({
			top: $("#wpadminbar").height(),
		});
	}


	// Adapted from Hamburger Icons: https://github.com/callmenick/Animating-Hamburger-Icons
	function toggleBurger() {
		var toggles = $(".c-hamburger");

		toggles.click(function(e){
			e.preventDefault();
			$(this).toggleClass('is-active');
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


	function checkCrappyLoginBox() {
		// login page hacks
		var alertText = $(".ms-alert-box").text();
		if ( alertText.indexOf( 'log in' ) != -1 )
			$(".ms-alert-box").hide();
	}


	function tableWindow() {
		var w = window.open();
		tableData = '<div id="solo-roster-table"><h2 class="solo-roster-title">Member Roster: \'' + $("#roster-area-container").attr('data-roster-key').toUpperCase() + "'" + $("#roster-area-container").html() + '</div>';

		tableHtml = '<!DOCTYPE html><html><head><link rel="stylesheet" href="' + themeDir + '/css/main.css" type="text/css"></head><body>' + tableData + '</body></html>';

		$(w.document.body).html(tableHtml);
	}

})(jQuery);