<?php
/**
 * This file is used to load javascript and stylesheet function
 */

/**
 * Load javascript
 */
if( !function_exists( 'ts_load_js' ) ) {

	function ts_load_js()
	{
		global $ts_alaska;
		if(!is_admin())
		{
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui');

			$scripts = array(
			'bootstrap.min',
			'jquery.appear.min',
			'jquery.countTo',
			'jquery.countdown',
			'jquery.fitvids',
			'readmore',
			'subscribre',
			'jquery.validate.min',
			'jquery.owl.carousel',
			'easyResponsiveTabs',
			'jquery.circliful.min',
			'jquery.sticky',
			'jquery.cubeportfolio.min',
			'portfolio',
			'slick.min',
			'custom',
			);

			foreach($scripts as $script){
				wp_enqueue_script( $script, THEMESTUDIO_JS . '/'.$script.'.js', false, THEMESTUDIO_THEME_VERSION, true );
			}
            
		}

	}
	add_action('wp_enqueue_scripts','ts_load_js');

}

/**
 * Load stylesheet
 */
if( !function_exists( 'ts_load_css' ) ) {

	/*
	 * Load css
	*/
	function ts_load_css()
	{

		global $ts_alaska;

		$styles = array(
			'font-awesome.min',
			//'jquery.flipcountdown',
			'jquery-ui',
		    'bootstrap.min',
		    //'owl.carousel',
		    'custom',
		    //'easy-responsive-tabs',
		    //'jquery.circliful',
		    'cubeportfolio.min',
		    //'megamenu',
		    //'styles',
		);
        
        if ( is_child_theme() ){
            if ( file_exists( get_stylesheet_directory() . '/assets/css/styles.css' ) ) {
                wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/assets/css/styles.css', $styles );   
            }
		}

		wp_enqueue_style( 'alaska-style', get_stylesheet_uri() );
			foreach($styles as $style){
				wp_enqueue_style( $style, THEMESTUDIO_CSS.'/'.$style.'.css');
			}

		/**
		 * Check if WooCommerce is active
		 **/
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		    // Put your plugin code here

			$chosen_css = THEMESTUDIO_VENDORS . '/chosen/chosen.css';
			$chosen_js = THEMESTUDIO_VENDORS . '/chosen/chosen.jquery.min.js';


		    wp_register_style('woocommerce_chosen_styles', $chosen_css, false, THEMESTUDIO_THEME_VERSION, 'screen');
			wp_enqueue_style( 'woocommerce_chosen_styles' );


		    wp_register_script('wc-chosen', $chosen_js, false, THEMESTUDIO_THEME_VERSION, true);
			wp_enqueue_script( 'wc-chosen' );


		    wp_register_style('ts-woocommerce', get_template_directory_uri(). '/woocommerce/woocommerce.css', false, THEMESTUDIO_THEME_VERSION, 'screen');
			wp_enqueue_style( 'ts-woocommerce' );
		}

	}
	add_action("wp_enqueue_scripts",'ts_load_css');

}
/**
 * Load theme custom css ajax
 */
if(!function_exists('ts_get_custom_css')){	

	/*
	 * get css custom
	*/
	function ts_get_custom_css()
	{

		wp_enqueue_style( 'alaskaajax-custom-css', admin_url( 'admin-ajax.php' ) . '?action=alaskaajax_enqueue_custom_style_via_ajax', false, THEMESTUDIO_THEME_VERSION );
		if ( is_child_theme() ){
			if ( file_exists( get_stylesheet_directory() . '/assets/css/styles.css' ) ) {
				wp_enqueue_style( 'alaskaajax-custom-css', admin_url( 'admin-ajax.php' ) . '?action=alaskaajax_enqueue_custom_style_via_ajax', false, THEMESTUDIO_THEME_VERSION );
			}
		}
	    
	}
	add_action( 'wp_enqueue_scripts', 'ts_get_custom_css' );

}
/**
 * Load theme custom stylesheet
 */
