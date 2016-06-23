(function($){

	var ddAnyIsOpen = false;

	$(document).ready(function(){

		$(".rhd-dropdown ul").data("menuState", "closed");

		$(".rhd-dropdown-title").click(function(e){
			e.preventDefault();

			var $this = $(this);
			var	$dd = $this.siblings("ul");

			if ( $dd.is(":visible") ) {
				ddClose($dd);
			} else {
				ddOpen($dd);
			}

		});

		$(document).mouseup(function(e){
			var $dd = $('.rhd-dropdown ul');

			if ( e.target.id != $dd.attr('class') ) {
				ddClose($dd);
			}
		});

	});


	function ddOpen( $dd ) {
		if ( ddAnyIsOpen === true ) {
			$(".rhd-dropdown ul").slideUp('fast');
		}
		$dd.slideDown();
		ddAnyIsOpen = true;
	}

	function ddClose( $dd ) {
		$dd.slideUp();
		ddAnyIsOpen = false;
	}

})(jQuery);