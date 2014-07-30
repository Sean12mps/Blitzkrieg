<?php
/*
Module Name: Contact Module
Module URI: http://www.calibrefx.com/module/calibrefx-contact
Description: Calibrefx Contact Module. Add contact setting, contact fields shortcode, contact form shortcode, google map javascript api.
Version: 1.0.0
Author: Calibrefx
Author URI: http://www.calibrefx.com/
*/

!defined('CONTACT_URL') && define('CONTACT_URL', CHILD_URL . '/app/modules/contact');

include_once 'contact_widget.php';

add_action('calibrefx_meta', 'contact_load_script');
function contact_load_script(){
	wp_enqueue_script( 'contact-script', CONTACT_URL . '/assets/js/contact.js', array('jquery') );
    wp_enqueue_style( 'contact-style', CONTACT_URL . '/assets/css/contact.css' );
}

add_action('admin_init', 'contact_load_admin_scripts');
function contact_load_admin_scripts(){
    wp_enqueue_style('admin-contact-style', CONTACT_URL . '/assets/css/contact.admin.css');
}

add_filter( 'calibrefx_theme_settings_defaults', 'contact_theme_settings_default', 10, 1 );
function contact_theme_settings_default($default_arr = array()){
    $contact_default = array();

    return array_merge($default_arr, $contact_default);
}

add_action( 'calibrefx_theme_settings_meta_section', 'contact_meta_sections' );
function contact_meta_sections(){
    global $calibrefx_target_form;
    
    calibrefx_add_meta_section('contact', __('Contact Settings', 'calibrefx'), $calibrefx_target_form, 20);
}

add_action( 'calibrefx_theme_settings_meta_box', 'contact_meta_boxes' );
function contact_meta_boxes(){
	global $calibrefx;

	calibrefx_add_meta_box('contact', 'basic', 'contact-settings', __('Contact Detail', 'calibrefx'), 'contact_settings', $calibrefx->theme_settings->pagehook, 'main', 'low');
	calibrefx_add_meta_box('contact', 'basic', 'map-settings', __('Map Detail', 'calibrefx'), 'map_settings', $calibrefx->theme_settings->pagehook, 'main', 'low');
}

