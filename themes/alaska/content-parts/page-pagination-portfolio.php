<?php
global $ts_alaska;
?>
<div class="pagenavigato">
	<div class="pagi">
		<?php if ( !is_null(get_previous_posts_link()) ) :
		     	$ppl=explode('"',get_previous_posts_link());
		     	$ppl_url=$ppl[1];?>
		          <a href="<?php echo esc_url( $ppl_url ); ?>" class="prev-page float-left" title="<?php echo esc_html__('Oder posts', 'alaska') ?>"><i class="fa fa-caret-left"></i><?php echo esc_html__('Oder posts', 'alaska') ?></a>
		<?php endif?>

		<?php   if ( !is_null(get_next_posts_link()) ):
		      	$npl=explode('"',get_next_posts_link());
		        $npl_url=$npl[1];?>
		          <a href="<?php echo esc_url( $npl_url ); ?>" class="next-page float-right" title="<?php echo esc_html__('Next posts', 'alaska') ?>"><?php echo esc_html__('Next posts', 'alaska') ?><i class="fa fa-caret-right"></i></a>
		<?php endif ?>

	</div>

</div>