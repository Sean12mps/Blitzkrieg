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
add_action('admin_init', 'kca_load_admin_scripts');
/**
 * This function loads the admin CSS files
 */
function kca_load_admin_scripts() {
    wp_enqueue_style('kca-admin', CHILD_CSS_URL . '/admin.style.css');

    wp_enqueue_script('kca-admin', CHILD_JS_URL . '/admin.functions.js', array('jquery'));
}


add_action('init', 'kca_register_scripts');
/**
 * This function register our style and script files
 */
function kca_register_scripts(){   
    wp_enqueue_style('metro-bootstrap', CHILD_CSS_URL . '/metro-bootstrap.min.css');
    wp_enqueue_style('iconFont', CHILD_CSS_URL . '/iconFont.min.css');

    wp_register_script('kca-functions', CHILD_JS_URL . '/functions.js', array('jquery'));
}

/**
 * This function load our style and script files
 */
add_action('calibrefx_meta', 'kca_load_script');
function kca_load_script(){   
	wp_enqueue_style('metro-bootstrap');
	wp_enqueue_style('iconFont');
	wp_enqueue_script('kca-functions');
    
}