function contact_settings(){
	$contact_name = stripslashes(esc_attr(calibrefx_get_option('contact_name')));
	$contact_email = stripslashes(esc_attr(calibrefx_get_option('contact_email')));
	$contact_phone = stripslashes(esc_attr(calibrefx_get_option('contact_phone')));
	$contact_mobile_phone = stripslashes(esc_attr(calibrefx_get_option('contact_mobile_phone')));
	$contact_address = stripslashes(esc_attr(calibrefx_get_option('contact_address')));
    $contact_detail = stripslashes(esc_attr(calibrefx_get_option('contact_detail')));

    $contact_company_name = stripslashes(esc_attr(calibrefx_get_option('contact_company_name')));
    $contact_company_email = stripslashes(esc_attr(calibrefx_get_option('contact_company_email')));
    $contact_company_phone = stripslashes(esc_attr(calibrefx_get_option('contact_company_phone')));
    $contact_company_fax = stripslashes(esc_attr(calibrefx_get_option('contact_company_fax')));
    $contact_company_address = stripslashes(esc_attr(calibrefx_get_option('contact_company_address')));
    $contact_company_work_day = stripslashes(esc_attr(calibrefx_get_option('contact_company_work_day')));
    $contact_company_work_hour = stripslashes(esc_attr(calibrefx_get_option('contact_company_work_hour')));
?>
<h3 class="section-title"><?php _e('Personal Info', 'calibrefx'); ?></h3>
<div id="personal-info-settings">
    <div class="section-row">
        <div class="section-col">
            <p>
                <label for="calibrefx-settings[contact_name]"><?php _e('Contact Name', 'calibrefx'); ?></label>
                <input type="text" name="calibrefx-settings[contact_name]" id="calibrefx-settings[contact_name]" value="<?php echo $contact_name; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_email]"><?php _e('Email Address', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_email]" id="calibrefx-settings[contact_email]" value="<?php echo $contact_email; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_phone]"><?php _e('Phone Number', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_phone]" id="calibrefx-settings[contact_phone]" value="<?php echo $contact_phone; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_mobile_phone]"><?php _e('Mobile Phone Number', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_mobile_phone]" id="calibrefx-settings[contact_mobile_phone]" value="<?php echo $contact_mobile_phone; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_address]"><?php _e('Address', 'calibrefx'); ?></label><br />
                <textarea name="calibrefx-settings[contact_address]" id="calibrefx-settings[contact_address]" rows="6"><?php echo $contact_address; ?></textarea>
            </p>
            <p>
                <label for="calibrefx-settings[contact_detail]"><?php _e('Contact Detail', 'calibrefx'); ?></label><br />
                <textarea name="calibrefx-settings[contact_detail]" id="calibrefx-settings[contact_detail]" rows="6"><?php echo $contact_detail; ?></textarea>
            </p>
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <p><?php _e("Enter your name. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your email address. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your phone number. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your mobile phone number. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your address. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
            </div>
        </div>   
    </div>
</div>

<h3 class="section-title"><?php _e('Company Info', 'calibrefx'); ?></h3>
<div id="personal-info-settings">
    <div class="section-row">
        <div class="section-col">
            <p>
                <label for="calibrefx-settings[contact_company_name]"><?php _e('Company Name', 'calibrefx'); ?></label>
                <input type="text" name="calibrefx-settings[contact_company_name]" id="calibrefx-settings[contact_company_name]" value="<?php echo $contact_company_name; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_company_email]"><?php _e('Company Email Address', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_company_email]" id="calibrefx-settings[contact_company_email]" value="<?php echo $contact_company_email; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_company_phone]"><?php _e('Company Phone Number', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_company_phone]" id="calibrefx-settings[contact_company_phone]" value="<?php echo $contact_company_phone; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_company_fax]"><?php _e('Company Fax Number', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_company_fax]" id="calibrefx-settings[contact_company_fax]" value="<?php echo $contact_company_fax; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_company_work_day]"><?php _e('Company Working Days', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_company_work_day]" id="calibrefx-settings[contact_company_work_day]" value="<?php echo $contact_company_work_day; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_company_work_hour]"><?php _e('Company Working Hours', 'calibrefx'); ?></label><br />
                <input type="text" name="calibrefx-settings[contact_company_work_hour]" id="calibrefx-settings[contact_company_work_hour]" value="<?php echo $contact_company_work_hour; ?>" />
            </p>
            <p>
                <label for="calibrefx-settings[contact_company_address]"><?php _e('Company Address', 'calibrefx'); ?></label><br />
                <textarea name="calibrefx-settings[contact_company_address]" id="calibrefx-settings[contact_company_address]" rows="6"><?php echo $contact_company_address; ?></textarea>
            </p>
        </div>
        <div class="section-col last">
            <div class="section-desc">
                <p><?php _e("Enter your company name. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your company email address. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your company phone number. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your company fax number. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>

                <p><?php _e("Enter your company working days. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your company working hours. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
                
                <p><?php _e("Enter your company address. It will be shown if using the Contact Widget.", 'calibrefx'); ?></p>
            </div>
        </div>   
    </div>
</div>

<?php
}

function map_settings(){
	$map_x = stripslashes(esc_attr(calibrefx_get_option('map_x')));
	$map_y = stripslashes(esc_attr(calibrefx_get_option('map_y')));
	$map_url = stripslashes(esc_attr(calibrefx_get_option('map_url')));
?>
<div id="map-detail-setting">

    <div class="row-options">
        <label for="calibrefx-settings[map_url]"><strong><?php _e('Google Map Embed URL', 'calibrefx'); ?></strong></label><br />
        <textarea name="calibrefx-settings[map_url]" id="calibrefx-settings[map_url]" rows="6" placeholder='<?php _e('Example', 'calibrefx'); ?>: <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3966.7527831053176!2d106.82347299999999!3d-6.1638534499999995!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d9881b132b%3A0xe268d076bd69fb6!2sCalibreWorks+-+Web+Design+%26+Development+in+Jakarta!5e0!3m2!1sid!2s!4v1395129544221" width="600" height="450" frameborder="0" style="border:0"></iframe>'><?php echo $map_url; ?></textarea>
        <p><?php printf(__('Enter google map embed url. Read more about this <a href="%s" target="_blank">here</a>.', 'calibrefx'), 'https://support.google.com/maps/answer/3544418'); ?></p>
    </div>

    <hr class="div advance-separator" />

    <label class="advance">
        <input type="checkbox" name="" id="map_advance_option_checker" value=""<?php checked( 1, calibrefx_get_option('map_advance_option') ); ?> /><?php _e('Show advanced option', 'calibrefx'); ?>
        <input type="hidden" name="calibrefx-settings[map_advance_option]" id="map_advance_option" value="<?php echo (calibrefx_get_option('map_advance_option')  ? 1 : 0); ?>" />
    </label>

    <div id="map-detail-advance-setting"<?php echo (calibrefx_get_option('map_advance_option')  ? ' style="display:block;"' : ''); ?>>
        <div class="row-options">
            <label for="calibrefx-settings[map_x]"><strong><?php _e('Longitude Coordinate (x-axis)', 'calibrefx'); ?></strong></label><br />
            <input type="text" name="calibrefx-settings[map_x]" id="calibrefx-settings[map_x]" value="<?php echo $map_x; ?>" />
            <p><?php _e('Enter the longitude coordinate of the location on google map.', 'calibrefx'); ?></p>
        </div>

        <hr class="div" />

        <div class="row-options">
            <label for="calibrefx-settings[map_y]"><strong><?php _e('Latitude Coordinate (y-axis)', 'calibrefx'); ?></strong></label><br />
            <input type="text" name="calibrefx-settings[map_y]" id="calibrefx-settings[map_y]" value="<?php echo $map_y; ?>" />
            <p><?php _e('Enter the latitude coordinate of the location on google map.', 'calibrefx'); ?></p>
        </div>

        <hr class="div" />

        <p class="note"><?php _e('Use this option if you want to show map based on map coordinates on google map. The map will be shown using google map javascript API.', 'calibrefx'); ?></p>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#map_advance_option_checker').change(function(){
        if(this.checked){
            $('#map-detail-advance-setting').slideDown();
            $('#map_advance_option').val('1');
        }else{
            $('#map-detail-advance-setting').slideUp();
            $('#map_advance_option').val('0');
        }
    });
});
</script>
<?php
}

