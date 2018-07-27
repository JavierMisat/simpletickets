<?php
/**
 * search.php
 * The main post loop in ALASKA
 *
 * @author  Vulinhpc
 * @package ALASKA
 * @since   1.0.0
 */
get_header();
global $ts_alaska;
?>
    <section id="banner" class="banner">
        <div class="banner parallax-section">
            <div class="overlay"></div>
            <div class="banner-content text-center">
                <h1><?php echo sprintf( esc_html__( 'Your Search For:', 'alaska' ) . ' %s', get_search_query() ); ?></h1>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <div id="main-content" <?php post_class(); ?>>
        <div class="container">
            <div class="row">
                <?php
                if ( $ts_alaska[ 'ts-blog-sidebar-position' ] == 3 ) {
                    $col_md = 12;
                    $col_sm = 12;
                }
                else {
                    $col_md = 9;
                    $col_sm = 12;
                    $col_lg = 9;
                }
                ?>
                <!-- Start left sidebar -->
                <?php if ( $ts_alaska[ 'ts-blog-sidebar-position' ] == 1 ): ?>
                    <aside id="sidebar-right" class="sidebar-right  col-sm-12 col-md-3 col-xs-12">
                        <?php get_sidebar() ?>
                    </aside>
                <?php endif ?>
                <!-- End left sidebar -->

                <!-- Start Loop Posts -->
                <div
                    class="col-md-<?php echo esc_attr( $col_md ); ?> col-lg-<?php echo esc_attr( $col_lg ); ?> col-sm-<?php echo esc_attr( $col_sm ); ?>">
                    <div id="blog-list">
                        <?php get_template_part( 'loop/loop-blog', 'list' ); ?>
                    </div>
                    <?php echo function_exists( 'ts_pagination' ) ? ts_pagination() : posts_nav_link(); ?>
                </div>
                <!-- End Loop Posts -->

                <!-- Start right sidebar -->
                <?php if ( $ts_alaska[ 'ts-blog-sidebar-position' ] == 2 ): ?>
                    <aside id="sidebar-right" class="sidebar-right  col-sm-12 col-md-3 col-xs-12">
                        <?php get_sidebar() ?>
                    </aside>
                <?php endif ?>
                <!-- End right sidebar -->
            </div>
        </div>
    </div>
    <!-- End / Main content -->

<?php get_footer();