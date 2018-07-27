<?php
	global $post;
	$url = '';
	$url = get_post_meta( $post->ID, 'themestudio_portfolio_image', true );
	if ($url=='') {
		if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) )) {
		    $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		}
	}

?>
<?php if ($url !=''): ?>
	<div class="owl-portfolio-singer">
    	<div class="image"><img src="<?php echo esc_url( $url) ?>" alt="<?php the_title(); ?>"></div>
    </div>	
<?php endif;