/* Contact Shortcode
------------------------------------------------------------ */
add_shortcode('map', 'contact_do_gmap');
function contact_do_gmap($atts, $content = null) {
    extract(shortcode_atts(array(
        'id' => '',
        'x' => '',
        'y' => '',
        'title' => '',
        'height' => '350'
    ), $atts));

    if(empty($x) || empty($y)) return;

    $id = ( $id == '' ) ? "random-googlemap-id-".rand(0,1000) : $id ;

    $output = '<div class="gmap-container"><div class="thumbnail" style="height:'.$height.'px;"><div id="'.$id.'"  class="googlemap" style="width:100%; height:'.$height.'px;"></div></div></div>';
    $output .= '<script type="text/javascript">eventMaps.push({id:"'.$id.'", x:"'.$x.'", y:"'.$y.'", title:"'.$title.'"});</script>';

    return $output;
}

add_shortcode('contact_map', 'contact_do_map');
function contact_do_map($atts, $content = null) {
    extract(shortcode_atts(array(
        'type' => 'gmap',
        'height' => '300'
    ), $atts));

    $map_x = stripslashes(esc_attr(calibrefx_get_option('map_x')));
	$map_y = stripslashes(esc_attr(calibrefx_get_option('map_y')));
	$map_url = stripslashes(esc_attr(calibrefx_get_option('map_url')));

    if($type == 'gmap'){
    	$output = '[map x="'.$map_x.'" y="'.$map_y.'" height="'.$height.'"]';
    }elseif($type == 'url'){
    	$output = '[gmap]'.html_entity_decode($map_url).'[/gmap]';
    }else{
    	$output = '<div class="alert alert-error">'.__('There is no map datas', 'calibrefx').'</div>';
    }

    return do_shortcode( $output );
}

