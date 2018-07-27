<?php
	global $post;
  	if (wp_get_attachment_url( get_post_thumbnail_id($post->ID) )) {
    	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
  	}
?>
<?php if ($url !=''): ?>
	<div class="owl-portfolio-singer">
		<div class="image">
			<?php the_post_thumbnail('full' ); ?>
		</div>
	</div>	
<?php endif;