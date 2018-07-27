<?php

	global $ts_alaska, $post;
    $sidebar = 'Primary Sidebar(Right Sidebar)';
	if ( function_exists('register_sidebar') && ($sidebar <> '')){

		/*
		 * Register sidebar
		*/
		register_sidebar(
			array(
				'name' => str_replace("_"," ",$sidebar),
				'id'            => 'primary',
			    'description' => esc_html__( 'This is land of page sidebar','alaska' ),
				'before_title' =>'<h3 class="sidebar_title">',
				'after_title' =>'</h3>',
				'before_widget' => '<div  id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
			)
		);

		if(isset($ts_alaska["ts-footer-number-widget"])){

		$footer_widget_style=$ts_alaska["ts-footer-number-widget"];
		switch($footer_widget_style)
		{
		   	case '1':
		   	if ( function_exists('register_sidebar'))
			    register_sidebar(
					array(
						'name' => esc_html__( 'Footer widget 1', 'alaska' ),
						'id'            => 'footer_widget_1',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)
		      	);
		   	break;
		   	case '2':

			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 1', 'alaska' ),
						'id'            => 'footer_widget_1',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					 )
		      	);


			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 2', 'alaska' ),
						'id'            => 'footer_widget_2',
						'description' => esc_html__( 'This is footer widget Two','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)
		      	);
		   	break;
		   	case '3':

			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 1', 'alaska' ),
						'id'            => 'footer_widget_1',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)
		      	);


			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 2', 'alaska' ),
						'id'            => 'footer_widget_2',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)
		      	);


			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 3', 'alaska' ),
						'id'            => 'footer_widget_3',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)
		      	);

		   	break;
		   	case '4':

			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 1', 'alaska' ),
						'id'            => 'footer_widget_1',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)

		      	);


			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 2', 'alaska' ),
						'id'            => 'footer_widget_2',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)
		      	);


			    register_sidebar(
		      		array(
						'name' => esc_html__( 'Footer widget 3', 'alaska' ),
						'id'            => 'footer_widget_3',
						'description' => esc_html__( 'This is footer widget location','alaska' ),
						'before_title' =>'<h3 class="widget-title">',
						'after_title' =>'</h3>',
						'before_widget' => '<div class="%1$s widget %2$s">',
						'after_widget' => '</div>',
					)
		      	);


			    register_sidebar(
		      		array(
							'name' => esc_html__( 'Footer widget 4', 'alaska' ),
							'id'            => 'footer_widget_4',
							'description' => esc_html__( 'This is footer widget location','alaska' ),
							'before_title' =>'<h3 class="widget-title">',
							'after_title' =>'</h3>',
							'before_widget' => '<div class="%1$s widget %2$s">',
							'after_widget' => '</div>',
					)
		      	);
		   	break;
		}

	}

	if(isset($ts_alaska['sidebars'])){

			/*======== Register widgets ========*/
			$dynamic_sidebar = $ts_alaska['sidebars'];

			if(!empty($dynamic_sidebar))
			{
				foreach($dynamic_sidebar as $sidebar)
				{
					if ( function_exists('register_sidebar') && ($sidebar <> ''))
				    register_sidebar(
				    array(
				    	'name' => $sidebar,
				    	'id'            => strtolower (str_replace(" ","_",trim($sidebar))),
			            'description' => esc_html__( 'This is land of page sidebar','alaska' ),
						'before_title' =>'<div class="sidebar_title"><h3>',
						'after_title' =>'</h3></div>',
						'before_widget' => '<div   id="%1$s" class="sidebar_widget %2$s">',
						'after_widget' => '</div>',
					));
				}
			}

		}
	

	/**
	   * Check if WooCommerce is active
	   **/
	  if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	  	/*
		 * Register minicart sidebar
		*/
		register_sidebar(
			array(
				'name' => esc_html__( 'Mini Cart Sidebar', 'alaska' ),
				'id'            => 'ts_shoping_cart_sidebar',
			    'description' => esc_html__( 'This is shoping cart sidebar','alaska' ),
				'before_title' =>'',
				'after_title' =>'',
				'before_widget' => '<div  id="%1$s" class="shoping-cart-widget %2$s">',
				'after_widget' => '</div>',
			)
		);

		// Register shop page sidebar
		register_sidebar(
			array(
				'name' => esc_html__( 'Shop Sidebar', 'alaska' ),
				'id'            => 'ts_shop_sidebar',
			    'description' => esc_html__( 'This is shoping cart sidebar','alaska' ),
				'before_title' =>'',
				'after_title' =>'',
				'before_widget' => '<div  id="%1$s" class="shoping-cart-widget %2$s">',
				'after_widget' => '</div>',
			)
		);
	}
	

	}


	
	/*
	 * register navigation menus
	*/
	register_nav_menus(
	    array(
	      	'megamenu'  => __('Mega Menu','alaska'),
	    )
	);