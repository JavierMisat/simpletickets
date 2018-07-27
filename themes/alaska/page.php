<?php
    /**
    * page.php
    * The main post loop in ALASKA
    * @author Vulinhpc
    * @package ALASKA
    * @since 1.0.0
    */
    get_header();
    global $ts_alaska;
?>
<?php get_template_part('content-parts/page', 'banner'); ?>
    <!-- Start main content -->
    <div id="container_full">
        <div class="container">
            <?php
            while ( have_posts() ) : the_post();
                the_content();
	            wp_link_pages( array(
		            'before' => '<div class="page-links-data">' . __( 'Pages:', 'alaska' ),
		            'link_before'      => '<div class="item-link">',
		            'link_after'       => '</div>',
		            'after'  => '</div>',
	            ) );
            endwhile;    
            ?>

        </div>
    </div>
    <!-- End / main content -->

<?php get_footer();