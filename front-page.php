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



	remove_action('calibrefx_loop', 'calibrefx_do_loop');

	add_action('calibrefx_loop', 'childfx_do_loop');

	function childfx_do_loop(){
?>

	<!-- CLONE-MODAL -->
		
	<!-- CLONE-MODAL -->


<?php
	}

	calibrefx();