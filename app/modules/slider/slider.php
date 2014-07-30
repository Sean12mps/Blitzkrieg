<?php
/*
Module Name: Slider Module
Module URI: http://www.calibrefx.com/module/slider-module
Description: Calibrefx Slider Module. Easily add slider to homepage using hook, shortcode or widget
Version: 1.0.0
Author: Calibrefx
Author URI: http://www.calibrefx.com/
*/
/**
 * Slider
 *
 * Slider Module by Calibrefx Team
 *
 * @package		slider
 * @author		Calibrefx Team
 * @link		http://www.calibrefx.com/
 * @since		Version 1.0.0
 * @filesource 
 *
 */

add_action('init', 'slider_register_posttype');

if(is_admin() AND calibrefx_is_module_active(__FILE__)){
    add_action('admin_menu', 'slider_metabox',5);
    add_action('save_post', 'slider_metabox_save', 1, 2);
    add_action( 'calibrefx_theme_settings_meta_section', 'slider_meta_sections' );
    add_action( 'calibrefx_theme_settings_meta_box', 'slider_meta_boxes' );
}

/********************
 * FUNCTIONS BELOW  *
 ********************/

!defined('SLIDER_URL') && define('SLIDER_URL', CHILD_URL . '/app/modules/slider');

function slider_register_posttype() {
    $args = array(
        'labels' => array(
            'name' => __('Sliders', 'calibrefx'),
            'singular_name' => __('Slider', 'calibrefx'),
            'add_new_item' => __('Add New Slider', 'calibrefx'),
            'edit_item' => __('Edit Slider', 'calibrefx'),
            'new_item' => __('New Slider', 'calibrefx'),
            'edit_item' => __('Edit Slider', 'calibrefx'),
            'view_item' => __('View Slider', 'calibrefx'),
            'search_items' => __('Search Slider', 'calibrefx'),
            'not_found' => __('Slider Not Found', 'calibrefx'),
            'not_found_in_trash' => __('No slider found in Trash', 'calibrefx'),
        ),
        'description' => __('Slider', 'calibrefx'),
        'public' => true,
        'menu_position' => 26,
        'show_ui' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'slider'),
        'menu_icon' => SLIDER_URL . '/assets/img/icon-slider.png'
    );

    register_post_type('slider', $args);
    add_post_type_support('slider', array('thumbnail', 'title'));
    remove_post_type_support('slider', 'editor');

    $tax_args = array(
        'labels' => array(
            'name' => __('Slider Categories', 'calibrefx'),
            'singular_name' => __('Slider Category', 'calibrefx'),
            'add_new_item' => __('Add New Slider Category', 'calibrefx'),
            'edit_item' => __('Edit Slider Category', 'calibrefx'),
            'update_item' => __('Update Slider Category', 'calibrefx'),
            'new_item' => __('New Slider Category', 'calibrefx'),
            'edit_item' => __('Edit Slider Category', 'calibrefx'),
            'view_item' => __('View Slider Category', 'calibrefx'),
            'search_items' => __('Search Slider Category', 'calibrefx'),
            'menu_name' => __( 'Slider Categories', 'calibrefx'),
        ),
        'public' => true,
        'show_ui' => true,
        'rewrite' => array('slug' => 'slidercat', 'hierarchical' => true),
        'hierarchical' => true
    );

    register_taxonomy('slidercat', 'slider', $tax_args);
    //add_image_size('service-thumb', apply_filters('service_thumb_width', '480'), apply_filters('service_thumb_height', '265'), true);
}

