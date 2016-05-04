(function($){
	$(document).ready(function(){
		$('.gb-auto-color').on('hover', function(){
			$(this).toggleClass('active');
		});

		$('.gb-auto-color').each(function(){
			var bgc = $(this).closestStyle('backgroundColor');
			var tc = $(this).closestStyle('color');

			console.log('tc: ' + tc);
			console.log('bgc: ' + bgc);

			if ( !bgc )
				bgc = $(this).closestStyle('background');

			$(this).css({
				backgroundColor: bgc,
				borderColor: tc
			});

			$(this)
				.attr('data-active-bgc', tc )
				.attr('data-active-tc', bgc );
		});

		$('.gb-auto-color.active').css({
			backgroundColor: $(this).data('active-bgc'),
			color: $(this).data('active-tc')
		});
	});
})(jQuery);