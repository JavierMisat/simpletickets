<?php
	/**
	 * ThemeStudio Framework functions and definitions.
	 *
	 * @package WordPress
	 * @subpackage ThemeStudio.Net
	 * @since ThemeStudio Framework 1.0
	*/

	if ( ! isset( $content_width ) ) {
		$content_width = 960;
	}

	/**
	 * Sets up theme defaults and registers the various WordPress features that
	 * ThemeStudio Framework supports.
	 *
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_editor_style() To add a Visual Editor stylesheet.
	 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
	 * 	custom background, and post formats.
	 * @uses register_nav_menu() To add support for navigation menus.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since ThemeStudio Framework 1.0
	*/

	if( !function_exists( 'themestudio_setup' ) ) {

		/*
		 * setup text domain and style
		*/
		function themestudio_setup() {
			load_theme_textdomain( 'alaska', get_template_directory() . '/languages' );
			add_editor_style();
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-formats', array(  'image', 'gallery','video','audio','quote','aside','link' ) );
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( "title-tag" );

			if ( isset($ts_alaska) ) {
				global $ts_alaska;
				$args = array(
					'default-image' => $ts_alaska['menu_background_color']['background-image'],
				);

				add_theme_support( 'custom-header', $args );
				add_theme_support( 'custom-background', $args );

			}

			//add image sizes
			if(function_exists('add_image_size')) {
				add_image_size('full-size',  9999, 9999, false);
				add_image_size('small-thumb',  90, 90, true);
			}
		}
		add_action( 'after_setup_theme', 'themestudio_setup' );

	}

	/*
	 * Add theme support thumbnails
	*/
	add_theme_support('post-thumbnails', array('post', 'portfolio', 'service', 'member'));

	if( !function_exists( 'ts_add_thumbnail_size' ) ) {

		/*
		 * Add thumb size image when upload
		*/
		function ts_add_thumbnail_size($thumb_size){
			foreach ($thumb_size['imgSize'] as $sizeName => $size)
			{
				if($sizeName == 'base')
				{
					set_post_thumbnail_size($thumb_size['imgSize'][$sizeName]['width'], $thumb_size[$sizeName]['height'], true);
				} else {
					add_image_size(
						$sizeName,
						$thumb_size['imgSize'][$sizeName]['width'],
						$thumb_size['imgSize'][$sizeName]['height'],
						true
					);
				}
			}
		}

		$thumb_size['imgSize']['client-work'] = array('width'=>215,  'height'=>95);
		$thumb_size['imgSize']['portfolio-grid-4-full'] = array('width'=>473,  'height'=>350);
		$thumb_size['imgSize']['portfolio-list-full'] = array('width'=>1140,  'height'=>606);

		ts_add_thumbnail_size($thumb_size);

	}


	if( !function_exists( 'themestudio_scripts_styles' ) ) {

		/**
		 * Enqueues scripts and styles for front-end.
		 *
		 * @since ThemeStudio Framework 1.0
		 */
		function themestudio_scripts_styles() {
			global $wp_styles;

			/*
			 * Adds JavaScript to pages with the comment form to support
			 * sites with threaded comments (when in use).
			 */
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			// IE style

			wp_enqueue_style( 'themestudio-ie', get_template_directory_uri() . '/css/ie.css', array( 'themestudio-style' ), '1.0' );
			$wp_styles->add_data( 'themestudio-ie', 'conditional', 'lt IE 9' );
		}
		add_action( 'wp_enqueue_scripts', 'themestudio_scripts_styles' );

	}


	if(!( function_exists('themestudio_comment') )){

	  	/*
	  	 * Function comment
	  	*/
	  	function themestudio_comment($comment, $args, $depth) {
	  	$GLOBALS['comment'] = $comment;
	?>

		<!--Comment Item-->
        <div class="media comment-item" id="comment-<?php comment_ID() ?>">
            <!--Avatar-->
            <a class="pull-left" href="#">
                <!-- <img class="media-object" src="images/blog/img-9.jpg" alt=""> -->
                <?php echo get_avatar( $comment->comment_author_email, 100 ); ?>
            </a>
            <!--End Avatar-->
            <!--Content-->
            <div class="media-body">
                <h5 class="media-heading"><?php echo get_comment_author_link() ?></h5>
                <div class="meta-comment">
                	<span class="media-date"><?php echo get_comment_date(); ?></span>
                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-mail-reply"></i> Reply', 'alaska' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
                <div class="comment-text">
                    <?php echo wpautop( get_comment_text() ); ?>
                </div>
                <?php if ($comment->comment_approved == '0') : ?>
	              <p><em><?php _e('Your comment is awaiting moderation.', 'alaska') ?></em></p>
	            <?php endif; ?>
            </div>
            <!--Content-->
        </div>
        <!--End Comment Item-->

	<?php
		}

	}

	if ( ! function_exists( 'themestudio_entry_meta' ) ) {

		/**
		 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
		 *
		 * Create your own themestudio_entry_meta() to override in a child theme.
		 *
		 * @since ThemeStudio Framework 1.0
		 */
		function themestudio_entry_meta() {
			// Translators: used between list items, there is a space after the comma.
			$categories_list = get_the_category_list( ', ');

			// Translators: used between list items, there is a space after the comma.
			$tag_list = get_the_tag_list( '',', ' );

			$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);

			$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'alaska' ), get_the_author() ) ),
				get_the_author()
			);

			// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
			if ( $tag_list ) {
				$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'alaska' );
			} elseif ( $categories_list ) {
				$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'alaska' );
			} else {
				$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'alaska' );
			}

			printf(
				$utility_text,
				$categories_list,
				$tag_list,
				$date,
				$author
			);
		}

	}

	// Define constant
	$get_theme = wp_get_theme();

	define('THEMESTUDIO_THEME_NAME', $get_theme);
	define('THEMESTUDIO_THEME_VERSION', '1.0.0.0');
	define('THEMESTUDIO_THEME_SLUG', 'ariva');
	define('THEMESTUDIO_BASE_URL', get_template_directory_uri());
	define('THEMESTUDIO_BASE', get_template_directory());
	define('THEMESTUDIO_LIBRARIES', THEMESTUDIO_BASE . '/core');
	define('THEMESTUDIO_LOOP', THEMESTUDIO_BASE . '/loop/');
	define('THEMESTUDIO_WIDGET', THEMESTUDIO_BASE . '/core/widgets/');
	define('THEMESTUDIO_SHORTCODE', THEMESTUDIO_BASE . '/core/shortcodes');
	define('THEMESTUDIO_FUNCTIONS', THEMESTUDIO_BASE . '/core');
	define('THEMESTUDIO_METAS', THEMESTUDIO_BASE . '/core/functions');
	define('THEMESTUDIO_OPTION', THEMESTUDIO_BASE . '/core/admin');
	define('THEMESTUDIO_API', THEMESTUDIO_FUNCTIONS . '/apis');
	define('THEMESTUDIO_JS', THEMESTUDIO_BASE_URL . '/assets/js');
	define('THEMESTUDIO_CSS', THEMESTUDIO_BASE_URL . '/assets/css');
	define('THEMESTUDIO_IMAGES', THEMESTUDIO_BASE_URL . '/assets/images');
	define('THEMESTUDIO_IMG', THEMESTUDIO_BASE_URL . '/assets/img');
	define('THEMESTUDIO_VENDORS', THEMESTUDIO_BASE_URL . '/assets/vendors');
	define('THEMESTUDIO_TEMPLATE', THEMESTUDIO_BASE_URL . '/templates');
	define('THEMESTUDIO_THEME_LIBS_URL', THEMESTUDIO_BASE_URL . '/core');
	define('THEMESTUDIO_THEME_FUNCTION_URL', THEMESTUDIO_THEME_LIBS_URL . '/functions');
	define('THEMESTUDIO_THEME_OPTION_URL', THEMESTUDIO_BASE_URL . '/core/admin');