function slider_homepage_display(){
    $use_slider = calibrefx_get_option('use_slider');
    $slider_category = calibrefx_get_option('slider_category');
    $slider_speed = calibrefx_get_option('slider_speed');
    $slider_pause = calibrefx_get_option('slider_pause');
    $slider_effect = calibrefx_get_option('slider_effect');
    $slider_num = calibrefx_get_option('slider_num');
    $use_paging = calibrefx_get_option('use_paging');
    $use_nav = calibrefx_get_option('use_nav');
    $use_caption = calibrefx_get_option('use_caption');

    $slider_output = '';

    if((is_front_page()) && $use_slider ){
        if($slider_category){
            $args = array(
                'post_type' => 'slider',
                'posts_per_page' => $slider_num,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'slidercat',
                        'field' => 'id',
                        'terms' => $slider_category
                    )
                )
            );
        }else{
            $args = array(
                'post_type' => 'slider',
                'posts_per_page' => $slider_num
            );
        }

        $query = new WP_Query($args);

        if($query->have_posts()) :

            $slider_wrapper_class = apply_filters( 'calibrefx_slider_wrapper_class', 'homepage-slider-wrapper wrap container' );
            $slider_class = apply_filters( 'calibrefx_slider_class', 'homepage-slider' );
            $slider_id = apply_filters( 'calibrefx_slider_id', 'homepage-slider' );
            echo '<div id="'.$slider_id.'">';
            echo '<div class="'.$slider_wrapper_class.'">';

            while($query->have_posts()) : $query->the_post();
                $img = calibrefx_get_image(array('format' => 'url', 'size' => 'slider-image'));
                $slider_title = calibrefx_get_custom_field('slider_title');
                $slider_title = ((!empty($slider_title)) ? $slider_title : get_the_title());
                $slider_url = calibrefx_get_custom_field('slider_link');

                $slider_output .= '[slider_item src="'.$img.'" title="'.$slider_title.'" url="'.$slider_url.'"][/slider_item]';
            endwhile;

            $attr = ' class="'.$slider_class.'"';
            if(!empty($slider_pause)) $attr .= ' interval="'.$slider_pause.'"';
            if(!empty($slider_speed)) $attr .= ' speed="'.$slider_speed.'"';
            if(!empty($slider_effect)) $attr .= ' fx="'.$slider_effect.'"';
            if(!empty($use_paging)) $attr .= ' pager="'.$use_paging.'"';
            if(!empty($use_nav)) $attr .= ' next_prev="'.$use_nav.'"';
            if(!empty($use_caption)) $attr .= ' caption="'.$use_caption.'"';

            echo do_shortcode( '[slider'.$attr.']'.$slider_output.'[/slider]' );

            echo '</div>';
            echo '</div>';

        endif;

        wp_reset_query();
        wp_reset_postdata();
    }
}
add_action(apply_filters('calibrefx_slider_hook', 'calibrefx_after_header'), 'slider_homepage_display');

add_shortcode('cfx_slider', 'print_slider');
function print_slider($atts, $content = ''){
    extract(shortcode_atts(array(
        'slider_category' => '',
        'slider_speed' => '',
        'slider_pause' => '',
        'slider_effect' => '',
        'slider_num' => '5',
        'use_paging' => '',
        'use_nav' => '',
        'use_caption' => '',
        'size' => 'full'
    ), $atts));

    if($slider_category){
        $args = array(
            'post_type' => 'slider',
            'posts_per_page' => $slider_num,
            'tax_query' => array(
                array(
                    'taxonomy' => 'slidercat',
                    'field' => 'id',
                    'terms' => $slider_category
                )
            )
        );
    }else{
        $args = array(
            'post_type' => 'slider',
            'posts_per_page' => $slider_num
        );
    }

    $query = new WP_Query($args);

    $output = '';
    $slider_output = '';

    if($query->have_posts()) :

        while($query->have_posts()) : $query->the_post();
            $img = calibrefx_get_image(array('format' => 'url', 'size' => $size));
            $slider_title = calibrefx_get_custom_field('slider_title');
            $slider_title = ((!empty($slider_title)) ? $slider_title : get_the_title());
            $slider_url = calibrefx_get_custom_field('slider_link');

            $slider_output .= '[slider_item src="'.$img.'" title="'.$slider_title.'" url="'.$slider_url.'"][/slider_item]';
        endwhile;

        $attr = '';
        if(!empty($slider_pause)) $attr .= ' interval="'.$slider_pause.'"';
        if(!empty($slider_speed)) $attr .= ' speed="'.$slider_speed.'"';
        if(!empty($slider_effect)) $attr .= ' fx="'.$slider_effect.'"';
        if(!empty($use_paging)) $attr .= ' pager="'.$use_paging.'"';
        if(!empty($use_nav)) $attr .= ' next_prev="'.$use_nav.'"';
        if(!empty($use_caption)) $attr .= ' caption="'.$use_caption.'"';

        $output .= '[slider'.$attr.']'.$slider_output.'[/slider]';

    endif;

    wp_reset_query();
    wp_reset_postdata();

    return do_shortcode($output);
}

