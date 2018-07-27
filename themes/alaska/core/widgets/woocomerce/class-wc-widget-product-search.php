<?php
/**
 * Product Search Widget
 *
 * @author 		WooThemes
 * @category 	Widgets
 * @package 	WooCommerce/Widgets
 * @version 	2.1.0
 * @extends 	WC_Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Custom_WC_Widget_Product_Search extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_product_search';
		$this->widget_description = __( 'A Search box for products only.', 'alaska' );
		$this->widget_id          = 'woocommerce_product_search';
		$this->widget_name        = __( 'WooCommerce Product Search', 'alaska' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Search Products', 'alaska' ),
				'label' => __( 'Title', 'alaska' )
			)
		);
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$title = $instance['title'];
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;

		if ( $title )
			echo $before_title . '<h3>'.$title .'</h3>'. $after_title;

		get_product_search_form();

		echo $after_widget;
	}
}
