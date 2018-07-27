<?php
	/**
	* Template Name: Home Page Template
	*
	* @author ThemeStudio
	* @package Alaska
	* @since 1.0.0
	*/
get_header();
global $ts_alaska, $post;
?>
 <!-- content -->
    <div id="container_full">
	        <?php
	        	while ( have_posts() ) : the_post();
					the_content();
					wp_link_pages();
				endwhile;	
            ?>
    </div>
    <!-- End / content -->
<?php get_footer(); ?>