<?php
/*
Module Name: Webfont Module
Module URI: http://www.calibrefx.com/module/calibrefx-webfont
Description: Calibrefx Webfont Module. Add Google Webfont to customize header and body font type and size.
Version: 1.1
Author: Calibrefx
Author URI: http://www.calibrefx.com/
*/

global $calibrefx, $fonts, $cfxgenerator;

$fonts = apply_filters( 'calibrefx_webfont', array(
    'Arial' => array(
                'font-family' => 'Arial, Helvetica, sans-serif;',
                'google-font' => false,
            ),
    'Helvetica' => array(
                'font-family' => 'Helvetica, Arial, sans-serif;',
                'google-font' => false,
            ),
    'Calibri' => array(
                'font-family' => 'Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;',
                'google-font' => false,
            ),
    'Verdana' => array(
                'font-family' => 'Verdana, Geneva, sans-serif;',
                'google-font' => false,
            ),
    'Trebuchet' => array(
                'font-family' => '"Trebuchet MS", Arial, Helvetica, sans-serif;',
                'google-font' => false,
            ),
    'Georgia' => array(
                'font-family' => 'Georgia, "Times New Roman", Times, serif;',
                'google-font' => false,
            ),
    'Times' => array(
                'font-family' => '"Times New Roman", Times, serif;',
                'google-font' => false,
            ),
    'Tahoma' => array(
                'font-family' => 'Tahoma, Geneva, sans-serif;',
                'google-font' => false,
            ),
    'Palatino Linotype' => array(
                'font-family' => '"Palatino Linotype", "Book Antiqua", Palatino, serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Droid Sans' => array(
                'font-family' => '"Droid Sans", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Droid Serif' => array(
                'font-family' => '"Droid Serif", Georgia, "Times New Roman", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Open Sans' => array(
                'font-family' => '"Open Sans", Verdana, Geneva, sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,600,700',
            ),
    'Ubuntu' => array(
                'font-family' => '"Ubuntu", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Ubuntu Mono' => array(
                'font-family' => '"Ubuntu Mono", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Abel' => array(
                'font-family' => '"Abel", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Lato' => array(
                'font-family' => '"Lato", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Raleway' => array(
                'font-family' => '"Raleway", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Noticia Text' => array(
                'font-family' => '"Noticia Text", serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'PT Sans' => array(
                'font-family' => '"PT Sans", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'PT Sans Caption' => array(
                'font-family' => '"PT Sans Caption", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'PT Serif' => array(
                'font-family' => '"PT Serif", sans-serif;',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Signika' => array(
                'font-family' => '"Signika", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Signika Negative' => array(
                'font-family' => '"Signika Negative", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Istok Web' => array(
                'font-family' => '"Istok Web", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Titillium Web' => array(
                'font-family' => '"Titillium Web", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,600,700',
            ),
    'Grand Hotel' => array(
                'font-family' => '"Grand Hotel", cursive',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Lora' => array(
                'font-family' => '"Lora", serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
    'Montserrat' => array(
                'font-family' => '"Montserrat", sans-serif',
                'google-font' => true,
                'google-font-style' => '400,700',
            ),
));


add_action( 'calibrefx_meta',  'webfont_load_fonts', 80);
add_action( 'wp_enqueue_scripts',  'webfont_styles');

if(is_admin() AND calibrefx_is_module_active(__FILE__)){
    add_action( 'admin_init', 'webfont_load_colorpicker');
    add_action( 'calibrefx_theme_settings_meta_box', 'webfont_meta_boxes' );
    add_filter( 'calibrefx_theme_settings_defaults', 'webfont_theme_settings_default', 10, 1 );
}

/********************
 * FUNCTIONS BELOW  *
 ********************/

function webfont_load_fonts() {
    global $fonts;

    $body_font = calibrefx_get_option('custom_font_family');
    $header_font = calibrefx_get_option('custom_header_font_family');
    $font_loaded = array();

    if(isset($fonts[$body_font]['google-font']) && $fonts[$body_font]['google-font']){
        $font_style = $fonts[$body_font]['google-font-style'];
        $font_name = str_replace(' ', '+', $body_font);
        $font_loaded[] = $font_name.':'.$font_style;
    }

    if(isset($fonts[$header_font]['google-font']) && $fonts[$header_font]['google-font']){
        $font_style = $fonts[$header_font]['google-font-style'];
        $font_name = str_replace(' ', '+', $header_font);
        $font_loaded[] = $font_name.':'.$font_style;
    }

    $font_loaded = implode('|', $font_loaded);
    if($font_loaded)
        echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$font_loaded.'" media="screen">';
}

function webfont_styles(){
    global $calibrefx, $fonts;

    wp_enqueue_style('webfont-style', CHILD_URL . '/app/modules/webfont/css/webfont.css' );
    
    $body_font = calibrefx_get_option('custom_font_family');
    $header_font = calibrefx_get_option('custom_header_font_family');
    $custom_font_size = calibrefx_get_option('custom_font_size');
    $custom_font_color = calibrefx_get_option('custom_font_color');
    $custom_permalink_color = calibrefx_get_option('custom_permalink_color');
    $custom_permalink_hover_color = calibrefx_get_option('custom_permalink_hover_color');

    if(!empty($custom_font_size)) 
        $fontsize = 'font-size: '.$custom_font_size.'px;';
    else
        $fontsize = 'font-size: inherit';

    if(!empty($custom_font_color)) 
        $fontcolor = 'color: '.$custom_font_color.';';
    else
        $fontcolor = 'color: inherit;';

    if(!empty($custom_permalink_color)) 
        $linkcolor = 'color: '.$custom_permalink_color.';';
    else
        $linkcolor = 'color: inherit;';

    if(!empty($custom_permalink_hover_color)) 
        $linkhovercolor = 'color: '.$custom_permalink_hover_color.';';
    else
        $linkhovercolor = 'color: inherit';

    if(!empty($body_font)){
        $fontfamily = $fonts[$body_font]['font-family'];
        if(!$fontfamily){
          $fontfamily = 'Helvetica, Arial, sans-serif;';
        }
        $fontfamily = 'font-family: ' . $fontfamily;
    }

    if(!empty($header_font)){
        $headerfontfamily = $fonts[$header_font]['font-family'];
        if(!$headerfontfamily){
          $headerfontfamily = 'Helvetica, Arial, sans-serif;';
        }
        $headerfontfamily = 'font-family: ' . $headerfontfamily;
    }

    $custom_css = "body{
    {$fontsize}
    {$fontcolor}
    {$fontfamily}
}
p, li, input, textarea, select, button{
    {$fontfamily}
}
h1, h2, h3, h4, h5, h6{
    {$headerfontfamily}
}
a, a:visited{
    {$linkcolor}
}
.post h2.entry-title a, .page h2.entry-title a, .page h1.entry-title a{
    {$linkcolor}
}
a:hover{
    {$linkhovercolor}
}
.post h2.entry-title a:hover, .page h2.entry-title a:hover, .page h1.entry-title a:hover{
    {$linkhovercolor}
}";

    wp_add_inline_style( 'webfont-style', $custom_css );
}

function webfont_load_colorpicker() {
    wp_enqueue_script('webfont-js', CHILD_URL . '/app/modules/webfont/js/webfont.js', array('jquery', 'wp-color-picker'), false, true);
}

function webfont_meta_boxes(){
    global $calibrefx;

    calibrefx_add_meta_box('design', 'basic', 'webfont-typography', __('Typography Settings', 'calibrefx'), 'webfont_typography', $calibrefx->theme_settings->pagehook, 'main', 'low');
}

function webfont_typography(){
    global $calibrefx;

    calibrefx_add_meta_group('webfont-typography', 'webfont-heading-settings', __('Heading Typhography Settings', 'calibrefx'));
    calibrefx_add_meta_group('webfont-typography', 'webfont-content-settings', __('Content Typhography Settings', 'calibrefx'));
    calibrefx_add_meta_group('webfont-typography', 'webfont-permalink-settings', __('Permalinks Settings', 'calibrefx'));
    
    add_action( 'webfont-typography_options', function(){
        calibrefx_add_meta_option(
            'webfont-heading-settings',  // group id
            'custom_header_font_family', // field id and option name
            __('Heading Font Type','calibrefx'), // Label
            array(
                'option_type' => 'select',
                'option_items' => apply_filters(
                        'calibrefx_custom_fonts', webfont_dropdown()),
                'option_default' => 'Open Sans',
                'option_filter' => 'safe_text',
                'option_description' => __("This is for heading typhpgraphy from <code>h1, h2, h3, h4, h5, h6</code>", 'calibrefx'),
            ), // Settings config
            1 //Priority
        );
    });

    add_action( 'webfont-typography_options', function(){
        calibrefx_add_meta_option(
            'webfont-content-settings',  // group id
            'custom_font_family', // field id and option name
            __('Content Font Type','calibrefx'), // Label
            array(
                'option_type' => 'select',
                'option_items' => apply_filters(
                        'calibrefx_custom_fonts', webfont_dropdown()),
                'option_default' => 'Open Sans',
                'option_filter' => 'safe_text',
                'option_description' => __("This is for all your content typhpgraphy", 'calibrefx'),
            ), // Settings config
            1 //Priority
        );

        calibrefx_add_meta_option(
            'webfont-content-settings',  // group id
            'custom_font_size', // field id and option name
            __('Content Font Size (in px)','calibrefx'), // Label
            array(
                'option_type' => 'select',
                'option_items' => apply_filters(
                        'calibrefx_custom_fonts', webfont_size_dropdown()),
                'option_default' => '14',
                'option_filter' => 'safe_text',
                'option_description' => __("This settings is to change your default content font size. (default 14px)", 'calibrefx'),
            ), // Settings config
            5 //Priority
        );

        calibrefx_add_meta_option(
            'webfont-content-settings',  // group id
            'custom_font_color', // field id and option name
            __('Content Font color','calibrefx'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '#0000ff',
                'option_filter' => 'safe_text',
                'option_attr' => array("class" => "cfx-color-picker-field"),
                'option_description' => __("This settings is to change your font color. (default: <code>#0000ff</code>)", 'calibrefx'),
            ), // Settings config
            10 //Priority
        );


        calibrefx_add_meta_option(
            'webfont-permalink-settings',  // group id
            'custom_permalink_color', // field id and option name
            __('Permalink Colors','calibrefx'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '#0000ff',
                'option_filter' => 'safe_text',
                'option_attr' => array("class" => "cfx-color-picker-field"),
                'option_description' => __("This settings is to change your permalink color. (default: <code>#0000ff</code>)", 'calibrefx'),
            ), // Settings config
            1 //Priority
        );
        
        calibrefx_add_meta_option(
            'webfont-permalink-settings',  // group id
            'custom_permalink_hover_color', // field id and option name
            __('Permalink Hover Color','calibrefx'), // Label
            array(
                'option_type' => 'textinput',
                'option_default' => '#0000ff',
                'option_filter' => 'safe_text',
                'option_attr' => array("class" => "cfx-color-picker-field"),
                'option_description' => __("This settings is to change your permalink hover color. (default: <code>#0000ff</code>)", 'calibrefx'),
            ), // Settings config
            5 //Priority
        );
    });

    calibrefx_do_meta_options($calibrefx->theme_settings, 'webfont-typography');
}

function webfont_dropdown(){
    global $fonts;

    $return_font = array();
    foreach ($fonts as $font_key => $font) {
        $return_font[$font_key] = $font_key;
    }
    return $return_font;
}

function webfont_size_dropdown(){
    $return_size = array();
    for($i =9;$i<=24;$i++){
        $return_size[$i] = $i;
    }
    return $return_size;
}

function webfont_theme_settings_default($default_arr = array()){
    $webfont_default = array(
        'custom_header_font_family' => 'Open Sans',
        'custom_font_size' => '14',
        'custom_font_family' => 'Open Sans',
        'custom_font_color' => '#404040',
        'custom_permalink_color' => '#08c',
        'custom_permalink_hover_color' => '#005580'
    );

    return array_merge($default_arr, $webfont_default);
}
