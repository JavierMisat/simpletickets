<?php
	/**
	* comments.php
	* The main post loop in ALASKA
	* @author Vulinhpc
	* @package ALASKA
	* @since 1.0.0
	*/
	$fields =  array(
		'author' => '<div class="row"><div class="col-sm-4"><input type="text" name="author" id="name" class="input-form" placeholder="Name*" /></div>',
		'email'  => '<div class="col-sm-4"><input type="text" name="email" id="email" class="input-form" placeholder="Email*"/></div>',
		'website'  => '<div class="col-sm-4"><input type="text" name="website" id="website" class="input-form" placeholder="Website"/></div></div>',

	);

	$custom_comment_form = array( 
		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	  	'comment_field' => '
	  	<textarea name="comment" id="message" class="textarea-form" placeholder="Comment" ></textarea>',
	  	'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a> <a href="%3$s">Log out?</a>','alaska' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
	  	'cancel_reply_link' => __( 'Cancel' , 'alaska' ),
	  	'comment_notes_before' => '',
	  	'comment_notes_after' => '',
	  	'title_reply' => '',
	  	'label_submit' => __( 'Submit' , 'alaska' ),
	  	'id_submit'         => 'comment_submit',
	);
?>
<?php if( have_comments() ): ?>
<!-- Comment -->
    <div id="comment-post" class="comment-post">
		<h4><?php echo esc_html__('Comments', 'alaska'); ?> <span><?php comments_number( esc_html__('(0)','alaska'), esc_html__('(1)','alaska'), esc_html__('(%)','alaska') ); ?></span></h4>
        <!-- List Comment -->
        <?php 
		  	wp_list_comments('type=comment&callback=themestudio_comment');
			paginate_comments_links();
		?>
        <!-- List Comment -->
    </div>
<!-- Comment -->
<?php endif; ?>
<!-- Leave reply -->
<div id="leave-reply" class="leave-reply">
	<h4 class="text-uppercase bold"><?php echo esc_html__('Leave a reply', 'alaska') ?></h4>
   	<div class="row">
	   	<div class="col-sm-12">
			<?php comment_form($custom_comment_form); ?>
		</div>
	</div>
</div>
<!-- Leave reply -->