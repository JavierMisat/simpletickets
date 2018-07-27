<?php
	
    /*
	 * Load theme support
	*/
			if ( file_exists( dirname( __FILE__ ) . '/theme_options.php' ) ) {
		    require_once( dirname( __FILE__ ) . '/theme_options.php' );
		}

    
	/*
	 * Load Required/Recommended Plugins
	*/
	require_once get_template_directory() . '/core/apis/class-tgm-plugin-activation.php';
	if (!is_child_theme()) {
		require_once get_template_directory() . '/core/plugins_load.php';
	}

	/*
	 * Load theme support
	*/
	require_once get_template_directory() . '/core/theme_support.php';

	/*
	 * Load theme register
	*/
	require_once get_template_directory() . '/core/theme_register.php';

	/*
	 * Load Bootstrap Menu Walker
	*/
	require_once get_template_directory() . '/core/apis/ts_megamenu_backend.php';
	/*
	 * Load Bootstrap Menu Walker
	*/
	require_once get_template_directory() . '/core/apis/ts_bootstrap_navwalker.php';

	// Load Visual Composer
	require_once get_template_directory() . '/core/shortcodes/visual-composer/themestudio_vc_functions.php';

	/*
	 * Load custom css and js
	*/
	require_once get_template_directory() . '/core/theme_styles_scripts.php';

	/*
	 * Load theme functions
	*/
	require_once get_template_directory() . '/core/theme_functions.php';

	/*
	 * Load custom widgets
	*/
	require_once get_template_directory() . '/core/widgets/ts_footer_contact.php';
	require_once get_template_directory() . '/core/widgets/ts_follow_us.php';
	require_once get_template_directory() . '/core/widgets/ts_menu_sidebar.php';

	if (class_exists('Vc_Manager')) {
		// vc_set_default_editor_post_types( array( 'page', 'portfolio','megamenu','feature', 'service' ) );
        vc_set_shortcodes_templates_dir( get_template_directory() . '/core/shortcodes/visual-composer/vc_templates/');
	}