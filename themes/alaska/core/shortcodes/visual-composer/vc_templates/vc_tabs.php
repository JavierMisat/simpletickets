	<?php
	$output = $title = $interval = $el_class = '';
	extract( shortcode_atts( array(
		'title' => '',
		'interval' => 0,
		'el_class' => '',
		'border_yes' => '',
		'style_boder'=>''
	), $atts ) );

	wp_enqueue_script( 'jquery-ui-tabs' );

	$el_class = $this->getExtraClass( $el_class );

	if ( 'vc_tour' == $this->shortcode ) {		
		// Extract tab titles
		preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		/**
		 * vc_tabs
		 *
		 */
		if ( isset( $matches[1] ) ) {
			$tab_titles = $matches[1];
		}
		$tabs_nav = '';
		$tabs_nav .= '<ul class="resp-tabs-list">';
		foreach ( $tab_titles as $tab ) {
			$tab_atts = shortcode_parse_atts($tab[0]);
			if(isset($tab_atts['title'])) {
				$tabs_nav .= '<li>'. $tab_atts['title'] .'</li>';
			}
		}
		$tabs_nav .= '</ul>' . "\n";

		$output .= "\n\t\t" . '<div class="ts-verticalTab">';			
		$output .= "\n\t\t\t" . $tabs_nav;
		$output .= "\n\t\t" . '<div class="resp-tabs-container">';
		$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );		
		$output .= "\n\t\t" . '</div> ';
		$output .= "\n\t\t" . '</div> ';
		echo $output;
	} else{		
		preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();	
		if ( isset( $matches[1] ) ) {
			$tab_titles = $matches[1];
		}
		$tabs_nav = '';
		$tabs_nav .= '<ul class="resp-tabs-list">';
			foreach ( $tab_titles as $tab ) {
				$tab_atts = shortcode_parse_atts($tab[0]);							
				if(isset($tab_atts['title'])) {
					$tabs_nav .= '<li>'. $tab_atts['title'] .'</li>';
				}
			}
		$tabs_nav .= '</ul>' . "\n";	
		if($style_boder!=''){
			$border_yes = esc_attr($style_boder);
		} 
			$output .= "\n\t\t" . '<div class="ts-horizontalTab ts-tab '.$border_yes.'">';			
			$output .= "\n\t\t\t" . $tabs_nav;
			$output .= "\n\t\t" . '<div class="resp-tabs-container">';
			$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );		
			$output .= "\n\t\t" . '</div> ';		
			$output .= "\n\t\t" . '</div> ';		
		echo $output;
	}
