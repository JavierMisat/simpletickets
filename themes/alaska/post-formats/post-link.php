<?php
	global $post;
	$themestudio_link_description = get_post_meta( $post->ID, 'themestudio_link_description', true );
	$themestudio_link_url = get_post_meta( $post->ID, 'themestudio_link_url', true );

?>
<?php if ($themestudio_link_url !=''): ?>
<div class="post-meta-type blog-link">
	<h3><?php echo apply_filters('the_title', $themestudio_link_description) ?></h3>
	<a target="_blank" href="<?php echo esc_url($themestudio_link_url)?>"><?php echo esc_url($themestudio_link_url)?></a>
</div>
<?php endif;