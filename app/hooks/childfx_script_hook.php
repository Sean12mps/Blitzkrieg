<?php
/**
 * blitzkrieg
 *
 * blitzkrieg Theme by Calibrefx Team
 *
 * @package     blitzkrieg
 * @author      Calibrefx Team
 * @link        http://www.calibrefx.com/
 * @since       Version 1.0
 * @filesource 
 *
 * @package blitzkrieg
 */
add_action('admin_init', 'blitz_load_admin_scripts');
/**
 * This function loads the admin CSS files
 */
function blitz_load_admin_scripts() {
    wp_enqueue_style('blitz-admin', CHILD_CSS_URL . '/admin.style.css');
    wp_enqueue_script('blitz-admin', CHILD_JS_URL . '/admin.functions.js', array('jquery'));
}


add_action('init', 'blitz_register_scripts');
/**
 * This function register our style and script files
 */
function blitz_register_scripts(){   
    wp_enqueue_style('blitz-metroCSS', CHILD_CSS_URL . '/metro-bootstrap.min.css');
    wp_enqueue_style('blitz-metroIcon', CHILD_CSS_URL . '/iconFont.min.css');

    wp_register_script('blitz-UI', CHILD_JS_URL . '/jQueryUI.js', array('jquery'));
    wp_register_script('blitz-wheel', CHILD_JS_URL . '/mousewheel.js', array('jquery'));
    wp_register_script('blitz-petrify', CHILD_JS_URL . '/petrify.js', array('jquery'));
    wp_register_script('blitz-metro', CHILD_JS_URL . '/metro.min.js', array('jquery'));
    // wp_register_script('blitz-metroload', CHILD_JS_URL . '/metro-loader.js', array('jquery'));
    wp_register_script('blitz-functions', CHILD_JS_URL . '/functions.js', array('jquery'));
}

/**
 * This function load our style and script files
 */
add_action('calibrefx_meta', 'blitz_load_script');
function blitz_load_script(){   
    wp_enqueue_style('blitz-admin');
	wp_enqueue_style('blitz-metroCSS');
	wp_enqueue_style('blitz-metroIcon');

	wp_enqueue_script('blitz-UI');
	wp_enqueue_script('blitz-wheel');
	wp_enqueue_script('blitz-petrify');
    // wp_enqueue_script('blitz-metro');
	// wp_enqueue_script('blitz-metroload');
	wp_enqueue_script('blitz-functions');
    
}


