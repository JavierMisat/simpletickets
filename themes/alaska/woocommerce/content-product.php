<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $ts_alaska, $themestudio_product_count;

// Store loop count we're currently on
if (empty($woocommerce_loop['loop']))
    $woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns']))
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', $ts_alaska['woo_product_layout']);

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
$cll = ' first';
$classes_row = '';

if (0 == ($woocommerce_loop['loop'] - 1) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'])
    $classes_row = ' first';
if (0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'])
    $classes_row = ' last';

if ($woocommerce_loop['loop'] % 2 == 0) {
    $class_odd = ' even';
} else {
    $class_odd = ' odd';
}

if ($woocommerce_loop['columns'] == '3') {
    $classes = 'col-xs-12 col-sm-6 col-md-4' . $classes_row . $class_odd;
} elseif ($woocommerce_loop['columns'] == '4') {
    $classes = 'col-xs-12 col-sm-6 col-md-3' . $classes_row . $class_odd;
}
?>

<div <?php post_class($classes); ?>>

    <?php do_action('woocommerce_before_shop_loop_item'); ?>

    <div class="ts-product-info">

        <?php
            do_action('woocommerce_before_shop_loop_item_title');
            do_action( 'woocommerce_after_shop_loop_item' );
        ?>

    </div>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

    <?php
    /**
     * woocommerce_after_shop_loop_item_title hook
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>
</div>