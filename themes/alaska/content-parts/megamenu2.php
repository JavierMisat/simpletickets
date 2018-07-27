<?php
	global $ts_alaska;
	$menu_class =  'menu-nav list-inline ts-response-simple ts-response-stack ts-effect-'.$ts_alaska['ts-menu-hover-effect'];
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