add_shortcode('contact_name', 'contact_do_name');
function contact_do_name($atts, $content = null) {
    $contact_name = stripslashes(esc_attr(calibrefx_get_option('contact_name')));

    return $contact_name;
}

add_shortcode('contact_email', 'contact_do_email');
function contact_do_email($atts, $content = null) {
    $contact_email = stripslashes(esc_attr(calibrefx_get_option('contact_email')));

    return $contact_email;
}

add_shortcode('contact_phone', 'contact_do_phone');
function contact_do_phone($atts, $content = null) {
    $contact_phone = stripslashes(esc_attr(calibrefx_get_option('contact_phone')));

    return $contact_phone;
}

add_shortcode('contact_mobile_phone', 'contact_do_mobile_phone');
function contact_do_mobile_phone($atts, $content = null) {
    $contact_mobile_phone = stripslashes(esc_attr(calibrefx_get_option('contact_mobile_phone')));

    return $contact_mobile_phone;
}

add_shortcode('contact_address', 'contact_do_address');
function contact_do_address($atts, $content = null) {
    $contact_address = stripslashes(esc_attr(calibrefx_get_option('contact_address')));

    return $contact_address;
}

add_shortcode('contact_detail', 'contact_do_detail');
function contact_do_detail($atts, $content = null) {
    $contact_detail = stripslashes(esc_attr(calibrefx_get_option('contact_detail')));

    return $contact_detail;
}

add_shortcode('contact_company_name', 'contact_do_company_name');
function contact_do_company_name($atts, $content = null) {
    $contact_company_name = stripslashes(esc_attr(calibrefx_get_option('contact_company_name')));

    return $contact_company_name;
}

add_shortcode('contact_company_email', 'contact_do_company_email');
function contact_do_company_email($atts, $content = null) {
    $contact_company_email = stripslashes(esc_attr(calibrefx_get_option('contact_company_email')));

    return $contact_company_email;
}

add_shortcode('contact_company_phone', 'contact_do_company_phone');
function contact_do_company_phone($atts, $content = null) {
    $contact_company_phone = stripslashes(esc_attr(calibrefx_get_option('contact_company_phone')));

    return $contact_company_phone;
}

add_shortcode('contact_company_fax', 'contact_do_company_fax');
function contact_do_company_fax($atts, $content = null) {
    $contact_company_fax = stripslashes(esc_attr(calibrefx_get_option('contact_company_fax')));

    return $contact_company_fax;
}

add_shortcode('contact_company_work_hour', 'contact_do_company_work_hour');
function contact_do_company_work_hour($atts, $content = null) {
    $contact_company_work_hour = stripslashes(esc_attr(calibrefx_get_option('contact_company_work_hour')));

    return $contact_company_work_hour;
}

add_shortcode('contact_company_work_day', 'contact_do_company_work_day');
function contact_do_company_work_day($atts, $content = null) {
    $contact_company_work_day = stripslashes(esc_attr(calibrefx_get_option('contact_company_work_day')));

    return $contact_company_work_day;
}

add_shortcode('contact_company_address', 'contact_do_company_address');
function contact_do_company_address($atts, $content = null) {
    $contact_company_address = stripslashes(esc_attr(calibrefx_get_option('contact_company_address')));

    return $contact_company_address;
}