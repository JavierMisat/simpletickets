<?php
	/**
	 * This file represents an example of the code that themes would use to register
	 * the required plugins.
	 *
	 * It is expected that theme authors would copy and paste this code into their
	 * functions.php file, and amend to suit.
	 *
	 * @package    TGM-Plugin-Activation
	 * @subpackage Example
	 * @version    2.4.0
	 * @author     Thomas Griffin <thomasgriffinmedia.com>
	 * @author     Gary Jones <gamajo.com>
	 * @copyright  Copyright (c) 2014, Thomas Griffin
	 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
	 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
	 */

	/**
	 * Include the TGM_Plugin_Activation class.
	 */
// require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

	add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register two plugins - one included with the TGMPA library
	 * and one from the .org repo.
	 *
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function my_theme_register_required_plugins()
	{

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => false,
				'version'  => '',
			),
			array(
				'name'     => 'WP Retina 2x',
				'slug'     => 'wp-retina-2x',
				'required' => false,
				'version'  => '',
			),
			array(
				'name'     => 'oAuth Twitter Feed', // The plugin name
				'slug'     => 'oauth-twitter-feed-for-developers', // The plugin slug (typically the folder name)
				'required' => false, // If false, the plugin is only 'recommended' instead of required
				'version'  => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			),
			array(
				'name'               => 'Visual Composer Plugin', // The plugin name
				'slug'               => 'js_composer', // The plugin slug (typically the folder name)
				'source'             => get_template_directory().'/core/plugins/js_composer.zip', // The plugin source
				'required'           => false, // If false, the plugin is only 'recommended' instead of required
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => 'Revolution Slider', // The plugin name
				'slug'               => 'revslider', // The plugin slug (typically the folder name)
				'source'             => get_template_directory().'/core/plugins/revslider.zip', // The plugin source.
				'required'           => false, // If false, the plugin is only 'recommended' instead of required
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => 'Alaska Core', // The plugin name
				'slug'               => 'alaska-core', // The plugin slug (typically the folder name)
				'source'             => 'http://resources.themestudio.net/alaska/alaska-core.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required
				'version'            => '2.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '', // If set, overrides default API URL and points to an external URL
			),
		);

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );

	}