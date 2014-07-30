jQuery(document).ready(function($) {
	// Uploading files
	var file_frame,
		$upload_field_input = null,
        $id_field_input = null,
        $image_preview = null;
 
  	jQuery('.upload_image_button').live('click', function( event ){
 
    	event.preventDefault();
    	$upload_field_input = $(this).parent().siblings('.image_url');
        $id_field_input = $(this).parent().siblings('.image_id');
        $image_preview = $(this).parent().siblings('.image_preview').find('img');
        console.log($image_preview);
 
	    // If the media frame already exists, reopen it.
	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }
 
	    // Create the media frame.
	    file_frame = wp.media.frames.file_frame = wp.media({
	      	title: jQuery( this ).data( 'uploader_title' ),
	      	button: {
	        	text: jQuery( this ).data( 'uploader_button_text' ),
	      	},
	      	multiple: false  // Set to true to allow multiple files to be selected
	    });
	 
	    // When an image is selected, run a callback.
	    file_frame.on( 'select', function() {
	      // We set multiple to false so only get one image from the uploader
	      attachment = file_frame.state().get('selection').first().toJSON();
	 
	      // Do something with attachment.id and/or attachment.url here
	      $upload_field_input.val( attachment.url );
          $id_field_input.val( attachment.id );
          $image_preview.attr('src', attachment.url);
	    });
	 
	    // Finally, open the modal
	    file_frame.open();
	});

	jQuery('.image_reset').live('click', function(event){
        $(this).parent().siblings('.image_url').val('');
        $(this).parent().siblings('.image_id').val('');
        $(this).parent().siblings('.image_preview').html('');

        return false;
	});
});