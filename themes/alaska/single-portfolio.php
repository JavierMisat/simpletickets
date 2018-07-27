<?php
	/**
	* single-projects.php
	* The main post loop in VAN
	* @author Vulinhpc
	* @package VAN
	* @since 1.0.0
	*/
	get_header();
	the_post();
	$portfolio_type = get_post_meta( $post->ID, 'themestudio_portfolio_type', true );
	$portfolio_client = get_post_meta( $post->ID, 'themestudio_title_meta', true );
	$themestudio_portfolio_url = get_post_meta( $post->ID, 'themestudio_portfolio_url', true );
?>
 <!--portfolio Single-->
        <section id="portfolio-single" class="portfolio-single">
            <div class="container">
                <div class="portfolio-header">
                    <h1 class="portfolio-title"><?php the_title( ); ?></h1>
                    <ul class="pull-right">
                        <li><a href="<?php echo esc_url( $ts_alaska['main_portfolio_page'] ) ?>" class="icon-bt bt-grid">Grid</a></li>
                        <?php
                            $prev_post = get_previous_post();
                            if (!empty( $prev_post )): ?>
                              <li><a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="icon-bt icon-arrow-prev">Prev</a></li>
                            <?php else: ?>
                            <li><a href="#" class="icon-bt icon-arrow-prev">Prev</a></li>  
                        <?php endif; ?>
                        <?php
                            $next_post = get_next_post();
                            if (!empty( $next_post )): ?>
                              <li><a href="<?php echo get_permalink( $next_post->ID ); ?>" class="icon-bt icon-arrow-next" >Next</a></li>
                        <?php else: ?>
                            <li><a href="#" class="icon-bt icon-arrow-next">Next</a></li>
                        <?php endif; ?>
                </ul>
                </div>
	            <div class="row">
                    <!--Portfolio Single Left-->
                    <div class="col-sm-9 col-md-9 portfolio-single-left">
               			<?php get_template_part('portfolio-formats/portfolio', $portfolio_type); ?>
                        <?php the_content( ); ?>
                    </div>
                    <!--ENd Portfolio Single Left-->

                    <!--Portfolio Single Right-->
                    <div class="col-sm-4 col-md-3 portfolio-single-right">
                    <h3><?php echo esc_html__('Project Description', 'alaska') ?></h3>
                    <!--Social Share-->
                    <div class="group-share">
					    <span><?php echo esc_html__('Share this', 'alaska'); ?></span>
						<a target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="fa fa-twitter"></i></a>
					  	<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
					  	<a target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a>
					  	<a target="_blank" href="https://pinterest.com/pin/create/button/?url=&media=&description=<?php the_permalink(); ?>"><i class="fa fa-pinterest"></i></a>
					</div>
                    <!--Social Share-->
                    <article class="portfolio-excerpt clearfix">
                    	<?php the_excerpt() ?>
                    </article>
                    <h3><?php echo esc_html__('Project Details', 'alaska') ?></h3>
                        <!--Single Right Item-->
                        <div class="profile-right">
                            <?php if($portfolio_client !='') { ?>    
                                <h5><strong><?php echo esc_html__('Client','alaska') ?></strong><span> <?php echo esc_attr( $portfolio_client ) ?></span></h5>
                            <?php } ?>
                            <h5><strong><?php echo esc_html__('Date','alaska') ?></strong><span> <?php the_time( 'F' ); ?> <?php the_time( 'd' ); ?>, <?php the_time( 'Y' ); ?></span></h5>
                            <h5><strong><?php echo esc_html__('Categories','alaska') ?></strong><span> <?php echo strip_tags(get_the_term_list(get_the_id(),'portfolio_cats', '',', ' ), '') ?></span></h5>
                        </div>
                        <?php if($themestudio_portfolio_url !='') { ?>
                        <a href="<?php echo esc_url( $themestudio_portfolio_url ) ?>" class="ts-style-button normal" title="VISIT SITE"><?php echo esc_html__('VISIT THE SITE','alaska') ?></a>
                        <?php } ?>
                    </div>

                    <!--End Portfolio Single Right-->
                </div>
            </div>
        </section>
        <!--End Portfolio Single-->
        
        <?php get_template_part('content-parts/related', 'portfolio'); ?>
        
<?php get_footer();