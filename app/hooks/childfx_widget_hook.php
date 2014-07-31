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


calibrefx_register_sidebar(array(
	'name' => __( 'Application Grouping', 'calibrefx' ),
	'id' => 'application-grouping',
));

calibrefx_register_sidebar(array(
	'name' => __( 'Footer 2 Sidebar', 'calibrefx' ),
	'id' => 'footer-2-sidebar',
));

calibrefx_register_sidebar(array(
	'name' => __( 'Footer 3 Sidebar', 'calibrefx' ),
	'id' => 'footer-3-sidebar',
));


$cfxgenerator->remove('calibrefx_before_footer','calibrefx_do_footer_widgets');
$cfxgenerator->add('calibrefx_before_footer', 'childfx_do_footer_widgets',11);

function childfx_do_footer_widgets(){
	?>
		<div id="footer-widget">
			<div class="container">
				<div class="footer-widget">
					<div class="row">
						<div class="<?php echo col_class(12,12,8); ?>">
							<?php dynamic_sidebar( 'application-grouping' ); ?>
						</div>
						<div class="<?php echo col_class(12,12,4); ?>">
							<?php dynamic_sidebar( 'footer-2-sidebar' ); ?>
						</div>
						<div class="<?php //echo col_class(12,6,2); ?>">
							<?php dynamic_sidebar( 'footer-3-sidebar' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	
    <?php
}