<?php
	global $post;
	$quote_content = get_post_meta( $post->ID, 'themestudio_quote_content', true );
	$quote_author = get_post_meta( $post->ID, 'themestudio_quote_author', true );
?>
<?php if ($quote_content !=''): ?>
    <div class="post-meta-type blog-quote">
		<p><?php echo strip_tags(apply_filters('the_content', $quote_content)) ?></p>
		<cite><?php echo strip_tags(apply_filters('the_content', $quote_author))  ?></cite>
	</div>
<?php endif;