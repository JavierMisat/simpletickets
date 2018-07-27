<?php $link_video = get_post_meta( $post->ID, "themestudio_post_video_embed", true ); ?>
<?php if ( $link_video ) : ?>
	<div class="post-meta-type post-video embed-responsive embed-responsive-16by9">
		<?php echo apply_filters('the_content', $link_video); ?>
    </div>
<?php endif;