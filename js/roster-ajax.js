(function($){
	$(".roster-key a").on('click', function(e){
		var $tableContainer = $("#roster-table-container");
		
		e.preventDefault();
		var $this = $(this),
			ltr = $this.data('key'),
			cur = $this.data('current');
		
		$.ajax({
			url : roster.ajax_url,
			type : 'post',
			data : {
				action : 'rhd_print_roster_table',
				letter : ltr,
				current: cur
			},
			beforeSend : function() {
				$tableContainer.fadeOut('fast');
			},
			success : function( response ) {
				$tableContainer.fadeOut('', function(){
					$tableContainer
						.html( response )
						.fadeIn();
				});
			}
		});
	});
})(jQuery);