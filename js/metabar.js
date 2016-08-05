(function($){

	var ddAnyIsOpen = false;
	var $ddGlobal = $(".rhd-dropdown > ul");

	$(document).ready(function(){

		$ddGlobal.data("menuState", "closed");

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
			if ( e.target.id != $ddGlobal.attr('class') ) {
				ddClose($ddGlobal);
			}
		});

	});


	function ddOpen( $dd ) {
		if ( ddAnyIsOpen === true ) {
			$dd.slideUp('fast');
		}
		$dd.slideDown();
		ddAnyIsOpen = true;
	}

	function ddClose( $dd ) {
		$dd.slideUp();
		ddAnyIsOpen = false;
	}

})(jQuery);