<?php
/**
 * blitzkrieg
 *
 * blitzkrieg Theme
 *
 * @package		  blitzkrieg
 * @author		  CalibreWorks
 * @link		  http://www.calibreworks.com
 * @since		  Version 1.0.0
 * @filesource 
 *
 */

/**
 * Include CalibreFx init file, this is our engine
 */
require_once(TEMPLATEPATH . '/system/Bootloader.php');
global $calibrefx;

define('CHILD_THEME_NAME', 'blitzkrieg');
define('CHILD_THEME_URL', 'http://www.calibreworks.com');
define('CHILD_THEME_VERSION', '1.0.0');
define('CHILD_THEME_DB_VERSION', '1');

//Header on right
add_theme_support('calibrefx-wraps', array('header', 'subnav', 'inner', 'footer', 'footer-widget'));

//Remove mobile menu
remove_theme_support( "mobile-site-menu" );

//We start our engine
$calibrefx->load->add_child_path(CHILD_URI . '/app');

//Load the autoload
$calibrefx->load->do_autoload(CHILD_URI . '/app/config/autoload.php');

///////////////////////////////////////////////////////////////////////

add_image_size('post-archive', 620, 175, true);

function get_post_data($postId) {
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID=$postId");
}