function slider_meta_sections(){
    global $calibrefx_target_form;
    
    calibrefx_add_meta_section('slider', __('Slider Settings', 'calibrefx'), $calibrefx_target_form, 10);
}

function slider_meta_boxes(){
    global $calibrefx;

    calibrefx_add_meta_box('slider', 'basic', 'slider-settings', __('Homepage Slider Settings', 'calibrefx'), 'slider_settings', $calibrefx->theme_settings->pagehook, 'main', 'low');
}

/**
 * Display slider settings form in Calibrefx admin page
 */
function slider_settings(){
?>
<div class="row-options">
    <label for="calibrefx-settings[use_slider]">Use slider in homepage?</label><br />
    <select name="calibrefx-settings[use_slider]" id="calibrefx-settings[use_slider]">
        <option value="0"<?php selected(0, calibrefx_get_option('use_slider')); ?>><?php _e('No', 'calibrefx'); ?></option>
        <option value="1"<?php selected(1, calibrefx_get_option('use_slider')); ?>><?php _e('Yes', 'calibrefx'); ?></option>
    </select>
    <p class="description"><?php _e("Please select 'Yes' if you want to include slider in homepage. The slider will be placed under primary menu. Leave it to 'No' if you dont want to include slider or want to include slider manually."); ?></p>
    <hr class="div" />
</div>

<div class="row-options">
    <label for="calibrefx-settings[slider_category]">Slider Category</label><br />
    <select name="calibrefx-settings[slider_category]" id="calibrefx-settings[slider_category]">
        <option value=""><?php _e('All Categories', 'calibrefx'); ?></option>
    <?php
        $terms = get_terms('slidercat', 'hide_empty=0');

        foreach($terms as $term){
            echo '<option value="'.$term->term_id.'"'.selected($term->term_id, calibrefx_get_option('slider_category'), false).'>'.$term->name.'</option>';
        }
    ?>
    </select>
    <p class="description"><?php _e("This will display slider based on a category. Leave it 'All' if you want to display all slider items."); ?></p>
    <hr class="div" />
</div>

<div class="row-options">
    <label for="calibrefx-settings[slider_num]">Number of Slider Images</label><br />
    <input type="text" name="calibrefx-settings[slider_num]" id="calibrefx-settings[slider_num]" value="<?php echo esc_attr(calibrefx_get_option('slider_num')); ?>" />
    <p class="description"><?php _e('Please enter number of slider images to be displayed. Enter -1 if you want to display all slider images.'); ?></p>
    <hr class="div" />
</div>

<div class="row-options">
    <label for="calibrefx-settings[slider_speed]">Slide Speed</label><br />
    <input type="text" name="calibrefx-settings[slider_speed]" id="calibrefx-settings[slider_speed]" value="<?php echo esc_attr(calibrefx_get_option('slider_speed')); ?>" />
    <p class="description"><?php _e('Please enter your slideshow speed, eg. 700'); ?></p>
    <hr class="div" />
</div>

<div class="row-options">
    <label for="calibrefx-settings[slider_pause]">Slide Interval</label><br />
    <input type="text" name="calibrefx-settings[slider_pause]" id="calibrefx-settings[slider_pause]" value="<?php echo esc_attr(calibrefx_get_option('slider_pause')); ?>" />
    <p class="description"><?php _e('The duration between each slide transition'); ?></p>
    <hr class="div" />
</div>

<div class="row-options">
    <label for="calibrefx-settings[slider_effect]">Slide Effect</label><br />
    <select name="calibrefx-settings[slider_effect]" id="calibrefx-settings[slider_effect]">
        <?php 
            $order_params = array(
                'fade' => __('Fade', 'calibrefx'),
                'fadeOut' => __('Fade Out', 'calibrefx'),
                'scrollHorz' => __('Scroll Horizontal', 'calibrefx'),
                'none' => __('None', 'calibrefx'),
            );

            foreach ($order_params as $value => $name)
                echo '<option value="' . esc_attr($value) . '"' . selected(calibrefx_get_option('slider_effect'), esc_attr($value), false) . '>' . esc_html($name) . '</option>' . "\n";
        ?>
    </select>
    <p class="description"><?php _e('Please select transition types for your slideshow translation effect.'); ?></p>
</div>

<div class="row-options">
    <label for="calibrefx-settings[use_paging]">Use pagination?</label><br />
    <select name="calibrefx-settings[use_paging]" id="calibrefx-settings[use_paging]">
        <option value="0"<?php selected(0, calibrefx_get_option('use_paging')); ?>><?php _e('No', 'calibrefx'); ?></option>
        <option value="1"<?php selected(1, calibrefx_get_option('use_paging')); ?>><?php _e('Yes', 'calibrefx'); ?></option>
    </select>
    <p class="description"><?php _e("Select 'Yes' if you want to include paging in your slider."); ?></p>
    <hr class="div" />
</div>

<div class="row-options">
    <label for="calibrefx-settings[use_nav]">Use navigation?</label><br />
    <select name="calibrefx-settings[use_nav]" id="calibrefx-settings[use_nav]">
        <option value="0"<?php selected(0, calibrefx_get_option('use_nav')); ?>><?php _e('No', 'calibrefx'); ?></option>
        <option value="1"<?php selected(1, calibrefx_get_option('use_nav')); ?>><?php _e('Yes', 'calibrefx'); ?></option>
    </select>
    <p class="description"><?php _e("Select 'Yes' if you want to include previous & next navigation in your slider."); ?></p>
    <hr class="div" />
</div>

<div class="row-options">
    <label for="calibrefx-settings[use_caption]">Use caption?</label><br />
    <select name="calibrefx-settings[use_caption]" id="calibrefx-settings[use_caption]">
        <option value="0"<?php selected(0, calibrefx_get_option('use_caption')); ?>><?php _e('No', 'calibrefx'); ?></option>
        <option value="1"<?php selected(1, calibrefx_get_option('use_caption')); ?>><?php _e('Yes', 'calibrefx'); ?></option>
    </select>
    <p class="description"><?php _e("Select 'Yes' if you want to include caption in your slider."); ?></p>
</div>
<?php    
}

