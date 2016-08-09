/*
 * Attaches the media uploader to the input field
 */
jQuery(document).ready(function($){

	// Show/hide selected options
	if ( $("#rhd-page-overlay-style-cta").is(":checked") ) {
		$("#rhd-page-overlay-cta-options").show();
		$("#rhd-page-overlay-image-options").hide();
	} else if ( $("#rhd-page-overlay-style-image").is(":checked") ) {
		$("#rhd-page-overlay-image-options").show();
		$("#rhd-page-overlay-cta-options").hide();
	}

	$("input[type=radio][name=rhd-page-overlay-style]").change(function(){

		if ( $(this).attr('value') == 'cta' ) {
			$("#rhd-page-overlay-cta-options").slideDown();
			$("#rhd-page-overlay-image-options").slideUp();
		} else if ( $(this).attr('value') == 'image' ) {
			$("#rhd-page-overlay-image-options").slideDown();
			$("#rhd-page-overlay-cta-options").slideUp();
		} else {
			$("#rhd-page-overlay-cta-options, #rhd-page-overlay-image-options").slideUp();
		}
	});

	$("#rhd-page-overlay-clear-image").click(function(e){
		e.preventDefault();

		$('#rhd-page-overlay-image-id').attr( 'value', '' );
        $('#rhd-page-overlay-image img').attr('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
        $('#rhd-page-overlay-image figcaption').text('');
	});

    // Instantiates the variable that holds the media library frame.
    var meta_media_frame;

    // Runs when the media button is clicked.
    $('#rhd-page-overlay-image-button').click(function(e){

        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if ( meta_media_frame ) {
            meta_media_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_media_frame = wp.media.frames.meta_media_frame = wp.media({
            title: rhd_page_overlay.title,
            button: { text:  rhd_page_overlay.button }
        });

        // Runs when a file is selected.
        meta_media_frame.on('select', function(){

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_media_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom media input field.
            $('#rhd-page-overlay-image-id').attr( 'value', media_attachment.id );

            $('#rhd-page-overlay-image img').attr('src', media_attachment.sizes.medium.url);
            $('#rhd-page-overlay-image figcaption').text( media_attachment.title );
        });

        // Opens the media library frame.
        meta_media_frame.open();
    });
});