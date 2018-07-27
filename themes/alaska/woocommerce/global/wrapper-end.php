<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $ts_alaska;
$custom_right_sidebar = 'ts_shop_sidebar';
?>
		</article>

		<?php if ($ts_alaska['woo_layout'] == 'right-sidebar'): ?>

			<!--Sidebar Right-->
	        <aside id="content-right" class="content-right col-sm-4 col-md-3 col-lg-3">

				<?php dynamic_sidebar($custom_right_sidebar);?>

	        </aside>
	        <!--Sidebar Right-->
	    <?php endif ?>
	    
	    <?php if ($ts_alaska['woo_layout'] != '3'): ?>
	    		</div>
		<?php endif ?>
		
	</div>
</div>