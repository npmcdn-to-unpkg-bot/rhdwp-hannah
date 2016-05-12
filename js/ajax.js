(function($){

	function getPage( $elem ){
		return parseInt( $elem.parents('span').data('target-page') );
	}

	// Look for a secondary query localization, if not found, set to main query.
	if ( typeof wp_custom_data !== 'undefined' ) {
		qv = wp_custom_data.query_vars;
	} else {
		qv = wp_data.query_vars;
	}

	var $posts = $('.blog-container');


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

					// Stuff...

				} else {
					$('html,body').animate({
						scrollTop: 0
					}, 750, "swing");

					$posts.find('article').fadeOut('fast', function(){
						$(this).remove();
					});
				}

				$posts.after('<div id="loading"><img src="' + wp_data.img_dir + '/loading.gif" alt="Loading more posts..."></div>');

				$('.pagination').fadeOut('fast', function(){
					$(this).remove();
				});
			},
			success: function( html ) {
				$("#loading").fadeOut('fast', function(){
					$(this).remove();
				});

				$('.pagination').data('current-page', page );

				if (loadMore) {

					$html = $(html);

					packeryAppend($posts, $html);
				} else {
					$posts.fadeOut(750, function(){
						$(this).append(html);
						$(this).fadeIn();
					});
				}
			}
		});
	});

})(jQuery);