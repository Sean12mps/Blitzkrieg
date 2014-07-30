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

$cfxgenerator->add('calibrefx_before_wrapper', 'childfx_metro');
function childfx_metro(){

	?>
	<div class="tile-area tile-area-dark">

		<!-- PROFILE INFO -->
		<h1 class="tile-area-title fg-white">Start</h1>
        <div class="user-id">
            <div class="user-id-image">
                <span class="icon-user no-display1"></span>
                
            </div>
            <div class="user-id-name">
                <span class="first-name">Sergey</span>
                <span class="last-name">Pimenov</span>
            </div>
        </div>
		<!-- PROFILE INFO -->


		<div class="tile-group six">

			


			<div class="tile double bg-amber" data-click="transform">
			    <div class="tile-content icon">
			        <i class="icon-play-alt"></i>
			    </div>
			    <div class="brand bg-black">
			        <span class="label fg-white">Player</span>
			        <div class="badge bg-darkRed paused"></div>
			    </div>
			</div>	


		</div>
		<!-- .tile-group six -->


	</div>
	<?php
}
	








$cfxgenerator->add('calibrefx_after_header', 'childfx_sidebar_menu');
function childfx_sidebar_menu(){
     
	?>
	<div id="sidebarMENU">
		
		<div id="menu-start"></div>
		<!-- #menu-start -->

	</div>
	
	<?php
     
}
