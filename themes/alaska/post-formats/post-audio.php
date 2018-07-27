<?php $link_audio = get_post_meta( $post->ID, "themestudio_post_audio_embed", true ); ?>
<?php if ( $link_audio ) : ?>
	<div class="post-audio post-meta-type">
        <?php echo apply_filters('the_content', $link_audio); ?>
    </div>
<?php endif;