<?php
	/**
	 * Template Name: Left Sidebar Template
	 * page_fullwidth.php
	 * Used mainly for the page builder
	 * @author Vu Ngoc Linh
	 * @package ALASKA
	 * @since 1.0.0
	**/
	get_header();
?>
<?php get_template_part('content-parts/page', 'banner'); ?>
    <!-- Blog -->
    <section id="blog" class="blog ts-page-sidebar">
        <div class="container">
            <div class="row">
                <!--Blog Right-->
                <aside id="blog-right" class="blog-right col-sm-3 col-lg-3">

					<?php get_sidebar()?>

                </aside>
                <!--Blog Right-->
                <!--Blog Left-->
                <article id="blog-left" class="blog-left col-sm-9 col-lg-9">
                    <?php 
                        while ( have_posts() ) : the_post();
                            the_content();
                        endwhile;   
                     ?>
                </article>
                <!--End Blog Left-->
            </div>
        </div>
    </section>
    <!-- End Blog -->

<?php get_footer();