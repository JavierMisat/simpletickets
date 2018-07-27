<?php
	global $post;
	$url = '';
	$url = get_post_meta( $post->ID, 'themestudio_post_image', true );
	if ($url == '') {
	    $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	}
?>
<?php if ($url !=''): ?>
    <div class="post-image post-meta-type">
    	<figure>
	        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
	            <img src="<?php echo esc_url($url) ?>" alt="<?php the_title(); ?>">
	        </a>
	    </figure>
    </div>
<?php endif;