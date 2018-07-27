<?php
	/**
	* 404.php
	* The main post loop in ALASKA
	* @author Vulinhpc
	* @package ALASKA
	* @since 1.0.0
	*/
	get_header();
?>

	<div id="main-content">
		<div id="page-not-found">
		    <div class="container">
		    	<div class="page-404 text-center">
		    	 	<div class="content-page-404">
	                    <!--Messege-->
	                    <h6 class="text-uppercase bold"><?php echo esc_html__('Sorry, Page not found !', 'alaska') ?></h6>
	                    <hr class="hr">
	                    <p><?php echo esc_html__('Apologies, but the page you requested could not be found. Perhaps searching will help.', 'alaska') ?></p>
	                    <!--End Messege-->
	                    <!--Search Form-->
	                    <div class="blog-search page-search">
	                        <?php  get_search_form(); ?>
	                    </div>
	                    <!--Search Form-->
                        <span><?php echo esc_html__('Back to','alaska');?> <a href="<?php echo home_url('/'); ?>"><?php echo esc_html__('home','alaska');?></a></span>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<!--Wrapper-->

<?php get_footer();