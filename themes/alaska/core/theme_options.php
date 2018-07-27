<?php
/**ReduxFramework Sample Config File
 * For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */

if (!class_exists("Redux_Framework_sample_config")) {

	class Redux_Framework_sample_config
	{

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct()
		{

			if (!class_exists("ReduxFramework")) {
				return;
			}

			$this->initSettings();
		}

		public function initSettings()
		{

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if (!isset($this->args['opt_name'])) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			// Change the default value of a field after it's been set, but before it's been useds
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
			// Dynamically add a section. Can be also used to modify sections/fields
			add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
		}

		/**
		 *This is a test function that will let you see when the compiler hook occurs.
		 *It only runs if a field   set with compiler=>true is changed.
		 * */
		function compiler_action($options, $css)
		{
			//echo "<h1>The compiler hook has run!";
			//print_r($options); //Option values
			//print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

			/*
			  // Demo of how to use the dynamic CSS and write your own static CSS file
			  $filename = dirname(__FILE__) . '/style' . '.css';
			  global $wp_filesystem;
			  if( empty( $wp_filesystem ) ) {
			  require_once( ABSPATH .'/wp-admin/includes/file.php' );
			  WP_Filesystem();
			  }

			  if( $wp_filesystem ) {
			  $wp_filesystem->put_contents(
			  $filename,
			  $css,
			  FS_CHMOD_FILE // predefined mode settings for WP files
			  );
			  }
			 */
		}

		/**
		 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 * Simply include this function in the child themes functions.php file.
		 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 * so you must use get_template_directory_uri() if you want to use any of the built in icons
		 * */
		function dynamic_section($sections)
		{
			//$sections = array();
			// $sections[] = array(
			//     'title' => __('Section via hook', 'alaska'),
			//     'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'alaska'),
			//     'icon' => 'el-icon-paper-clip',
			//     // Leave this as a blank section, no options just some intro text set above.
			//     'fields' => array()
			// );

			return $sections;
		}

		/**
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 * */
		function change_arguments($args)
		{
			//$args['dev_mode'] = true;

			return $args;
		}

		/**
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 * */
		function change_defaults($defaults)
		{
			$defaults['str_replace'] = "Testing filter hook!";

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo()
		{

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if (class_exists('ReduxFrameworkPlugin')) {
				remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));

			}
		}

		public function setSections()
		{

			/**
			 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 * */
			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns = array();

			if (is_dir($sample_patterns_path)) :

				if ($sample_patterns_dir = opendir($sample_patterns_path)) :
					$sample_patterns = array();

					while (($sample_patterns_file = readdir($sample_patterns_dir)) !== false) {

						if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
							$name = explode(".", $sample_patterns_file);
							$name = str_replace('.' . end($name), '', $sample_patterns_file);
							$sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
						}
					}
				endif;
			endif;

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name');
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'alaska'), $this->theme->display('Name'));
			?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
				<?php if ($screenshot) : ?>
					<?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                           title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>"
                                 alt="<?php echo esc_html__('Current theme preview', 'alaska'); ?>"/>
                        </a>
					<?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>"
                         alt="<?php echo esc_html__('Current theme preview', 'alaska'); ?>"/>
				<?php endif; ?>

                <h4>
					<?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(esc_html__('By %s', 'alaska'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(esc_html__('Version %s', 'alaska'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'alaska') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
					<?php
					if ($this->theme->parent()) {
						printf(
							' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.','alaska') . '</p>', esc_html__('http://codex.wordpress.org/Child_Themes', 'alaska'), $this->theme->parent()
							->display('Name')
						);
					}
					?>

                </div>

            </div>

			<?php

			ob_end_clean();

			$sampleHTML = '';
			if (file_exists(dirname(__FILE__) . '/info-html.html')) {
				/** @global WP_Filesystem_Direct $wp_filesystem */
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once(ABSPATH . '/wp-admin/includes/file.php');
					WP_Filesystem();
				}
				$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
			}

			$allow_tags = array(
				'a' => array(
					'href' => array(),
					'target' => array(),
					'title' => array(),
				),
				'h1' => array(),
				'h2' => array(),
				'h3' => array(),
				'h4' => array(),
				'h5' => array(),
				'h6' => array(),
				'p' => array(),
				'strong' => array(),
				'b' => array(),
				'i' => array(),
				'em' => array(),
				'span' => array(),
			);

			/*--General Settings--*/
			$this->sections[] = array(
				'icon' => 'el-icon-cogs',
				'title' => __('General Settings', 'alaska'),
				'fields' => array(
					array(
						'id' => 'general_introduction',
						'type' => 'info',
						'style' => 'success',
						'title' => __('Welcome to ALASKA Theme Option Panel', 'alaska'),
						'icon' => 'el-icon-info-sign',
						'desc' => __('From here you can config ALASKA theme in the way you need.', 'alaska'),
					),
					array(
						'id' => 'ts-logo',
						'type' => 'media',
						'url' => true,
						'title' => __('Logo upload', 'alaska'),
						'compiler' => 'true',
						'desc' => __('Upload your logo image', 'alaska'),
						'subtitle' => __('Upload your custom logo image', 'alaska'),
						'default' => array('url' => get_template_directory_uri() . '/assets/images/logo.png'),
					),
					array(
						'id' => 'ts-logo-svg',
						'type' => 'textarea',
						'url' => true,
						'title' => __('Logo SVG code', 'alaska'),
						'compiler' => 'true',
						'desc' => wp_kses(wpautop('Paste your svg code. How to Use “Logo SVG code” Option to Create Retina Logo?: <a href="http://support.themestudio.net/knowledge-base/how-to-use-logo-svg-code-option-to-create-retina-logo/">Click here</a>'), $allow_tags),
						'subtitle' => __('Paste your svg code', 'alaska'),
					),
					array(
						'id' => 'ts-favicon',
						'type' => 'media',
						'title' => __('Upload favicon', 'alaska'),
						'desc' => __('Upload a 16px x 16px .png or .gif image that will be your favicon.', 'alaska'),
						'subtitle' => __('Upload your custom favicon image', 'alaska'),
						'default' => array('url' => get_template_directory_uri() . '/assets/images/favicon.png'),
					),
					array(
						'id' => 'ts-accent-color',
						'type' => 'color',
						'title' => __('Accent Color', 'alaska'),
						'desc' => __('Change this color to alter the accent color globally for your website. ', 'alaska'),
						'subtitle' => __('Accent color (default: ).', 'alaska'),
						'default' => '#fd4326',
						'validate' => 'color',
					),
					array(
						'id' => 'ts-css-code',
						'type' => 'ace_editor',
						'title' => __('Custom CSS', 'alaska'),
						'subtitle' => __('Paste your custom CSS code here.', 'alaska'),
						'mode' => 'css',
						'theme' => 'monokai',
						'desc' => 'Custom css code.',
						'default' => "",
					),
					array(
						'id' => 'ts-tracking-code',
						'type' => 'ace_editor',
						'title' => __('Custom JS', 'alaska'),
						'subtitle' => __('Paste your custom JS code here.', 'alaska'),
						'mode' => 'javascript',
						'theme' => 'chrome',
						'desc' => 'Custom javascript code',
						'default' => "jQuery(document).ready(function(){\n\n});",
					),
				),
			);
			/*--Typograply Options--*/
			$this->sections[] = array(
				'icon' => 'el-icon-font',
				'title' => __('Typography Options', 'alaska'),
				'fields' => array(
					array(
						'id' => 'ts-typo-body-font',
						'type' => 'typography',
						'title' => __('Body Font Setting', 'alaska'),
						'subtitle' => __('Specify the body font properties.', 'alaska'),
						'google' => true,
						'output' => 'body',
						'default' => array(
							'font-family' => 'Roboto',
							'font-weight' => '300',
						),
					),
					array(
						'id' => 'ts-menu-font',
						'type' => 'typography',
						'title' => __('Menu Item Font Setting', 'alaska'),
						'subtitle' => __('Specify the menu font properties.', 'alaska'),
						'output' => array('nav'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
						),
					),
					array(
						'id' => 'ts-typo-h1-font',
						'type' => 'typography',
						'title' => __('Heading 1(H1) Font Setting', 'alaska'),
						'subtitle' => __('Specify the H1 tag font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
						),
						'output' => 'h1',
					),
					array(
						'id' => 'ts-typo-h2-font',
						'type' => 'typography',
						'title' => __('Heading 2(H2) Font Setting', 'alaska'),
						'subtitle' => __('Specify the H2 tag font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
						),
						'output' => 'h2',
					),
					array(
						'id' => 'ts-typo-h3-font',
						'type' => 'typography',
						'title' => __('Heading 3(H3) Font Setting', 'alaska'),
						'subtitle' => __('Specify the H3 tag font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
						),
						'output' => 'h3',
					),
					array(
						'id' => 'ts-typo-h4-font',
						'type' => 'typography',
						'title' => __('Heading 4(H4) Font Setting', 'alaska'),
						'subtitle' => __('Specify the H4 tag font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
						),
						'output' => 'h4',
					),
					array(
						'id' => 'ts-typo-h5-font',
						'type' => 'typography',
						'title' => __('Heading 5(H5) Font Setting', 'alaska'),
						'subtitle' => __('Specify the H5 tag font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
						),
						'output' => 'h5',
					),

					array(
						'id' => 'ts-typo-h6-font',
						'type' => 'typography',
						'title' => __('Heading 6(H6) Font Setting', 'alaska'),
						'subtitle' => __('Specify the H6 tag font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
						),
						'output' => 'h6',
					),
					array(
						'id' => 'ts-typo-roboto500',
						'type' => 'typography',
						'title' => __('Font roboto500 Setting', 'alaska'),
						'subtitle' => __('Specify the roboto 500 font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
							'font-weight' => '500',
						),
					),
					array(
						'id' => 'ts-typo-roboto400',
						'type' => 'typography',
						'title' => __('Font roboto400 Setting', 'alaska'),
						'subtitle' => __('Specify the roboto 400 font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
							'font-weight' => '400',
						),
					),
					array(
						'id' => 'ts-typo-roboto100',
						'type' => 'typography',
						'title' => __('Font roboto100 Setting', 'alaska'),
						'subtitle' => __('Specify the roboto 100 font properties.', 'alaska'),
						'google' => true,
						'default' => array(
							'font-family' => 'Roboto',
							'font-weight' => '100',
						),
					),
				),
			);
			/*--Info bar--*/
			$this->sections[] = array(
				'icon' => 'el-icon-address-book-alt',
				'title' => __('Info Bar', 'alaska'),
				'fields' => array(
					array(
						'id' => 'ts-switch-info-bar',
						'type' => 'switch',
						'title' => __('Enable/Disabled Info Bar', 'alaska'),
						'subtitle' => __('Enable/Disabled Info Bar', 'alaska'),
						'default' => true,
					),
					array(
						'id' => 'info_title',
						'type' => 'text',
						'title' => __('Info Title', 'alaska'),
						'subtitle' => __('Title info bar.', 'alaska'),
						'default' => 'Welcome Alaska',
					),
					array(
						'id' => 'info_bar_description',
						'type' => 'editor',
						'title' => __('Info bar', 'alaska'),
						'subtitle' => __('Information for website or team building.', 'alaska'),
						'default' => __('<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry is standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'alaska'),
					),
					array(
						'id' => 'info_title_touch',
						'type' => 'text',
						'title' => __('Get In Touch title', 'alaska'),
						'subtitle' => __('Add title for touch.', 'alaska'),
						'default' => 'Get In Touch',
					),
					array(
						'id' => 'info_address',
						'type' => 'text',
						'title' => __('Address', 'alaska'),
						'subtitle' => __('Add address for info bar.', 'alaska'),
						'default' => 'PO Box 16122 Collins Street West Victoria 8007 Australia',
					),
					array(
						'id' => 'info_email',
						'type' => 'text',
						'title' => __('Email', 'alaska'),
						'subtitle' => __('Add email for info bar.', 'alaska'),
						'default' => 'no-replay@envato.com',
					),
					array(
						'id' => 'info_phone',
						'type' => 'text',
						'title' => __('Phone', 'alaska'),
						'subtitle' => __('Add phone for info bar.', 'alaska'),
						'default' => '(123) 222 5555',
					),
					array(
						'id' => 'info_fax',
						'type' => 'text',
						'title' => __('Phone', 'alaska'),
						'subtitle' => __('Add phone for info bar.', 'alaska'),
						'default' => '084 (123) 456-7890',
					),
					array(
						'id' => 'info_title_map',
						'type' => 'text',
						'title' => __('Map title', 'alaska'),
						'subtitle' => __('Add title for map.', 'alaska'),
						'default' => 'Our Location',
					),
					array(
						'id' => 'info_map',
						'type' => 'media',
						'url' => true,
						'title' => __('Map upload', 'alaska'),
						'compiler' => 'true',
						'desc' => __('Upload your Map image', 'alaska'),
						'subtitle' => __('Upload your custom map image', 'alaska'),
						'default' => array('url' => get_template_directory_uri() . '/assets/images/map.png'),
					),
				),
			);
			/*
			 * Menu settings
			*/
			$this->sections[] = array(
				'title' => __('Menu Style', 'alaska'),
				'desc' => __('Menu Style Settings', 'alaska'),
				'icon' => 'el-icon-lines',
				'fields' => array(
					array(
						'id' => 'ts-menu-hover-effect',
						'type' => 'select',
						'title' => __('Menu hover effect', 'alaska'),
						'options' => array(
							'fade' => 'Fade',
							'slide-top' => 'Slide Top',
							'slide-bottom' => 'Slide Bottom',
							'slide-left' => 'Slide Left',
							'slide-right' => 'Slide Right',
						),
						'default' => 'slide-top',
					),
				),
			);
			/*
			 * Sidebar settings
			*/
			$this->sections[] = array(
				'title' => __('Sidebar Settings', 'alaska'),
				'desc' => __('Sidebar Settings Settings', 'alaska'),
				'icon' => 'el-icon-list',
				'fields' => array(
					array(
						'id' => 'sidebars',
						'type' => 'multi_text',
						'title' => __('Custom Sidebars', 'alaska'),
						'default' => array('Custom Sidebar'),
					),
				),
			);
			// Header Settings
			$this->sections[] = array(
				'title' => __('Header Settings', 'alaska'),
				'desc' => __('Header Settings', 'alaska'),
				'icon' => 'el-icon-flag',
				'fields' => array(
					array(
						'id' => 'ts-header-style',
						'type' => 'button_set',
						'title' => __('Select your header style', 'alaska'),
						'subtitle' => __('Select header style', 'alaska'),
						'options' => array('header_right' => 'Header right', 'header_center' => 'Header center'),
						'default' => 'header_right',
					),

					array(
						'id' => 'ts-show-search',
						'type' => 'button_set',
						'title' => __('Choose show/hide search on menu.', 'alaska'),
						'subtitle' => __('Choose show/hide search on menu header center.', 'alaska'),
						'options' => array('show' => 'Show', 'hide' => 'Hide'),
						'default' => 'show',
						'required' => array('ts-header-style', 'equals', array('header_center')),
					),
					array(
						'id' => 'ts-background-color',
						'type' => 'button_set',
						'title' => __('Choose background image/color', 'alaska'),
						'subtitle' => __('Image/color for header', 'alaska'),
						'options' => array('image' => 'Image', 'color' => 'Color'),
						'default' => 'image',
						'required' => array('ts-header-style', 'equals', array('header_center')),
					),
					array(
						'id' => 'ts-background-center',
						'type' => 'media',
						'url' => true,
						'title' => __('Background header image', 'alaska'),
						'compiler' => 'true',
						'desc' => __('Upload your background header style header center', 'alaska'),
						'subtitle' => __('Upload your custom background header', 'alaska'),
						'default' => array('url' => get_template_directory_uri() . '/assets/images/9.png'),
						'required' => array('ts-background-color', 'equals', array('image')),
					),
					array(
						'id' => 'ts-background-color-header',
						'type' => 'color',
						'title' => __('Background header color', 'alaska'),
						'desc' => __('Change this color to alter the color header for your website. ', 'alaska'),
						'subtitle' => __('Accent color (default: ).', 'alaska'),
						'default' => '',
						'validate' => 'color',
						'required' => array('ts-background-color', 'equals', array('color')),
					),
					array(
						'id' => 'ts-header-center-title',
						'type' => 'text',
						'title' => __('Support text', 'alaska'),
						'subtitle' => __('Text for header suport', 'alaska'),
						'default' => 'CALL OUR SUPPORT  24/7',
						'required' => array('ts-header-style', 'equals', array('header_center')),
					),
					array(
						'id' => 'ts-header-center-phone',
						'type' => 'text',
						'title' => __('Number phone suport', 'alaska'),
						'subtitle' => __('Number phone for header suport', 'alaska'),
						'desc' => __('Empty if you do not want display. default: not empty', 'alaska'),
						'default' => '+1 (425) 274-4500',
						'required' => array('ts-header-style', 'equals', array('header_center')),
					),
					array(
						'id' => 'ts-text-livechat',
						'type' => 'text',
						'title' => __('Live chat Text', 'alaska'),
						'subtitle' => __('Live chat text for your website', 'alaska'),
						'default' => 'LIVE CHAT',
						'required' => array('ts-header-style', 'equals', array('header_center')),
					),
					array(
						'id' => 'ts-header-livechat',
						'type' => 'text',
						'title' => __('Live chat url', 'alaska'),
						'subtitle' => __('Live chat url for your website', 'alaska'),
						'desc' => __('Empty if you do not want display. default: not empty', 'alaska'),
						'default' => '#',
						'required' => array('ts-header-style', 'equals', array('header_center')),
					),
					array(
						'id' => 'ts-whmcs-register-url',
						'type' => 'text',
						'title' => __('Whmcs register url', 'alaska'),
						'subtitle' => __('Register url for whmcs', 'alaska'),
						'default' => 'http://alaska.themestudio.net/whmcs-bridge-2/register/',
						'desc' => __('Empty if you do not want display. default: not empty', 'alaska'),
					),
					array(
						'id' => 'ts-text-signup',
						'type' => 'text',
						'title' => __('Sign up Text', 'alaska'),
						'subtitle' => __('Sign up text for your website', 'alaska'),
						'default' => 'SIGN UP',
					),
					array(
						'id' => 'ts-whmcs-login-url',
						'type' => 'text',
						'title' => __('Whmcs login url', 'alaska'),
						'subtitle' => __('Login url for whmcs', 'alaska'),
						'default' => 'http://alaska.themestudio.net/whmcs-bridge-2/login/',
						'desc' => __('Empty if you do not want display. default: not empty', 'alaska'),
					),
					array(
						'id' => 'ts-text-login',
						'type' => 'text',
						'title' => __('Login Text', 'alaska'),
						'subtitle' => __('Login for your website', 'alaska'),
						'default' => 'Login',
					),
					array(
						'id' => 'ts-whmcs-client-area-url',
						'type' => 'text',
						'title' => __('Whmcs client area url', 'alaska'),
						'subtitle' => __('Client area url for whmcs', 'alaska'),
						'default' => 'http://alaska.themestudio.net/whmcs-bridge-2/clientarea/',
						'desc' => __('Empty if you do not want display. default: not empty', 'alaska'),
					),
					array(
						'id' => 'ts-text-client-area',
						'type' => 'text',
						'title' => __('Client area Text', 'alaska'),
						'subtitle' => __('Client area text for your website', 'alaska'),
						'default' => 'Client Area',
					),

					array(
						'id' => 'ts-topbar-showhide',
						'type' => 'button_set',
						'title' => __('Show/hide topbar', 'alaska'),
						'subtitle' => __('Show/hide topbar', 'alaska'),
						'options' => array('show' => 'Show', 'hide' => 'Hide'),
						'default' => 'show',
					),
					array(
						'id' => 'ts-header-social-list',
						'type' => 'slides',
						'title' => __('Social list', 'alaska'),
						'subtitle' => __('Unlimited slides with drag and drop sortings.', 'alaska'),
						'desc' => __('Font awesome icon class', 'alaska'),
						'placeholder' => array(
							'title' => __('This is a class icon font awesome.', 'alaska'),
							'description' => __('Description Here', 'alaska'),
							'url' => __('Give us a link!', 'alaska'),
						),
						'default' => array(
							array(
								'title' => __('facebook', 'alaska'),
								'description' => __('Facebook', 'alaska'),
								'url' => __('http://facebook.com', 'alaska'),
							),
							array(
								'title' => __('twitter', 'alaska'),
								'description' => __('Twitter', 'alaska'),
								'url' => __('http://twitter.com', 'alaska'),
							),
							array(
								'title' => __('google-plus', 'alaska'),
								'description' => __('Goole plus', 'alaska'),
								'url' => __('http://plus.google.com', 'alaska'),
							),
							array(
								'title' => __('skype', 'alaska'),
								'description' => __('Skype', 'alaska'),
								'url' => __('#', 'alaska'),
							),
						),
						'required' => array('ts-topbar-showhide', 'equals', array('show')),
					),
					array(
						'id' => 'ts-top-right-content',
						'type' => 'editor',
						'title' => __('Top right content', 'alaska'),
						'subtitle' => __('Top right content', 'alaska'),
						'default' => '<ul>
                                <li><a href="#"><i class="fa fa-exclamation-circle"></i>Support</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i>Email Us</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>1234-567-89000</a></li>
                            </ul>',
						'required' => array('ts-topbar-showhide', 'equals', array('show')),
					),

				),
			);
			/*--Blog--*/
			$this->sections[] = array(
				'title' => __('Blog Settings', 'alaska'),
				'desc' => __('Blog Settings', 'alaska'),
				'icon' => 'el-icon-th-list',
				'fields' => array(
					array(
						'id' => 'ts-blog-title',
						'type' => 'text',
						'title' => __('Blog title', 'alaska'),
						'subtitle' => __('Title for blog page', 'alaska'),
						'default' => 'Blog',
					),
					array(
						'id' => 'ts-blog-sub-title',
						'type' => 'text',
						'title' => __('Blog sub title', 'alaska'),
						'subtitle' => __('Sub title for blog page', 'alaska'),
						'default' => 'Our perspective on digital (and other things)',
					),
					array(
						'id' => 'ts-blog-reading-text',
						'type' => 'text',
						'title' => __('Continue reading', 'alaska'),
						'subtitle' => __('Continue reading text', 'alaska'),
						'default' => 'read more',
					),
					array(
						'id' => 'ts-blog-content',
						'type' => 'select',
						'title' => __('Blog metas', 'alaska'),
						'options' => array(
							'content' => 'Show Content',
							'excerpt' => 'Show Excerpt',
						),
						'default' => 'excerpt',
					),
					array(
						'id' => 'ts-blog-sidebar-position',
						'type' => 'image_select',
						'compiler' => true,
						'title' => __('Sidebar position', 'alaska'),
						'subtitle' => __('Select sidebar position.', 'alaska'),
						'desc' => __('Select sidebar on left or right', 'alaska'),
						'options' => array(
							'1' => array('alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/assets/images/patterns/2cl.png'),
							'2' => array('alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/assets/images/patterns/2cr.png'),
							'3' => array('alt' => 'Full Width', 'img' => get_template_directory_uri() . '/assets/images/patterns/1column.png'),
						),
						'default' => '2',
					),
					array(
						'id' => 'ts-blog-metas',
						'type' => 'select',
						'multi' => true,
						'title' => __('Blog metas', 'alaska'),
						'options' => array(
							'author' => 'Author',
							'date' => 'Date time',
							'category' => 'Category',
							'comment' => 'Comment',
							'tags' => 'Tags',
						),
						'default' => array('date', 'author', 'category', 'comment'),
					),
					array(
						'id' => 'ts-blog-banner',
						'type' => 'background',
						'title' => __('Default Archive Header Background', 'alaska'),
						'subtitle' => __('Default Archive background with image, color, etc.', 'alaska'),
						'desc' => "",
						'default' => array(
							'background-image' => get_template_directory_uri() . '/assets/images/bg-banner.jpg',
							'background-position' => 'center top',
							'background-repeat' => 'no-repeat',
							'background-size' => 'cover',
							'background-attachment' => 'fixed',
						),
						'output' => '.blog-banner',
					),
				),
			);
			/*--Portfolio Setting--*/
			$this->sections[] = array(
				'title' => __('Portfolio Settings', 'alaska'),
				'desc' => __('Portfolio Settings', 'alaska'),
				'icon' => 'el-icon-folder',
				'fields' => array(
					array(
						'id' => 'portfolio_title',
						'type' => 'text',
						'title' => __('Portfolio archive title', 'alaska'),
						'subtitle' => __('Show title portfolio archive page', 'alaska'),
						'default' => 'Our Portfolio',
					),
					array(
						'id' => 'portfolio_sub_title',
						'type' => 'text',
						'title' => __('Portfolio archive sub title', 'alaska'),
						'subtitle' => __('Show sub title portfolio archive page', 'alaska'),
						'default' => 'creating the most beautiful designs',
					),
					array(
						'id' => 'portfolio-item-width',
						'type' => 'slider',
						'title' => __('Portfolio item width', 'alaska'),
						'subtitle' => __('This option set width for portfolio item', 'alaska'),
						'desc' => __('Portfolio with. Min: 50, max: 1000, step: 1, default value: 320', 'alaska'),
						"default" => 320,
						"min" => 50,
						"step" => 15,
						"max" => 1000,
						'display_value' => 'text',
					),
					array(
						'id' => 'portfolio-item-height',
						'type' => 'slider',
						'title' => __('Portfolio item height', 'alaska'),
						'subtitle' => __('This option set height for portfolio item', 'alaska'),
						'desc' => __('Portfolio with. Min: 50, max: 1000, step: 1, default value: 200', 'alaska'),
						"default" => 200,
						"min" => 50,
						"step" => 15,
						"max" => 1000,
						'display_value' => 'text',
					),
					array(
						'id' => 'show_hide_filter',
						'type' => 'button_set',
						'title' => __('Show hide filter portfolio', 'alaska'),
						'subtitle' => __('Show/hide portfolio onload', 'alaska'),
						'desc' => __('Select show hide style.', 'alaska'),
						'options' => array('show_filter_portfolio' => 'Show', 'hide_filter_portfolio' => 'Hide'),
						'default' => 'show_filter_portfolio',
					),
					array(
						'id' => 'portfolio_hover_opacity',
						'type' => 'slider',
						'title' => __('Portfolio hover opacity', 'alaska'),
						'subtitle' => __('Portfolio hover opacity from 0 to 1', 'alaska'),
						'desc' => __('Min: 0, max: 1, step: 0.1, default value: 0.85', 'alaska'),
						"default" => 0.85,
						"min" => 0,
						"step" => 0.1,
						"max" => 1,
						'resolution' => 0.1,
						'display_value' => 'text',
					),
					array(
						'id' => 'portfolio_switch_pagination',
						'type' => 'button_set',
						'title' => __('Show hide portfolio pagination', 'alaska'),
						'subtitle' => __('Show/hide portfolio pagination', 'alaska'),
						'desc' => __('Select show hide style.', 'alaska'),
						'options' => array('show_portfolio_pagination' => 'Show', 'hide_portfolio_pagination' => 'Hide'),
						'default' => 'hide_portfolio_pagination',
					),
					array(
						'id' => 'portfolio_banner_bg',
						'type' => 'background',
						'title' => __('Default portfolio header background', 'alaska'),
						'subtitle' => __('Default Portfolio background with image, color, etc.', 'alaska'),
						'desc' => "",
						'default' => array(
							'background-image' => get_template_directory_uri() . '/assets/images/bg-banner.jpg',
							'background-position' => 'center top',
							'background-repeat' => 'no-repeat',
							'background-size' => 'cover',
							'background-attachment' => 'fixed',
						),
						'output' => '.portfolio-banner',
					),
					array(
						'id' => 'main_portfolio_page',
						'type' => 'text',
						'title' => __('Main portfolio page set for single portfolio page', 'alaska'),
						'subtitle' => __('You can custom portfolio main page for single portfolio page here', 'alaska'),
						'desc' => "",
						// 'validate' => 'url',
						// 'msg'      => 'custom error message',
						'default' => '#',
					),
				),
			);

			/**
			 * Check if WooCommerce is active
			 **/
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
				// Put your plugin code here

				/*-- Woocommerce Setting--*/
				$this->sections[] = array(
					'title' => __('Woocommerce', 'alaska'),
					'desc' => __('Woocommerce Settings', 'alaska'),
					'icon' => 'el-icon-shopping-cart',
					'fields' => array(
						array(
							'id' => 'woo_layout',
							'type' => 'image_select',
							'compiler' => true,
							'title' => __('Woocommerce sidebar position', 'alaska'),
							'subtitle' => __('Select Woocommerce sidebar position.', 'alaska'),
							'desc' => __('Select sidebar on left or right', 'alaska'),
							'options' => array(
								'left-sidebar' => array('alt' => '1 Column Left', 'img' => get_template_directory_uri() . '/assets/images/patterns/2cl.png'),
								'right-sidebar' => array('alt' => '2 Column Right', 'img' => get_template_directory_uri() . '/assets/images/patterns/2cr.png'),
								'fullwidth' => array('alt' => 'Full Width', 'img' => get_template_directory_uri() . '/assets/images/patterns/1column.png'),
							),
							'default' => 'left-sidebar',
						),
						array(
							'id' => 'woo_product_layout',
							'type' => 'image_select',
							'compiler' => true,
							'title' => __('Woocommerce product layout', 'alaska'),
							'subtitle' => __('Set number column in product archive page.', 'alaska'),
							'options' => array(
								'3' => array('alt' => '3 Column ', 'img' => get_template_directory_uri() . '/assets/images/patterns/3columns.png'),
								'4' => array('alt' => '4 Column ', 'img' => get_template_directory_uri() . '/assets/images/patterns/4columns.png'),
							),
							'default' => '3',
						),
					),
				);
			}

			/*--Footer setting--*/
			$this->sections[] = array(
				'title' => __('Footer Settings', 'alaska'),
				'desc' => __('Footer Settings', 'alaska'),
				'icon' => 'el-icon-credit-card',
				'fields' => array(
					array(
						'id' => 'show-hide-footer',
						'type' => 'button_set',
						'title' => __('Show hide call to action footer', 'alaska'),
						'subtitle' => __('Show/hide call to action footer onload', 'alaska'),
						'desc' => __('Select show hide style.', 'alaska'),
						'options' => array('show_footer' => 'Show', 'hide_footer' => 'Hide'),
						'default' => 'show_footer',
					),
					array(
						'id' => 'footer_calltoaction_footer',
						'type' => 'slides',
						'title' => __('Footer call to action', 'alaska'),
						'subtitle' => __('You can modify html for footer call to action.', 'alaska'),
						'desc' => __('Font awesome icon class for description.', 'alaska'),
						'placeholder' => array(
							'title' => __('Title Here', 'alaska'),
							'description' => __('This is a class icon font awesome.', 'alaska'),
							'url' => __('Give us a link!', 'alaska'),
						),
						'default' => array(
							array(
								'title' => __('Email us', 'alaska'),
								'description' => __('fa-envelope-o', 'alaska'),
								'url' => __('mailto:support@alaska.com', 'alaska'),
							),
							array(
								'title' => __('1-1800-123-6789', 'alaska'),
								'description' => __('fa-phone', 'alaska'),
								'url' => __('#', 'alaska'),
							),
							array(
								'title' => __('Live chat with us', 'alaska'),
								'description' => __('fa-comment-o', 'alaska'),
								'url' => __('javascript:$zopim.livechat.window.show()', 'alaska'),
							),
						),
						'required' => array('show-hide-footer', 'equals', array('show_footer')),
					),
					array(
						'id' => 'ts-footer-number-widget',
						'type' => 'image_select',
						'compiler' => true,
						'title' => __('Footer widgets', 'alaska'),
						'subtitle' => __('Select footer number widget.', 'alaska'),
						'options' => array(
							'1' => array('alt' => '1 Column', 'img' => get_template_directory_uri() . '/assets/images/patterns/1column.png'),
							'2' => array('alt' => '2 Column ', 'img' => get_template_directory_uri() . '/assets/images/patterns/2columns.png'),
							'3' => array('alt' => '3 Column ', 'img' => get_template_directory_uri() . '/assets/images/patterns/3columns.png'),
							'4' => array('alt' => '4 Column ', 'img' => get_template_directory_uri() . '/assets/images/patterns/4columns.png'),
						),
						'default' => '4',
					),
					array(
						'id' => 'footer_copyright_text',
						'type' => 'editor',
						'title' => __('Footer copyright text', 'alaska'),
						'subtitle' => __('Copyright text', 'alaska'),
						'default' => __('<p>© 2014 Alaska Hosting. All rights reserved.</p>', 'alaska'),
					),
					array(
						'id' => 'ts-footer-menu',
						'type' => 'editor',
						'title' => __('Footer menu', 'alaska'),
						'subtitle' => __('Footer menu', 'alaska'),
						'default' => '<ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">promotions</a></li>
                            <li><a href="#">services</a></li>
                            <li><a href="#">contact</a></li>
                        </ul>',
					),
				),
			);

			/*--Import/Export Setting--*/
			$this->sections[] = array(
				'title' => __('Import/Export ', 'alaska'),
				'desc' => __('Import/Export Settings', 'alaska'),
				'icon' => 'el-icon-refresh',
				'fields' => array(
					array(
						'id' => 'opt-import-export',
						'type' => 'import_export',
						'title' => 'Import Export',
						'subtitle' => 'Save and restore your Redux options',
						'full_width' => false,
					),
				),
			);
		}

		public function setHelpTabs()
		{

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id' => 'redux-opts-1',
				'title' => __('Theme Information 1', 'alaska'),
				'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'alaska'),
			);

			$this->args['help_tabs'][] = array(
				'id' => 'redux-opts-2',
				'title' => __('Theme Information 2', 'alaska'),
				'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'alaska'),
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'alaska');
		}

		/**
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		public function setArguments()
		{

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name' => 'alaska', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
				'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type' => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu' => false, // Show the sections below the admin menu item or not
				'menu_title' => __('ALASKA Options', 'alaska'),
				'page_title' => __('ALASKA Options', 'alaska'),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key' => 'AIzaSyA8xiYs49m_QkQ4M6gA-jtwYjNuQEVGJqo', // Must be defined to add google fonts to the typography module
				//'async_typography' => true, // Use a asynchronous font on the front end or font string
				//'admin_bar' => false, // Show the panel pages on the admin bar
				'global_variable' => 'ts_alaska', // Set a different name for your global variable other than the opt_name
				'dev_mode' => false, // Show the time the page took to load, etc
				'customizer' => true, // Enable basic customizer support
				// OPTIONAL -> Give you extra features
				'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent' => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon' => '', // Specify a custom URL to an icon
				'last_tab' => '', // Force your panel to always open to a specific tab (by id)
				'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug' => 'alaska_options', // Page slug used to denote the panel
				'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
				'default_show' => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
				// CAREFUL -> These options are for adalaskaced use only
				'transient_time' => 60 * MINUTE_IN_SECONDS,
				'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				//'domain'              => 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
				//'footer_credit'       => '', // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'show_import_export' => true, // REMOVE
				'system_info' => false, // REMOVE
				'help_tabs' => array(),
				'help_sidebar' => '',
				'hints' => array(
					'icon' => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color' => 'lightgray',
					'icon_size' => 'normal',

					'tip_style' => array(
						'color' => 'light',
						'shadow' => true,
						'rounded' => false,
						'style' => '',
					),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect' => array(
						'show' => array(
							'effect' => 'slide',
							'duration' => '500',
							'event' => 'mouseover',
						),
						'hide' => array(
							'effect' => 'slide',
							'duration' => '500',
							'event' => 'click mouseleave',
						),
					),
				),
			);

			$this->args['share_icons'][] = array(
				'url' => 'https://www.facebook.com/themestudionet',
				'title' => 'Like us on Facebook',
				'icon' => 'el-icon-facebook',
			);
			$this->args['share_icons'][] = array(
				'url' => 'http://twitter.com/themestudionet',
				'title' => 'Follow us on Twitter',
				'icon' => 'el-icon-twitter',
			);

			// Panel Intro text -> before the form
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				// $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'alaska'), $v);
			} else {
				// $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'alaska');
			}

			// Add content after the form.
			// $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'alaska');
		}

	}

	new Redux_Framework_sample_config();
}


/**
 *Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):

	function redux_my_custom_field($field, $value)
	{
		print_r($field);
		print_r($value);
	}

endif;

/**
 * Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):

	function redux_validate_callback_function($field, $value, $existing_value)
	{
		$error = false;
		$value = 'just testing';

		$return['value'] = $value;
		if ($error == true) {
			$return['error'] = $field;
		}

		return $return;
	}


endif;