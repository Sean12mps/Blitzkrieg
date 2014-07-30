<?php
/*
Module Name: Logo & Background Module
Module URI: http://www.calibrefx.com/module/logo-background-module
Description: Calibrefx Logo & Background Module. Easily change your logo, favicon and website background.
Version: 1.1
Author: Calibrefx
Author URI: http://www.calibrefx.com/
*/

add_action('init', 'custom_design_setup', 0);
add_action('wp_enqueue_scripts', 'custom_design_style');
add_action('wp_enqueue_scripts', 'custom_design_logo');

if(calibrefx_is_module_active(__FILE__)){
    remove_theme_support('calibrefx-custom-header');
    remove_theme_support('calibrefx-custom-background');
}

if(is_admin() AND calibrefx_is_module_active(__FILE__)){
    add_action( 'admin_init', function() {
        wp_enqueue_media();
        wp_enqueue_script('custom-design-js', CHILD_URL . '/app/modules/custom-design/js/custom.js', array('jquery', 'media-upload'), false, true);
    } );
    add_action( 'calibrefx_theme_settings_meta_box', 'custom_design_meta_boxes' );
}

/********************
 * FUNCTIONS BELOW  *
 ********************/

// Check if custom logo if available
function custom_design_setup(){
    
    add_filter('calibrefx_favicon_url', 'custom_design_favicon');
    
    add_action('calibrefx_before_save_core', 'custom_design_save_core');
}

function custom_design_save_core(){ 
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    if(!isset($_POST['calibrefx-settings'])) return;

    $custom_logo = $_POST['calibrefx-settings']['custom_logo']; 
    $custom_logo_id = $_POST['calibrefx-settings']['custom_logo_id'];

    if($custom_logo && $custom_logo_id){
        global $post;

        $temp = $post;

        $post = get_post($custom_logo_id);

        if($post !== NULL){
            $logo_url = calibrefx_get_image(array('format' => 'url', 'id' => $custom_logo_id));
        }else{
            $logo_url = $custom_logo;
        }

        $image = @getimagesize($logo_url);

        if($image){ 
            $width = absint($image[0]);
            $height = absint($image[1]);  

            $_POST['calibrefx-settings']['header_image_width'] = $width;
            $_POST['calibrefx-settings']['header_image_height'] = $height;
        }

        $post = $temp;
    } 
}

function custom_design_logo(){
    global $post;

    $temp = $post;

    $text_color = "#f1f1f1";

    $logo = esc_attr(calibrefx_get_option('custom_logo'));
    $logo_id = esc_attr(calibrefx_get_option('custom_logo_id'));
    $display_text = esc_attr(calibrefx_get_option('header_display_text'));
    $text_color = esc_attr(calibrefx_get_option('header_text_color'));
    $width = esc_attr(calibrefx_get_option('header_image_width'));
    $height = esc_attr(calibrefx_get_option('header_image_height'));

    $post = get_post($logo_id);

    if($post !== NULL){
        $logo_url = calibrefx_get_image(array('format' => 'url', 'id' => $logo_id));
    }else{
        $logo_url = $logo;
    }

    if($logo_url AND !$display_text){
        $custom_css = "#header-title { 
    background: url($logo_url) no-repeat left center; 
    width: ".$width."px; 
    height: ".$height."px;
}
#title, #title a, #title a:hover{ 
    display: block; 
    margin: 0; 
    overflow: hidden; 
    padding: 0;
    text-indent: -9999px; 
    width: ".$width."px; 
    height: ".$height."px;
}
p#description{
    display: block; 
    margin: 0; 
    overflow: hidden; 
    padding: 0;
    text-indent: -9999px; 
}";
    }else{
        $custom_css = "#title, #title a{ 
    color: $text_color
}";
    }

    wp_add_inline_style( 'calibrefx-child-style', $custom_css );
}