/**
 * Add Slider meta box to the post area
 */
function slider_metabox() {
    add_meta_box('slider_detail_metabox', __('Slider Details', 'calibrefx'), 'slider_detail_metabox', 'slider', 'normal', 'high');
}

/**
 * Display Slider meta data form
 */
function slider_detail_metabox(){
    wp_nonce_field('slider_detail_action', 'slider_detail_nonce');
?>

<p><label for="slider_title" style="display:block"><b><?php _e('Title', 'calibrefx'); ?></b></label></p>
<p><input class="large-text" type="text" name="slider_title" id="slider_title" value="<?php echo esc_attr(calibrefx_get_custom_field('slider_title')); ?>" /></p>
<p class="description"><?php _e('Enter custom title for your slider image.', 'calibrefx'); ?></p>

<p><label for="slider_link" style="display:block"><b><?php _e('Link', 'calibrefx'); ?></b></label></p>
<p><input class="large-text" type="text" name="slider_link" id="slider_link" value="<?php echo esc_attr(calibrefx_get_custom_field('slider_link')); ?>" /></p>
<p class="description"><?php _e('Enter custom link for your slider image.', 'calibrefx'); ?></p>

<?php
}

/**
 * Save slider meta data to post meta
 */
function slider_metabox_save($post_id, $post){
    global $calibrefx;

    if(!$calibrefx->security->verify_nonce('slider_detail_action', 'slider_detail_nonce')){    
        return $post_id; 
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    if (defined('DOING_CRON') && DOING_CRON)
        return;

    if (!current_user_can('edit_page', $post_id) || !current_user_can('edit_post', $post_id))
        return $post_id;    
        
    $slider_link = sanitize_text_field($_POST['slider_link']);
    
    if ($slider_link)
        update_post_meta($post_id, 'slider_link', $slider_link);
    else
        delete_post_meta($post_id, 'slider_link');

    $slider_title = sanitize_text_field($_POST['slider_title']);
    
    if ($slider_title)
        update_post_meta($post_id, 'slider_title', $slider_title);
    else
        delete_post_meta($post_id, 'slider_title');
}

/**
 * Add default value to theme settings option when setting saved
 */
function slider_theme_settings_default($default_arr = array()){
    $slider_default = array(
        'slider_speed' => '700',
        'slider_effect' => 'fade',
        'slider_pause' => '3000',
        'slider_num' => '5',
        'use_slider' => '0'
    );

    return array_merge($default_arr, $slider_default);
}
add_filter( 'calibrefx_theme_settings_defaults', 'slider_theme_settings_default', 10, 1 );