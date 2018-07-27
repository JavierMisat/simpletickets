<?php
global $ts_alaska;
if ( have_posts() ) : while ( have_posts() ) : the_post();

    if ( is_search() ) {
        /**
         * Get blog posts by blog layout.
         */
        get_template_part( 'loop/loop-search', 'list-item' );
    }
    else {
        /**
         * Get blog posts by blog layout.
         */
        get_template_part( 'loop/loop-blog', 'list-item' );
    }

endwhile;
else :
    /**
     * Display no posts message if none are found.
     */
    get_template_part( 'loop/content', 'none' );

endif;
?>