function custom_design_favicon(){
	global $post;

	$temp = $post;

	$favicon = esc_attr(calibrefx_get_option('custom_favicon'));
    $favicon_id = esc_attr(calibrefx_get_option('custom_favicon_id'));

    $post = get_post($favicon_id);

    if($post !== NULL){
    	$favicon_url = calibrefx_get_image(array('format' => 'url', 'id' => $favicon_id));
    }elseif(!empty($favicon)){
    	$favicon_url = $favicon;
    }else{
    	return;
    }

    $post = $temp;

    return $favicon_url;
}

function custom_design_meta_boxes(){
    global $calibrefx;

    // calibrefx_add_meta_box('design', 'basic', 'custom-logo', __('Logo Settings', 'calibrefx'), 'custom_design_logo_settings', $calibrefx->theme_settings->pagehook, 'main', 'high');
    // calibrefx_add_meta_box('design', 'basic', 'custom-background', __('Background Settings', 'calibrefx'), 'custom_design_background_settings', $calibrefx->theme_settings->pagehook, 'main', 'high');
    
    calibrefx_add_meta_box('design', 'basic', 'custom-design', __('Design Settings', 'calibrefx'), 'custom_design_settings', $calibrefx->theme_settings->pagehook, 'main', 'high');
}

function custom_design_settings(){
    global $calibrefx;

    calibrefx_add_meta_group('custom-design', 'custom-logo-settings', __('Logo & Favicon', 'calibrefx'));
    calibrefx_add_meta_group('custom-design', 'custom-background-settings', __('Background', 'calibrefx'));

    add_action( 'custom-design_options', function(){
        /*calibrefx_add_meta_option(
            'custom-logo-settings',  // group id
            'custom_logo_id', // field id and option name
            __('Logo ID','calibrefx'), // Label
            array(
                'option_type' => 'hidden',
                'option_default' => '',
                'option_filter' => 'safe_url',
                'option_attr' => array("class" => "image_id"),
                'option_description' => '',
            ), // Settings config
            1 //Priority
        );*/

        calibrefx_add_meta_option(
            'custom-logo-settings',  // group id
            'custom_logo', // field id and option name
            __('Your Logo','calibrefx'), // Label
            array(
                'option_type' => 'upload',
                'option_default' => '',
                'option_filter' => 'safe_url',
                'option_attr' => array("class" => "image_url halfwidth"),
                'option_description' => __("You can change upload your logo by pressing the upload image button", 'calibrefx'),
            ), // Settings config
            10 //Priority
        );

        calibrefx_add_meta_option(
            'custom-logo-settings',  // group id
            'custom_favicon', // field id and option name
            __('Your Favicon','calibrefx'), // Label
            array(
                'option_type' => 'upload',
                'option_default' => '',
                'option_filter' => 'safe_url',
                'option_attr' => array("class" => "image_url halfwidth"),
                'option_description' => __("You can change upload your favicon recommended size 32x32 px", 'calibrefx'),
            ), // Settings config
            10 //Priority
        );
    });

    add_action( 'custom-design_options', function(){
        calibrefx_add_meta_option(
            'custom-background-settings',  // group id
            'background_image', // field id and option name
            __('Custom Background Image','calibrefx'), // Label
            array(
                'option_type' => 'upload',
                'option_default' => '',
                'option_filter' => 'safe_url',
                'option_attr' => array("class" => "image_url halfwidth"),
                'option_description' => __("You can change upload your favicon recommended size 32x32 px", 'calibrefx'),
            ), // Settings config
            10 //Priority
        ); 

        calibrefx_add_meta_option(
            'custom-background-settings',  // group id
            'background_color', // field id and option name
            __('Body Background Color','calibrefx'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '#0000ff',
                'option_filter' => 'safe_text',
                'option_attr' => array("class" => "cfx-color-picker-field"),
                'option_description' => __("This settings is to change body background color. (default: <code>#0000ff</code>)", 'calibrefx'),
            ), // Settings config
            10 //Priority
        );

        calibrefx_add_meta_option(
            'custom-background-settings',  // group id
            'content_color', // field id and option name
            __('Content Background Color','calibrefx'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '#0000ff',
                'option_filter' => 'safe_text',
                'option_attr' => array("class" => "cfx-color-picker-field"),
                'option_description' => __("This settings is to change content area background color. (default: <code>#0000ff</code>)", 'calibrefx'),
            ), // Settings config
            15 //Priority
        );
    });        

    calibrefx_do_meta_options($calibrefx->theme_settings, 'custom-design');
}

