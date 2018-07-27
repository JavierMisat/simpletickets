<?php $link_video = get_post_meta( $post->ID, "themestudio_portfolio_video", true ); ?>
<?php if ( $link_video ) : ?>
	<div class="owl-portfolio-singer">
		<div class="portfolio-post-video">
			<?php echo apply_filters('the_content', $link_video); ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".portfolio-post-video").fitVids();
		});
	</script>
<?php endif;