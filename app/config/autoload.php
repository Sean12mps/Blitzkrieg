<?php defined('CALIBREFX_URL') OR exit();
/**
 * 
 * CalibreWorks Themes
 *
 * CalibreWorks Themes by Calibrefx Team
 *
 * @package     calibreworks
 * @author      Calibrefx Team
 * @copyright   Copyright (c) 2013, CalibreWorks. (http://www.calibreworks.com/)
 * @link        http://www.calibreworks.com
 * @since       Version 2.0.0
 * @filesource 
 *
 *
 */

/*
 * Auto-load Libraries
 */
$autoload['libraries'] = array_merge($autoload['libraries'], array(''));

/*
 * Auto-load Helper File
 */
$autoload['helpers'] = array_merge($autoload['helpers'], array(''));

/*
 *  Auto-load Config files
 */
$autoload['configs'] = array_merge($autoload['configs'], array());

/*
 *  Auto-load Config files
 */
$autoload['widgets'] = array_merge($autoload['widgets'], array(
								'about_us'
						));

/*
 *  Auto-load Config files
 */
$autoload['models'] = array_merge($autoload['models'], array(''));

/*
 *  Auto-load Config files
 */
$autoload['hooks'] = array_merge($autoload['hooks'], array(
															 'childfx_script'
															,'childfx_settings'
															,'childfx_taxonomy'
															,'childfx_ajax'
															,'childfx_header'
															,'childfx_post'
															,'childfx_footer'
															,'childfx_widget'
));

/*
 *  Auto-load Shortcode files
 */
$autoload['shortcodes'] = array_merge($autoload['shortcodes'], array('shortcode'));
