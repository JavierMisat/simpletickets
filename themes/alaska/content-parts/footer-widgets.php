<?php
global $ts_alaska;
$number_widget = isset($ts_alaska['ts-footer-number-widget']) ? $ts_alaska['ts-footer-number-widget'] : '';

switch ($number_widget) {
	case '1':
		echo '<footer><div class="container"><div class="row">';
		dynamic_sidebar('footer_widget_1');
		echo '</div></div></footer>';
		break;
	case '2':
		echo '<footer><div class="container"><div class="row">';
		echo '<div class="col-lg-6 col-md-6 col-sm-6">';
		dynamic_sidebar('footer_widget_1');
		echo '</div>';
		echo '<div class="col-lg-6 col-md-6 col-sm-6 last">';
		dynamic_sidebar('footer_widget_2');
		echo '</div>';
		echo '</div></div></footer>';
		break;
	case '3':
		echo '<footer><div class="container"><div class="row">';
		echo '<div class="col-lg-4 col-md-4 col-sm-6">';
		dynamic_sidebar('footer_widget_1');
		echo '</div>';
		echo '<div class="col-lg-4 col-md-4 col-sm-6">';
		dynamic_sidebar('footer_widget_2');
		echo '</div>';
		echo '<div class="col-lg-4 col-md-4 col-sm-6 last">';
		dynamic_sidebar('footer_widget_3');
		echo '</div>';
		echo '</div></div></footer>';
		break;
	case '4':
		echo '<footer><div class="container"><div class="row">';
		echo '<div class="col-lg-3 col-md-3 col-sm-6">';
		dynamic_sidebar('footer_widget_1');
		echo '</div>';
		echo '<div class="col-lg-3 col-md-3 col-sm-6">';
		dynamic_sidebar('footer_widget_2');
		echo '</div>';
		echo '<div class="col-lg-3 col-md-3 col-sm-6">';
		dynamic_sidebar('footer_widget_3');
		echo '</div>';
		echo '<div class="col-lg-3 col-md-3 col-sm-6 last">';
		dynamic_sidebar('footer_widget_4');
		echo '</div>';
		echo '</div></div></footer>';
		break;
}

?>
