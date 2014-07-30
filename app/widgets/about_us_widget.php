<?php
/**
 * KCA
 *
 * KCA Theme by Calibrefx Team
 *
 * @package     kca
 * @author      Calibrefx Team
 * @link        http://www.calibrefx.com/
 * @since       Version 1.0
 * @filesource 
 *
 * @package kca
 */

class CFX_About_Us_Widget extends WP_Widget {

    protected $defaults;

    /**
     * Constructor
     */
    function __construct() {

        $this->defaults = array(
            'title' => '',
            'image_url' => '',
            'desc' => '',
            'image_id' => '',
            'readmore_link' => '',           
        );

        $widget_ops = array(
            'classname' => 'about-us-widget',
            'description' => __('Display About Us Content', 'calibrefx'),
        );

        $this->WP_Widget('about-us-widget', __('About Us Widget (CalibreFx)', 'calibrefx'), $widget_ops);
    }

    /**
     * Display widget content.
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    function widget($args, $instance) {
        global $post;
        $temp = $post;

        extract($args);
        $instance = wp_parse_args((array) $instance, $this->defaults);

        
        echo $before_widget;

        if (!empty($instance['title']))
            echo $before_title . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $after_title;

        echo '<div class="about-us-wrapper">';

        if(!empty($instance['image_url']) || !empty($instance['image_id'])){
            $post = get_post($instance['image_id']);

            if($post !== NULL){
                $img = calibrefx_get_image(array('format' => 'html', 'size' => 'medium', 'id' => $instance['image_id']));
            }else{
                $img = '<img src="'.$instance['target_url'].'" alt="About Us" />';
            }

            echo '<div class="about-us-image">'.$img.'</div>';
        } 

        if(!empty($instance['desc'])){
            $desc = stripslashes($instance['desc']);
            $desc = wpautop($desc);
            $desc = do_shortcode(shortcode_unautop($desc));

            echo '<div class="about-us-content">'.$desc;

            if(!empty($instance['readmore_link'])) echo '<a href="'.$instance['readmore_link'].'" class="about-us-more-link">Read More...</a>';

            echo '</div>';  
        } 

        // echo '<h4 class="about-us-social-title widgettitle">STAY CONNECTED</h4>';
        
        // echo '<ul class="about-us-social-link">';

        // $fb_url = esc_attr(calibrefx_get_option('facebook_fanpage'));
        // $tw_url = esc_attr(calibrefx_get_option('twitter_profile'));
        // $youtube_url = esc_attr(calibrefx_get_option('youtube_channel'));
        // $gplus_url = esc_attr(calibrefx_get_option('gplus_page'));
        // $pinterest_profile = esc_attr(calibrefx_get_option('pinterest_profile'));

        // if(!empty($fb_url)) echo '<li class="facebook-widget"><a href="'.$fb_url.'" title="View Us on Facebook">View Us on Facebook</a></li>';
        // if(!empty($tw_url)) echo '<li class="twitter-widget"><a href="'.$tw_url.'" title="View Our Latest Tweets">View Our Latest Tweets</a></li>';
        // if(!empty($gplus_url)) echo '<li class="gplus-widget"><a href="'.$gplus_url.'" title="View Our Google+ Page">View Our Google+ Page</a></li>';
        // if(!empty($youtube_url)) echo '<li class="youtube-widget"><a href="'.$youtube_url.'" title="View Our Youtube Channel">View Our Youtube Channel</a></li>';
        // if(!empty($pinterest_profile)) echo '<li class="pinterest-widget"><a href="'.$pinterest_profile.'" title="View Our Pinterest Page">View Our Pinterest Page</a></li>';
        

        // echo '</ul>';

        echo '</div>';

        echo $after_widget;
    }

    /**
     * Update a particular instance.
     */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /**
     * Display the settings update form.
     */
    function form($instance) {
        $instance = wp_parse_args((array) $instance, $this->defaults);
        $image_url = esc_attr($instance['image_url']);
        $image_id = esc_attr($instance['image_id']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sukm'); ?>:</label><br />
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
        </p>

        <div class="controls">
            <label for="<?php echo $this->get_field_id('image_url'); ?>">Image</label>
            <input type="text" name="<?php echo $this->get_field_name('image_url'); ?>" id="<?php echo $this->get_field_id('image_url'); ?>" value="<?php echo $image_url; ?>" class="uploaded-input image_url widefat" />
            <input type="hidden" id="<?php echo $this->get_field_id('image_id'); ?>" name="<?php echo $this->get_field_name('image_id'); ?>" class="image_id" value="<?php echo $image_id; ?>" />
            <div class="upload_button_div">
                <span class="button image_upload_button image_upload" id="upload_custom_logo">Upload Image</span>
                <span class="button image_reset_button hide image_reset" id="reset_custom_logo">Remove</span>
                <div class="clear"></div>
            </div>
            <?php if(empty($image_url)){ ?>
            <div class="preview_image image_preview" id="preview_logo"></div>
            <?php }else{ ?>
             <div class="preview_image image_preview" id="preview_logo"><img src="<?php echo $image_url; ?>" /></div>
            <?php } ?>
        </div>

        <p>
            <label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Description', 'sukm'); ?>:</label><br />
            <textarea id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" class="widefat" rows="8"><?php echo esc_attr($instance['desc']); ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('readmore_link'); ?>"><?php _e('Read More Link', 'sukm'); ?>:</label><br />
            <input type="text" id="<?php echo $this->get_field_id('readmore_link'); ?>" name="<?php echo $this->get_field_name('readmore_link'); ?>" value="<?php echo esc_attr($instance['readmore_link']); ?>" class="widefat" />
        </p>
        <?php
    }

}