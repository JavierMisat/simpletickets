<?php
$output = $title = $tab_id = '';
extract(shortcode_atts($this->predefined_atts, $atts));

wp_enqueue_script('jquery_ui_tabs_rotate');	
		$output .= "\n\t\t\t" . '<div>';
		$output .= ($content=='' || $content==' ') ? __("Empty tab. Edit page to add content here.", "alaska") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
		$output .= "\n\t\t\t" . '</div> ';
		echo $output;		
