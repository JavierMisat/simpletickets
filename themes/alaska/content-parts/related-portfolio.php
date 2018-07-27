<?php 
    $custom_taxterms = wp_get_object_terms( $post->ID, 'portfolio_cats', array('fields' => 'ids') );
            if($custom_taxterms){
        // arguments
            $args = array(
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'posts_per_page' => 3, // you may edit this number
            'orderby' => 'rand',
            'tax_query' => array(array('taxonomy' => 'portfolio_cats','field' => 'id','terms' => $custom_taxterms)),
            'post__not_in' => array ($post->ID),
            );

            $related_posts = get_posts($args);
?>

 <!-- Portfolio Review-->
<section id="portfolio" class="portfolio-review portfolio-related">
    <div class="container">
        <h5><?php echo esc_html__('Related Projects', 'alaska') ?></h5>
        <div id="grid-portfolio" class="cbp-l-grid-projects">
            <ul>
                <?php 
                    foreach ($related_posts as $post) {
                        setup_postdata( $post );

                            get_template_part('loop/loop-portfolio', 'item');

                        wp_reset_postdata();
                    }
                    }else{
                       echo '<h5>No related portfolio found</h5>';
                    }
                 ?>
            </ul>
        </div>
    </div>
</section>
<!-- End Portfolio Review-->