if ( !function_exists( 'alaskaajax_enqueue_custom_style_via_ajax' ) ) {
    
    function alaskaajax_enqueue_custom_style_via_ajax() {
        global $ts_alaska;       
        header( 'Content-type: text/css; charset: UTF-8' ); 
        $custom_css = '';
        $color_rgb = hex2rgb($ts_alaska['ts-accent-color']);
        
            if ($ts_alaska['ts-accent-color'] != ''){
    	    	$custom_css .= '
    				a{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.mobile-navigation{
    					border-color:'.$ts_alaska['ts-accent-color'].';
    				}
    				.mobile-navigation:hover, .mobile-navigation:focus{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-bt{
    					background: '.$ts_alaska['ts-accent-color'].';
    					border-color:'.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-bt:hover, .ts-bt:focus{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.breadcrumbs a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-style-button:hover{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.top-header ul li a:hover, .top-header ul li a:hover .fa{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.main-menu ul > li .dropdown-menu li a:hover,
    				.main-menu ul > li .dropdown-menu li.active a,
    				.main-menu ul > li .dropdown-menu li a:focus{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.main-menu ul > li .dropdown-menu > li.menu-item-has-children > a:hover:after{
    				  color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-1 .service-icon:after{
    					box-shadow: 0 0 0 4px '.$ts_alaska['ts-accent-color'].';
    					-moz-box-shadow: 0 0 0 4px '.$ts_alaska['ts-accent-color'].';
    					-webkit-box-shadow: 0 0 0 4px '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-1:hover .service-icon{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-1 .read-more{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-search-domain input[type="submit"],
    				.ts-search-domain input[type="submit"]:hover,
    				.ts-search-domain input[type="submit"]:focus{
    					background-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-search-domain .sm_links a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style1 a.cta_pricing:hover,
    				.ts-pricing-table-style1 a.cta_pricing:focus{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style1.active{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style1.active .price-unit{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style1.active a.cta_pricing:hover,
    				.ts-pricing-table-style1.active a.cta_pricing:focus{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-testimonial-style1 .client-quote .fa{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-testimonial-style1 .client-website a{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.owl-theme .owl-controls .owl-page.active{
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.owl-theme .owl-controls .owl-page.active span, 
    				.owl-theme .owl-controls.clickable .owl-page:hover span {
    				  background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-acordion h3 .fa{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-acordion.ui-accordion .ui-accordion-header .ui-accordion-header-icon{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-acordion .ui-accordion-header:before{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-acordion.ts-acordion-style2 .ui-accordion-header.ui-state-active{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-acordion.ts-acordion-style2.ui-accordion .ui-accordion-header.ui-state-active .ui-accordion-header-icon{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-domain-price-box .domain-price{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-2:hover .icon-service{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-2:hover h3{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style2 a.cta_pricing:hover{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style2.active{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style2.active a.cta_pricing:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-testimonial-style2 .client-website a {
    				  color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-testimonial-style2.dark .client-website a:hover{color: '.$ts_alaska['ts-accent-color'].';}
    				.ts-feature-item-style2 .icon-feature{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-feature-item-2 .feature-icon{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-item-post .ts-main-recent-post a:hover h4{
    					color:'.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-item-post h4 a:hover{
    					color: '.$ts_alaska['ts-accent-color'].'
    				}
    				.ts-item-post .ts-item-post-footer i{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-item-post .ts-item-post-footer a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-section-top-footer{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.contact-info:hover span{
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.contact-info:hover span i{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-company-info a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-support ul li a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-support ul li i{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-control-pane ul li a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-control-pane ul li i{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-form-subscribe .subcribe-btn{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-social-footer a:hover span{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-menu-footer ul li a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style3 a:hover h4{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-special-offer .ts-special-offer-content ul li:before{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-special-offer .ts-special-offer-content ul a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-hosting-price span.ts-special-offer-price{
    					color:'.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-special-offer-content .ts-offer-right a{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-number-statistic i{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-number-statistic a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-number-statistic a:hover h3{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.widget-list-posts i{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.widget-list-posts a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-list-popular-topics li .red-text{
    					color:'.$ts_alaska['ts-accent-color'].';
    				}
    				footer .widget ul li a:before{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-big-caption span, .ts-big-caption-center span{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-caption-small-center{
    					color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.ts-caption-small .fa{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-caption-small-right .fa{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-price-rev span, .ts-price-rev-right span{
    					color: '.$ts_alaska['ts-accent-color'].';}
    				.ts-button-slide-2{
    					background: '.$ts_alaska['ts-accent-color'].'!important;
    					border-color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.ts-button-slide:hover{
    					background: '.$ts_alaska['ts-accent-color'].'!important;
    					border-color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.ts-button-slide-2:hover a,
    				.ts-button-slide-2 a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-number{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.tp-leftarrow.default:hover, .tp-rightarrow.default:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-whmcs li .item-right strong a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.date-post span.month{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.blog-item h3 a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.blog-meta li a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.blog-meta li .fa{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-button:hover, input[type="submit"]:hover, .more-link:hover, button:hover{
    					background:  '.$ts_alaska['ts-accent-color'].';
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.blog-item .group-share a:hover, .group-share a:hover {
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.pagination > .active > a, 
    				.pagination > .active > span, 
    				.pagination > .active > a:hover, 
    				.pagination > .active > span:hover, 
    				.pagination > .active > a:focus, 
    				.pagination > .active > span:focus,
    				.pagination > li > a:hover,
    				.pagination > li > a:focus,
    				.page-links a:hover {
    					background-color: '.$ts_alaska['ts-accent-color'].';
    				    border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.page-links > span{
    					background-color: '.$ts_alaska['ts-accent-color'].';
    				  	border-color:'.$ts_alaska['ts-accent-color'].';
    				}
    				.blog-quote{
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.blog-link:before{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.owl-theme .owl-controls .owl-buttons div:hover, .owl-theme .owl-controls .owl-buttons div:focus {
    				  background: '.$ts_alaska['ts-accent-color'].';
    				 }
    				 blockquote{
    					border-color:'.$ts_alaska['ts-accent-color'].';
    				}
    				#searchform button[type="submit"]:hover{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.widget ul li a:before, .widget_recent_comments li.recentcomments:before {
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.widget ul li a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.domainchecker  button[type="submit"]:hover{
    					background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.widget_tag_cloud .tagcloud a:hover{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.comment-item .comment-reply-link:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-3 .icon-service{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-4:hover .icon-service{
    					background: '.$ts_alaska['ts-accent-color'].';
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-style-5 .icon-service{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.team-item-style2 .social-network a:hover{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.team-item .social-network-team  li a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-list-ul ul li:before{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.countdownstyle1 .ts-date-countdown.ts-day-count{
    					background: '.$ts_alaska['ts-accent-color'].'
    				}
    				.countdownstyle2 .ts-date-countdown.ts-day-count{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				#wp-calendar a:hover{
    				    color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-showmore:hover{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.quote-type-style2:before{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-list-style ul li a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-list-style.underlist li a{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				#filters-portfolio .cbp-filter-item.cbp-filter-item-active,
    				#filters-portfolio .cbp-filter-item:hover{
    					background-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-contact-infomation a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-menu-sidebar > ul > li.menu-item-has-children.current_page_item > a,
    				.ts-menu-sidebar > ul > li.menu-item-has-children.current_page_item > a:hover,
    				.ts-menu-sidebar > ul > li.menu-item-has-children.current-menu-parent > a,
    				.ts-menu-sidebar > ul > li.menu-item-has-children.current-menu-parent > a:hover,
    				.ts-menu-sidebar > ul > li.current_page_item > a,
    				.ts-menu-sidebar > ul > li.current_page_item > a:hover{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-menu-sidebar > ul > li.menu-item-has-children.current_page_item > a:after,
    				.ts-menu-sidebar > ul > li.menu-item-has-children.current-menu-parent > a:after,
    				.ts-menu-sidebar > ul > li.current_page_item > a:after{
    					border-left: 6px solid '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-menu-sidebar li .sub-menu a:hover,
    				.ts-menu-sidebar li .sub-menu li.current_page_item a{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.contact-info span{background:'.$ts_alaska['ts-accent-color'].'; }
    				/* WOOCOMERCE */
    				.woocommerce nav.woocommerce-pagination ul li a:hover, 
    				.woocommerce nav.woocommerce-pagination ul li span.current, 
    				.woocommerce #content nav.woocommerce-pagination ul li a:hover, 
    				.woocommerce #content nav.woocommerce-pagination ul li span.current, 
    				.woocommerce-page nav.woocommerce-pagination ul li a:hover, 
    				.woocommerce-page nav.woocommerce-pagination ul li span.current, 
    				.woocommerce-page #content nav.woocommerce-pagination ul li a:hover, 
    				.woocommerce-page #content nav.woocommerce-pagination ul li span.current{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				    border-color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.woocommerce .star-rating span, .woocommerce-page .star-rating span {
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.woocommerce table.cart a.remove:hover, .woocommerce #content table.cart a.remove:hover, .woocommerce-page table.cart a.remove:hover, .woocommerce-page #content table.cart a.remove:hover {
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.woocommerce .addresses .title .edit:hover, .woocommerce-page .addresses .title .edit:hover{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.price_slider_amount .price_label span{
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, 
    				.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.chosen-container-single .chosen-single span:after {
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.widget_price_filter .ui-slider-horizontal {
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.widget_price_filter .price_slider_amount .button:hover{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.product-categories li a:before {
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.product-categories li a:hover {
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.woocommerce  a.button.product_type_simple:hover,
    				.woocommerce  a.button.product_type_variable:hover,
    				.woocommerce  a.button.add_to_cart_button:hover,
    				.woocommerce  a.button.product_type_simple.added:hover,
    				.woocommerce  a.button.product_type_simple:hover{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				#commentform .stars > span a:hover:before, #commentform .stars > span a.active:before {
    				  color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.woocommerce .comment-form input[type="submit"]:hover{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.shipping_calculator h2 a:hover{
    				    color: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.added_to_cart.wc-forward:hover{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.woocommerce-message .button:hover{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				li.mini-shoping-cart-wraper .buttons a:hover{
    				    background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.toggle-bar-btn {
    					border-color: '.$ts_alaska['ts-accent-color'].' '.$ts_alaska['ts-accent-color'].' transparent transparent;
    				}
    				.widget_mc4wp_widget input[type="submit"]{
    					background: '.$ts_alaska['ts-accent-color'].'
    				}
    				.ts-suport-header .header-suport  .header-phone{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-suport-header .header-signup-chat li.header-chat span.icon{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.main-header-style2 .main-menu > ul > li > a:hover,
    				.main-header-style2 .main-menu > ul > li:hover > a{
    					background: none;
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-special-offer-style2  .ts-special2 a{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-special-offer-style2  .ts-special2 a:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-mediumcaption-3 span{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-listcaption1-3:before{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-listcaption1-3 span{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-button-s3{
    					background: '.$ts_alaska['ts-accent-color'].'!important;
    				}
    				.tp-caption.ts-button-s3:hover a, .tp-caption.ts-button-s3 a:hover{color: '.$ts_alaska['ts-accent-color'].';}
    				.ts-button-s3:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-small-caption-3 span{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.tp-caption.ts-bg-3, .ts-bg-3{
    					background: rgba('.$color_rgb[0].','.$color_rgb[1].', '.$color_rgb[2].', 0.5)!important;
    				}
    				.ts-service-img .service-content a.cta_pricing{
    				    background: '.$ts_alaska['ts-accent-color'].';
    				    border-color:'.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-img .service-content a.cta_pricing:hover{
    				    color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3 .price-icon .pricing-icon{
    				    background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3 .price-unit .price-unit{
    				    color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3.active .price-unit{
    				    background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3 p a.cta_pricing:hover,.ts-pricing-table-style3.active a.cta_pricing{
    				    background: '.$ts_alaska['ts-accent-color'].';
    				    border-color:'.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3.active a.cta_pricing:hover{
    				    color: '.$ts_alaska['ts-accent-color'].';
    				}
    				li.mini-shoping-cart-wraper a:hover span,
    				li.mini-shoping-cart-wraper:hover a span{
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricingtable-5 .price-icon{
    					background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricingtable-5 .price-unit{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricingtable-5 .ts-bt-pricing{
    					background: '.$ts_alaska['ts-accent-color'].'; 
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricingtable-5 .ts-bt-pricing:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricingtable-5 table td .inner-td.ts-icon-check, .ts-icon-check{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-search-whois #domain .l1 input[type="submit"]{
    					background-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3.ts-whmpress button:hover{
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3.active.ts-whmpress button{
    					background: '.$ts_alaska['ts-accent-color'].';
    					border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style3.active.ts-whmpress button:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-img.ts-whmpress .service-content button {
    				  background: '.$ts_alaska['ts-accent-color'].';
    				  border-color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-service-img.ts-whmpress .service-content button:hover {
    				  color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style2.ts-whmpress.active button:hover {
    				  color: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style2.ts-whmpress button:hover {
    				  background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style1.ts-whmpress button:hover, 
    				.ts-pricing-table-style1.ts-whmpress button:focus {
    				  background: '.$ts_alaska['ts-accent-color'].';
    				}
    				.ts-pricing-table-style1.ts-whmpress.active button:hover{
    					color: '.$ts_alaska['ts-accent-color'].';
    				}
                    span.page-numbers.current {
                      background-color: '.$ts_alaska['ts-accent-color'].';
                      border-color: '.$ts_alaska['ts-accent-color'].';
                      color: white;
                    }
    	    	';
    	    }
        $return  = $custom_css;
        if(isset($ts_alaska['ts-css-code'])){
	    	$return .= $ts_alaska['ts-css-code'];
	    }    
        echo $return;        
        wp_die();
    }
    add_action( 'wp_ajax_alaskaajax_enqueue_custom_style_via_ajax', 'alaskaajax_enqueue_custom_style_via_ajax' );
    add_action( 'wp_ajax_nopriv_alaskaajax_enqueue_custom_style_via_ajax', 'alaskaajax_enqueue_custom_style_via_ajax' );
}
