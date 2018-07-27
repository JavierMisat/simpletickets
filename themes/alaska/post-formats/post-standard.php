<?php
	global $ts_alaska;
	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>
<?php if ($url !=''): ?>
	<div class="post-standard post-meta-type">
		<figure>
	        <img src="<?php echo esc_url($url) ?>" alt="<?php the_title(); ?>">
	    </figure>
    </div>
<?php endif;