function custom_design_logo_settings(){
    $logo = esc_attr(calibrefx_get_option('custom_logo'));
    $logo_id = esc_attr(calibrefx_get_option('custom_logo_id'));
    $favicon = esc_attr(calibrefx_get_option('custom_favicon'));
    $favicon_id = esc_attr(calibrefx_get_option('custom_favicon_id'));

    $display_text = esc_attr(calibrefx_get_option('header_display_text'));
    $text_color = esc_attr(calibrefx_get_option('header_text_color'));
?>
    <div class="section-row">
        <div class="section-col">
            
            <div class="section-line">
                <p><label for="custom_logo"><strong>Custom Logo</strong></label></p>
                <input type="text" name="calibrefx-settings[custom_logo]" id="custom_logo" value="<?php echo $logo; ?>" class="uploaded-input image_url" />
                <input type="hidden" name="calibrefx-settings[custom_logo_id]" class="image_id" value="<?php echo $logo_id; ?>" />
                <div class="upload_button_div">
                    <span class="button image_upload_button image_upload" id="upload_custom_logo">Upload Image</span>
                    <span class="button image_reset_button hide image_reset" id="reset_custom_logo">Remove</span>
                    <div class="clear"></div>
                </div>
            </div>
           
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <?php if(empty($logo)){ ?>
                <div class="preview_image image_preview" id="preview_logo"></div>
                <?php }else{ ?>
                <div class="preview_image image_preview" id="preview_logo"><img src="<?php echo $logo; ?>" /></div>
                <?php } ?>

                <!--<p class="description">Recommended image size <?php //echo CHILD_LOGO_WIDTH; ?>x<?php //echo CHILD_LOGO_HEIGHT; ?> pixels</p>-->
            </div>
        </div>   
    </div>

    <div class="section-row">
        <div class="section-col">
            
            <div class="section-line last">
                <label for="calibrefx-checkbox-display-header-text">
                    <strong><?php _e("Show header text instead your logo?", 'calibrefx'); ?></strong>
                    <input type="checkbox" name="" target="calibrefx-display-header-text" value="1" id="calibrefx-checkbox-display-header-text" class="calibrefx-settings-checkbox" <?php checked(1, $display_text); ?> /> 
                </label>
                <input type="hidden" name="calibrefx-settings[header_display_text]" id="calibrefx-display-header-text" value="<?php echo $display_text; ?>" />
            
                
            </div>
           
        </div>
        <div class="section-col last">
            <div class="section-desc">
                
            </div>
        </div>   
    </div>

    <div class="controls custom-font-style-container custom-header-text-color-container">
        <div class="section-row margin-bottom-10">
            <div class="section-col">
                
                <div class="section-line last">
                        
                        <label for="header_text_color"><strong>Header Text color</strong></label>
                        <div class="custom-font-style-wrapper" style="float:right">
                            <input type="text" name="calibrefx-settings[header_text_color]" id="header_text_color" data-default-color="#333333" class="wp-color-picker-field" value="<?php echo $text_color; ?>" style/>
                        </div>
                        
                </div>
               
            </div>
            <div class="section-col last">
                <div class="section-desc">
                    <p class="description">define your header text color here.</p>
                </div>
            </div>   
        </div>
    </div>

    <div class="section-row">
        <div class="section-col">
            
            <div class="section-line last">
                <p><label for="custom_favicon"><strong>Custom Favicon</strong></label></p>
                <input type="text" name="calibrefx-settings[custom_favicon]" id="custom_favicon" value="<?php echo $favicon; ?>" class="uploaded-input image_url" />
                <input type="hidden" name="calibrefx-settings[custom_favicon_id]" class="image_id" value="<?php echo $favicon_id; ?>" />
                <div class="upload_button_div">
                    <span class="button image_upload_button image_upload" id="upload_custom_logo">Upload Image</span>
                    <span class="button image_reset_button hide image_reset" id="reset_custom_logo">Remove</span>
                    <div class="clear"></div>
                </div>
            </div>
           
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <?php if(empty($favicon)){ ?>
                <div class="preview_image image_preview" id="preview_logo"></div>
                <?php }else{ ?>
                <div class="preview_image image_preview" id="preview_logo"><img src="<?php echo $favicon; ?>" /></div>
                <?php } ?>
                <p class="description">Recommended image size 16 x 16 pixels</p>
            </div>
        </div>   
    </div>

    <style type="text/css">
    <?php if(!$display_text) { ?>
    .custom-header-text-color-container{
        display: none;
    }
    <?php } ?>
    </style>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#calibrefx-checkbox-display-header-text').click(function(){
            if($(this).attr('checked')){
                $('.custom-header-text-color-container').slideDown();
            }else{
                $('.custom-header-text-color-container').slideUp();
            }
        });
    });
    </script>
