<?php $link_audio = get_post_meta( $post->ID, "themestudio_portfolio_soundcloud", true ); ?>
<?php if ( $link_audio ) : ?>
	<div class="owl-portfolio-singer">
		<div class="portfolio-post-audio">
			<?php echo apply_filters('the_content', $link_audio); ?>
		</div>
	</div>	
	<script>
		jQuery(document).ready(function ($) {
			$(".portfolio-post-audio p iframe").css({"width":"100%","height":"100"});
		});
	</script>
<?php endif;