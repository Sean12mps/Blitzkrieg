jQuery(document).ready(function($) {
     var fileInput = false,
        change_image = false,
        upload_field = false,
        $upload_field_input = null,
        $id_field_input = null;

    $( 'body' ).delegate( '.image_upload', 'click', function(){
        fileInput = true;
        change_image = true;
        $upload_field_input = $(this).parent().siblings('.image_url');
        $id_field_input = $(this).parent().siblings('.image_id');
        tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
        return false;
    });

    jQuery('.wp-color-picker-field').wpColorPicker();
   
    jQuery('body').delegate( '.image_reset', 'click', function(){
        $(this).parent().siblings('.image_url').val('');
        $(this).parent().siblings('.image_id').val('');
        $(this).parent().siblings('.image_preview').html('');

        return false;
    });


    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html){
        var img = $(html).find('img'),
        	classes = img.attr('class'),  
            id = classes.replace(/(.*?)wp-image-/, ''); 

        if ( fileInput ) {
            $upload_field_input.val( $(html).find('img').attr('src') );
            $id_field_input.val( id );
        
            $upload_field_input.val( $(html).find('img').attr('src') );
            $id_field_input.val( id );
            $upload_field_input.parent().find('.image_preview').html(img);
            tb_remove();
            fileInput = false;
        } else {
            window.original_send_to_editor( html );
        }
    }
});