<?php   
}

function custom_design_background_settings(){
    $background_image = esc_attr(calibrefx_get_option('background_image'));
    $background_image_id = esc_attr(calibrefx_get_option('background_image_id'));
    $background_color = esc_attr(calibrefx_get_option('background_color'));
    $content_color = esc_attr(calibrefx_get_option('content_color'));
?>
    <div class="controls">
        <p><label for="background_image"><strong>Background Image</strong></label></p>
        <input type="text" name="calibrefx-settings[background_image]" id="background_image" value="<?php echo $background_image; ?>" class="uploaded-input image_url" />
        <input type="hidden" name="calibrefx-settings[background_image_id]" id="background_image_id" value="<?php echo $background_image_id; ?>" class="image_id" />
        <div class="upload_button_div">
            <span class="button image_upload_button image_upload" id="upload_custom_background">Upload Image</span>
            <span class="button image_reset_button hide image_reset" id="reset_custom_background">Remove</span>
            <div class="clear"></div>
        </div>
        <?php if(empty($background_image)){ ?>
        <div class="preview_image image_preview"></div>
        <?php }else{ ?>
         <div class="preview_image image_preview"><img src="<?php echo $background_image; ?>" /></div>
        <?php } ?>
        <p class="description">Upload your custom background image above.</p>
    </div>

    <hr class="div"/>

    <div class="controls">
        <p><label for="background_color"><strong>Main Body Background Color</strong></label></p>
        
        <input type="text" name="calibrefx-settings[background_color]" id="background_color" data-default-color="#0000ff" class="wp-color-picker-field" value="<?php echo $background_color; ?>" />
            
        <p class="description">Define your main body background color here.</p>
    </div>

    <hr class="div"/>

    <div class="custom-font-style-container">
        <p><label for="content_color"><strong>Content Background Color</strong></label></p>
        
        <input type="text" name="calibrefx-settings[content_color]" id="content_color" data-default-color="#0000ff" class="wp-color-picker-field" value="<?php echo $content_color; ?>" />

        <p class="description">Define your content background color here</p>
    </div>
<?php
}

function custom_design_style(){
    global $post;
    $temp = $post;

    $background_image = esc_attr(calibrefx_get_option('background_image'));
    $background_image_id = esc_attr(calibrefx_get_option('background_image_id'));
    $background_color = esc_attr(calibrefx_get_option('background_color'));
    $content_color = esc_attr(calibrefx_get_option('content_color'));

    $custom_css = "";

    if(!empty($background_image) || !empty($background_image_id)){
        $post = get_post($background_image_id);

        if($post !== NULL){
            $background_img = calibrefx_get_image(array('format' => 'url', 'id' => $background_image_id));
        }elseif(!empty($background_image)){
            $background_img = $background_image;
        }
    }

    $background_image_css = (!empty($background_img) ? "background-image :  url($background_img);" : '');
    $background_color_css = (!empty($background_color) ? "background-color : $background_color;" : '');
    $content_color_css = (!empty($content_color) ? "background-color : $content_color;" : '');

    $custom_css = "
#wrapper{
    {$background_image_css}
    {$background_color_css}
}
#inner{
    {$content_color_css}
}";

    $post = $temp;

    wp_add_inline_style( 'calibrefx-child-style', $custom_css );
}