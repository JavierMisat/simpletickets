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
	get_template_part('content-parts/page', 'banner-shop');?>
    <div id="container_full" class="ts-page-shop">
        <div class="container">

        	<?php if ($ts_alaska['woo_layout'] != 'fullwidth'): ?>
				<div class="row">
			<?php endif ?>

			<?php if ($ts_alaska['woo_layout'] == 'left-sidebar'): ?>

					<!--Sidebar Left-->
			        <aside id="content-right" class="content-right col-sm-4 col-md-3 col-lg-3">

						<?php dynamic_sidebar('ts_shop_sidebar');?>

			        </aside>
			        <!--Sidebar Left-->
			<?php endif; ?>

			<?php if($ts_alaska['woo_layout'] == 'left-sidebar'): ?>

        		<article id="content-left" class="content-left page-with-sidebar col-sm-8 col-md-9 col-lg-9">

			<?php elseif($ts_alaska['woo_layout'] == 'right-sidebar'): ?>

        		<article id="content-left" class="content-left page-with-sidebar col-sm-8 col-md-9 col-lg-9">

		    <?php else: ?>

        		<article id="content-nosidebar" class="page-without-sidebar">

		    <?php endif; ?>
