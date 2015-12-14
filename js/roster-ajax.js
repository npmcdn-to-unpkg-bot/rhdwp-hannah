(function($){
	var $tableContainer = $("#roster-table-container");
	var loader = '<svg id="roster-loader" width="124px" height="124px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-gear"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><path d="M75,50.5l5-1.5c-0.1-2.2-0.4-4.3-0.9-6.3l-5.2-0.1c-0.2-0.6-0.4-1.1-0.6-1.7l4-3.3c-0.9-1.9-2-3.8-3.2-5.5L69.2,34 c-0.4-0.5-0.8-0.9-1.2-1.3l2.4-4.6c-1.6-1.4-3.3-2.7-5.1-3.8l-3.7,3.6c-0.5-0.3-1.1-0.5-1.6-0.8l0.5-5.2c-2-0.7-4-1.3-6.2-1.6 l-2.1,4.8c-0.6-0.1-1.2-0.1-1.8-0.1l-1.5-5c-2.2,0.1-4.3,0.4-6.3,0.9l-0.1,5.2c-0.6,0.2-1.1,0.4-1.7,0.6l-3.3-4 c-1.9,0.9-3.8,2-5.5,3.2l1.9,4.9c-0.5,0.4-0.9,0.8-1.3,1.2l-4.6-2.4c-1.4,1.6-2.7,3.3-3.8,5.1l3.6,3.7c-0.3,0.5-0.5,1.1-0.8,1.6 l-5.2-0.5c-0.7,2-1.3,4-1.6,6.2l4.8,2.1c-0.1,0.6-0.1,1.2-0.1,1.8l-5,1.5c0.1,2.2,0.4,4.3,0.9,6.3l5.2,0.1c0.2,0.6,0.4,1.1,0.6,1.7 l-4,3.3c0.9,1.9,2,3.8,3.2,5.5l4.9-1.9c0.4,0.5,0.8,0.9,1.2,1.3l-2.4,4.6c1.6,1.4,3.3,2.7,5.1,3.8l3.7-3.6c0.5,0.3,1.1,0.5,1.6,0.8 l-0.5,5.2c2,0.7,4,1.3,6.2,1.6l2.1-4.8c0.6,0.1,1.2,0.1,1.8,0.1l1.5,5c2.2-0.1,4.3-0.4,6.3-0.9l0.1-5.2c0.6-0.2,1.1-0.4,1.7-0.6 l3.3,4c1.9-0.9,3.8-2,5.5-3.2L66,69.2c0.5-0.4,0.9-0.8,1.3-1.2l4.6,2.4c1.4-1.6,2.7-3.3,3.8-5.1l-3.6-3.7c0.3-0.5,0.5-1.1,0.8-1.6 l5.2,0.5c0.7-2,1.3-4,1.6-6.2l-4.8-2.1C74.9,51.7,75,51.1,75,50.5z M50,65c-8.3,0-15-6.7-15-15c0-8.3,6.7-15,15-15s15,6.7,15,15 C65,58.3,58.3,65,50,65z" fill="#5274e2"><animateTransform attributeName="transform" type="rotate" from="0 50 50" to="90 50 50" dur="1s" repeatCount="indefinite"></animateTransform></path></svg>';
	
	$(".roster-key a").on('click', function(e){
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
				$tableContainer
					.children('.roster-table')
					.fadeOut('fast');
				
				$tableContainer.prepend(loader);
				
				$("#roster-loader").animate({
					'opacity': 1
				});
			},
			success : function( response ) {
				$tableContainer.fadeOut('', function(){
					$tableContainer
						.html( response )
						.fadeIn();
				});
			},
			complete : function(){
				$("#roster-loader").fadeOut(function(){
					$(this).remove();
				});
			}
		});
	});
})(jQuery);