(function($){

	function getPage( $elem ){
		return parseInt( $elem.parents('span').data('target-page') );
	}

	// Look for a secondary query localization, if not found, set to main query.
	if ( wp_custom_data ) {
		qv = wp_custom_data.query_vars;
	} else {
		qv = wp_data.query_vars;
	}


	$(document).on('click', '.blog-area .pagination a', function(e){

		e.preventDefault();

		if ( $(this).parents('span').hasClass('pag-load-more') )
			loadMore = true;
		else
			loadMore = false;

		page = getPage($(this));

		$.ajax({
			url: wp_data.ajax_url,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: qv,
				page: page,
				load_more: loadMore
			},
			beforeSend: function() {
				if (loadMore){

				} else {
					$('html,body').animate({
						scrollTop: 0
					}, 750, "swing");

					$('.blog-container').find('article').fadeOut('fast', function(){
						$(this).remove();
					});
				}

				$('.pagination').fadeOut('fast', function(){
					$(this).remove();
				});

				// Loader
			},
			success: function( html ) {
				if (loadMore) {
					$('.pagination').data('current-page', page );
					$('.blog-container').append(html);
				} else {
					$('.pagination').data('current-page', page );
					$('.blog-container').fadeOut(750, function(){
						$(this).append(html);
						$(this).fadeIn();
					});
				}
			}
		});
	});

})(jQuery);