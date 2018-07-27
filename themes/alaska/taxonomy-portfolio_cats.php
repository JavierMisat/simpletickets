<?php
/**
 * taxonomy-portfolio_cats.php
 * The project archive used in ALASKA
 *
 * @author  Vu Ngoc Linh
 * @package ALASKA
 * @since   1.0.0
 */
get_header();
global $ts_alaska, $style;
?>
    <section id="banner">
        <div class="banner portfolio-banner">
            <div class="banner-content text-center">
                <h1><?php echo get_queried_object()->name; ?></h1>
                <span><?php echo esc_attr( $ts_alaska[ 'portfolio_sub_title' ] ); ?></span><br>
                <div class="breadcrumbs"><?php ts_breadcrumbs(); ?><?php echo get_queried_object()->name; ?></div>
            </div>
        </div>
    </section>
<?php
if ( $ts_alaska[ 'show_hide_filter' ] == 'show_filter_portfolio' ) {
    get_template_part( 'content-parts/portfolio', 'filter' );
}
?>
    <div class="container">

        <!-- End Banner -->
        <div id="grid-portfolio" class="cbp-l-grid-projects">
            <ul>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();

                    get_template_part( 'loop/loop-portfolio', 'item' );

                endwhile;
                else :
                    get_template_part( 'loop/content', 'none' );

                endif;
                ?>

            </ul>
        </div>
    </div>
<?php
if ( $ts_alaska[ 'portfolio_switch_pagination' ] == 'show_portfolio_pagination' ) {
    echo function_exists( 'ts_pagination' ) ? ts_pagination() : posts_nav_link();
}
?>
<?php get_footer();