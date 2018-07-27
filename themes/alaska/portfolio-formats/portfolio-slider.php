<?php
global $post;
$attachments = get_post_meta( get_the_ID(), 'themestudio_portfolio_slider', true );

if ( $attachments ) :
    ?>
    <!--Portfolio Single Slide-->
    <div class="owl-portfolio-slider">
        <div id="owl-portfolio-slider" class="ts-portfolio-slider">

            <!--Portfolio Slide Item-->
            <?php foreach ( $attachments as $attachment ) { ?>
                <div class="slider-item">
                    <img src="<?php echo esc_url( $attachment ); ?>" alt="<?php get_the_title() ?>">
                </div>
            <?php } ?>
            <!--End Portfolio Slide Item-->

        </div>
    </div>
    <!--Portfolio Single Slide-->
<?php endif; ?>