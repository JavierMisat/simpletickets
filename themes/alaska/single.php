<?php
    /**
    * single.php
    * The main post loop in ALASKA
    * @author Vulinhpc
    * @package ALASKA
    * @since 1.0.0
    */
    get_header();
    the_post();

    global $ts_alaska;
    $format = get_post_format();
    if( false === $format ){
    	$format = 'standard';
    }
    $single_layout = isset($ts_alaska['ts-blog-sidebar-position']) ? $ts_alaska['ts-blog-sidebar-position'] : '2';
?>
    <!-- Main content -->
    <div <?php post_class("main-content"); ?>>
        <div class="container">
            <div class="row">
                <?php
                    if ($single_layout==3) {
                        $col_md = 12;
                        $col_sm = 12;
                        $col_lg = 12;
                    } else {
                        $col_md = 9;
                        $col_sm = 12;
                        $col_lg = 9;
                    }
                ?>
                <?php if ($single_layout==1): ?>
                   <aside id="sidebar-right" class="sidebar-right col-md-3 col-sm-12 col-xs-12">
                        <?php get_sidebar(); ?>
                    </aside>
                <?php endif ?>

                <div class="page-ct col-md-<?php echo esc_attr($col_md); ?> col-lg-<?php echo esc_attr($col_lg); ?> col-sm-<?php echo esc_attr($col_sm); ?>">
                    <div class="blog-single">
                         <div class="blog-item">
                            <?php get_template_part( 'post-formats/post', $format ); ?>
                            <div class="date-post">
                                <span class="date"><?php the_time( 'd' ); ?></span>
                                <span class="month"><?php the_time( 'M' ); ?></span>
                            </div>
                            <article>
                                <h3><a href="#" title=""><?php the_title( ); ?></a></h3>
                                <?php get_template_part('content-parts/blog', 'metas'); ?>
                                <div class="blog-content">
                                    <?php the_content( ); ?>
                                    <?php
                                    wp_link_pages( array(
                                        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'alaska' ) . '</span>',
                                        'after'       => '</div>',
                                        'link_before' => '<span>',
                                        'link_after'  => '</span>',
                                    ) );
                                ?>
                                </div>
                                <!--End Blog Content-->
                                <!--Blog Share-->
                                <?php get_template_part('content-parts/blog', 'social'); ?>
                                <!--Blog Share-->
                            </article>
                        <?php
                            if( comments_open() ){
                                comments_template();
                            }
                        ?>
                        </div>
                    </div>
                </div>

                 <!-- Start right sidebar -->
                <?php if ($single_layout==2): ?>
                    <aside id="sidebar-right" class="sidebar-right col-md-3 col-sm-12 col-xs-12">
                        <?php get_sidebar(); ?>
                    </aside>
                <?php endif ?>
                <!-- End right sidebar -->

            </div>
        </div>
    </div>
    <!-- End / Main content -->

<?php get_footer();