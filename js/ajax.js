(function($){

	$(document).on('click', '.blog-area .pagination a', function(e){
		e.preventDefault();

		page = parseInt( $(this).parents('span').data('target-page') );
		//page = ( 1 < page ) ? page + 1 : page;

		$.ajax({
			url: wp_data.ajax_url,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: wp_data.query_vars,
				page: page
			},
			beforeSend: function() {
				$('html,body').animate({
					scrollTop: 0
				}, 750, "linear", function(){
					$('.blog-container').find('article').fadeOut('fast', function(){
						$(this).remove();
					});

					$('.pagination').fadeOut('fast', function(){
						$(this).remove();
					});
				});
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