(function($){

	$(document).on('click', '.blog-area .pagination a', function(e){
		e.preventDefault();

		page = parseInt( $(this).parents('span').data('target-page') );

		// Look for a secondary query localization, if not found, set to main query.
		if ( wp_custom_data ) {
			qv = wp_custom_data.query_vars;
		} else {
			qv = wp_data.query_vars;
		}

		$.ajax({
			url: wp_data.ajax_url,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: qv,
				page: page
			},
			beforeSend: function() {
				$('html,body').animate({
					scrollTop: 0
				}, 750, "swing");

				$('.blog-container').find('article').fadeOut('fast', function(){
					$(this).remove();
				});

				$('.pagination').fadeOut('fast', function(){
					$(this).remove();
				});

				// AJAX LOAD ANIMATION
			},
			success: function( html ) {
				$('.pagination').data('current-page', page );
				$('.blog-container').fadeOut(750, function(){
					$(this).append(html);
					$(this).fadeIn();
				});
			}
		});
	});

})(jQuery);
