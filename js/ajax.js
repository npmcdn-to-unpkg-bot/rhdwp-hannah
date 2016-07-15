// Look for a secondary query localization, if not found, set to main query.
if ( typeof wp_custom_data !== 'undefined' ) {
	qv = wp_custom_data.query_vars;
} else {
	qv = wp_data.query_vars;
}

function getPage( $elem ){
	return parseInt( $elem.parents('span').data('target-page') );
}

(function($){
/*
	if ( $(".post-grid").hasClass('packery') )
		$grid = initPackery();
*/

	$(document).on('click', '.ajax-pagination .pagination a', function(e){

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
				grid_size: $('.post-grid').data('grid-size'),
				page: page,
				load_more: loadMore
			},
			beforeSend: function() {
				if (loadMore){

				} else {
					$('html,body').animate({
						scrollTop: 0
					}, 750, "swing");

					$('.post-grid').find('article').fadeOut('fast', function(){
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
					$grid.append(html);
					$('.pagination').appendTo('#primary');

					$grid.packery('reloadItems');
					$grid.imagesLoaded().progress(function(){
						$grid.packery('layout');
					});
				} else {
					$('.pagination').data('current-page', page );
					$('.post-grid').fadeOut(750, function(){
						$(this).append(html);
						$(this).fadeIn();
					});
				}
			}
		});
	});

})(jQuery);
