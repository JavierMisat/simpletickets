<?php $link_soundcloud = get_post_meta( $post->ID, "themestudio_portfolio_soundcloud", true ); ?>
<?php if ( $link_soundcloud ) : ?>
	<div class="portfolio-post-video owl-portfolio-singer">
		<div class="audio">
		<?php echo apply_filters('the_content', $link_soundcloud); ?>
		</div>
	</div>
	<div class="clearfix"></div>
<?php endif;