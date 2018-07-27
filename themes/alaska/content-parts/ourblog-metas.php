<?php 
global $ts_alaska;

?>
<ul class="meta-post">
	<?php if( in_array('date',$ts_alaska['ts-blog-metas']) ) : ?>
		<li><?php the_time( 'F' ); ?> <?php the_time( 'd' ); ?>, <?php the_time( 'Y' ); ?></li>
	<?php endif; ?>

	<?php if( in_array('category',$ts_alaska['ts-blog-metas'])  && has_category() ) :  ?>
		<li><?php the_category(', '); ?></li>
	<?php endif; ?>	
	<li><?php echo esc_html__('By', 'alaska'); ?> <a href="<?php echo get_author_posts_url($post->post_author)   ?>"><?php echo get_the_author_meta('display_name' ); ?></a> </li>
</ul>