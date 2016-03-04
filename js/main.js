(function($){
	var postContent = null;
	
	$(document).ready(function(){
		rhdInit();
		
		
		// Spanish replace text
		$(".page-id-309 .ninja-forms-required-items").text('Se requieren áreas marcadas con *');
		
		
		// "Image Strip"
		if ( $('.entry-content img').length ) {
			if ( $('body').hasClass('page') && !$("body, #primary").is( '.blog-area' ) && !$("body").hasClass('no-image-strip') && !$("body").hasClass( 'page-id-6' ) && !$("body").hasClass( 'page-id-306' ) ) {
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
	});

	
	function setImageStrip() {
		if ( $('#content article img.alignnone').length ) {
			$('<div id="image-strip"></div>').prependTo('#content');
			$('#content article').addClass('strip-active');
			
			$(".entry-content img").each(function(){
				var $this = $(this);
				if ( $this.hasClass('alignnone') ) {
					if ( $this.parent().is('a') ) {
						$this
							.parent('a')
							.appendTo($("#image-strip"));
						$this.addClass("strip-active");
					} else {
						$this
							.appendTo($("#image-strip"))
							.addClass("strip-active");
					}
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
		//wpAdminBarPush();

		$.slidebars({
			siteClose: false
		});

		toggleBurger();

		postContent = $(".entry-content").html();
		
		superscriptCopy();
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
	
	
	// superscript-ifies specified ® characters
	function superscriptCopy() {
		var $title = $("#site-title a");
		$title.html($title.text().replace('Erin', 'Erin<sup>®</sup>'));
	}

})(jQuery);