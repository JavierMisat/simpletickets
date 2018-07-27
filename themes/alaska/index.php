<?php
    /**
    * index.php
    * The main post loop in ALASKA
    * @author Vulinhpc
    * @package ALASKA
    * @since 1.0.0
    */

    get_header();
    global $ts_alaska;
    $blog_layout = isset($ts_alaska['ts-blog-sidebar-position']) ? $ts_alaska['ts-blog-sidebar-position'] : '2';
?>
<?php get_template_part('content-parts/page', 'banner'); ?>

    <!-- Main content -->
    <div id="main-content">
        <div class="container">
                <div class="row">
                    <?php
                        if ($blog_layout==3) {
                            $col_md = 12;
                            $col_sm = 12;
                            $col_lg = 12;
                        } else {
                            $col_md = 9;
                            $col_sm = 12;
                            $col_lg = 9;
                        }
                    ?>
                    <!-- Start left sidebar -->
                    <?php if ($blog_layout==1): ?>
                         <aside id="sidebar-right" class="sidebar-right  col-sm-12 col-md-3 col-xs-12">
                            <?php get_sidebar()?>
                        </aside>
                    <?php endif ?>
                    <!-- End left sidebar -->

                    <!-- Start Loop Posts -->
                        <div class="col-md-<?php echo esc_attr($col_md); ?> col-lg-<?php echo esc_attr($col_lg); ?> col-sm-<?php echo esc_attr($col_sm); ?>">
                            <?php get_template_part('loop/loop-blog','list'); ?>
                            <?php echo function_exists('ts_pagination') ? ts_pagination() : posts_nav_link(); ?>
                        </div>
                    <!-- End Loop Posts -->

                    <!-- Start right sidebar -->
                    <?php if ($blog_layout==2): ?>
                        <aside id="sidebar-right" class="sidebar-right  col-sm-12 col-md-3 col-xs-12">
                            <?php get_sidebar()?>
                        </aside>
                    <?php endif ?>
                    <!-- End right sidebar -->

                </div>
        </div>
    </div>
    <!-- End / Main content -->

<?php get_footer();