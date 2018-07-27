<?php
	global $ts_alaska;
	$menu_efect = isset($ts_alaska['ts-menu-hover-effect']) ? $ts_alaska['ts-menu-hover-effect'] : 'slide-top';
	$menu_class =  'menu-nav list-inline ts-response-simple ts-response-stack ts-effect-'.esc_attr($menu_efect);
    wp_nav_menu(
        array(
            'theme_location'    => 'megamenu',
            'menu_id'         => 'menu-main-menu',
            'menu_class'        => $menu_class,
            'container' => false,
            'fallback_cb'       => 'ts_bootstrap_navwalker::fallback',
            'walker'            => new ts_bootstrap_navwalker()
            )
    );