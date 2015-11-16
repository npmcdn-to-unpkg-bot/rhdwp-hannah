(function($){
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
		if ( !$('body').hasClass( 'blog-area' ) ) {
			if ( $(window).width() > 800 )
				setImageStrip();
			
			$(window).on('resize', function(){
				if ( $(window).width() > 800 )
					setImageStrip();
				else
					unsetImageStrip();
			});
		}
		
		
		checkCrappyLoginBox();
		$(window).on('resize', checkCrappyLoginBox );
		
		// AJAX pages auto load first glossary element
		$("#glossary-area a").first().trigger("click");
	});

	
	function setImageStrip() {
		if ( $(".entry-content img").length !== 0 ) {
			$(".image-strip").addClass('strip-active');
			$('#content article').addClass('strip-active');
			
			$(".entry-content img")
				.appendTo($(".image-strip"))
				.addClass("strip-active");
		}
	}
	
	function unsetImageStrip() {
		$(".image-strip")
			.removeClass('strip-active')
			.html('');
			
		$('#content article').removeClass('strip-active');
		$(".entry-content").removeClass('strip-active');
		
		$(".entry-content").html(postContent);
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

})(jQuery);