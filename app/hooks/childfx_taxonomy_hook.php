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

/*
add_action('init', 'kca_register_community');
function kca_register_community() {
    $args = array(
        'labels' => array(
            'name' => __('Communities'),
            'singular_name' => __('Community'),
            'add_new_item' => __('Add New Community'),
            'edit_item' => __('Edit Community'),
            'new_item' => __('New Community'),
            'edit_item' => __('Edit Community'),
            'view_item' => __('View Community'),
            'search_items' => __('Search Community'),
            'not_found' => __('Community Not Found'),
            'not_found_in_trash' => __('No Community found in Trash'),
        ),
        'description' => 'Communities or Companies',
        'public' => true,
        'menu_position' => 5,
        'show_ui' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'community'),
        'capability_type' => 'post',
        'support' => array('title', 'editor'),
        'register_meta_box_cb' => 'kca_community_box',
    );

    register_post_type('community', $args);
    add_post_type_support('community', array('custom-fields', 'thumbnail', 'calibrefx-seo', 'calibrefx-layouts'));
}
*/