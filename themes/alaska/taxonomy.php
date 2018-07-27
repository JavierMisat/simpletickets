<?php
    /**
    * taxonomy.php
    * The main post loop in ALASKA
    * @author Vulinhpc
    * @package ALASKA
    * @since 1.0.0
    */
    get_header();
    global $ts_alaska;
?>
    <!-- Main content -->
    <div id="main-content">
        <div class="container">
            <div class="row">
                <?php
                    if ($ts_alaska['ts-blog-sidebar-position']==3) {
                        $col_md = 12;
                        $col_sm = 12;
                    } else {
                        $col_md = 9;
                        $col_sm = 8;
                    }
                ?>
                <?php if ($ts_alaska['ts-blog-sidebar-position']==1): ?>
                   <?php get_sidebar(); ?>
                <?php endif ?>
                    <div class="col-md-<?php echo esc_attr($col_md); ?> col-sm-<?php echo esc_attr($col_sm); ?>">
                        <ul id="blog-list">
                            <?php get_template_part('loop/loop-blog', 'list'); ?>
                        </ul>
                        <?php echo function_exists('ts_pagination') ? ts_pagination() : posts_nav_link(); ?>
                    </div>
                <?php if ($ts_alaska['ts-blog-sidebar-position']==2): ?>
                   <?php get_sidebar(); ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <!-- End / Main content -->

<?php get_footer();