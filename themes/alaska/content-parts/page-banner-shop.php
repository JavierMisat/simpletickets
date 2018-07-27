<?php
$current_post_id = woocommerce_get_page_id( 'shop' );;
$custom_page_title = get_post_meta( $current_post_id, 'themestudio_custom_page_title', true );
$custom_page_description = get_post_meta( $current_post_id, 'themestudio_custom_page_description', true );

$show_banner = get_post_meta( $current_post_id, 'themestudio_show_banner', true );
if ( $show_banner == '' ) {
    $show_banner = 'on';
}
$bg_url = $style = '';
if ( wp_get_attachment_url( get_post_thumbnail_id( $current_post_id ) ) ) {
    $bg_url = wp_get_attachment_url( get_post_thumbnail_id( $current_post_id ) );
}
if ( $bg_url != '' ):
    $style = 'style="background-image:url(' . esc_url( $bg_url ) . ') "';
endif;
?>

<?php if ( $show_banner != 'off' ): ?>
    <!-- Banner -->
    <section id="banner">
        <div class="banner parallax-section" <?php echo esc_attr( $style ); ?>>
            <div class="overlay"></div>
            <div class="banner-content text-center">
                <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                    <?php if ( $custom_page_title != '' ): ?>
                        <h1><?php echo esc_attr( $custom_page_title ); ?></h1>
                    <?php else: ?>
                        <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
                    <?php endif; ?>

                <?php endif; ?>
                <p><span><?php echo esc_attr( $custom_page_description ) ?></span></p>
                <div class="breadcrumbs"><?php ts_breadcrumbs(); ?><?php woocommerce_page_title(); ?></div>
            </div>
        </div>
    </section>
    <!-- End Banner -->
<?php endif ?>
