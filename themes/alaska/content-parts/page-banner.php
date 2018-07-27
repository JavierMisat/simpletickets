<?php
global $ts_alaska;
$bg_url = $style = '';
$custom_page_title = get_post_meta( get_the_ID(), 'themestudio_custom_page_title', true );
$breadcrumb_color = get_post_meta( get_the_ID(), 'themestudio_breadcrumb_color', true );
$title_color = get_post_meta( get_the_ID(), 'themestudio_title_color', true );
$custom_page_description = get_post_meta( get_the_ID(), 'themestudio_custom_page_description', true );
$show_banner = get_post_meta( get_the_ID(), 'themestudio_show_banner', true );

if ( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ) {
    $bg_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
}
if ( $custom_page_title == '' ) {
    $custom_page_title = get_the_title( get_the_ID() );
}

if ( is_front_page() && is_home() ) {
    // Default homepage
    $custom_page_title = isset($ts_alaska[ 'ts-blog-title' ]) ? $ts_alaska[ 'ts-blog-title' ] : esc_html__('Blog','alaska');
    $custom_page_description = isset($ts_alaska[ 'ts-blog-sub-title' ]) ?  $ts_alaska[ 'ts-blog-sub-title' ]  : esc_html__('Our perspective on digital (and other things)','alaska');
    $bg_url = isset($ts_alaska[ 'ts-blog-banner' ][ 'background-image' ]) ? $ts_alaska[ 'ts-blog-banner' ][ 'background-image' ] : ' ';
}
elseif ( is_front_page() ) {
    // static homepage
}
elseif ( is_home() ) {
    // blog page
    $custom_page_title = $ts_alaska[ 'ts-blog-title' ];
    $custom_page_description = $ts_alaska[ 'ts-blog-sub-title' ];
    $bg_url = $ts_alaska[ 'ts-blog-banner' ][ 'background-image' ];
}
else {
    //everything else
    $bg_url = get_the_post_thumbnail_url();
}
if ( $bg_url != '' ):
    $style = 'style=background-image:url(' . $bg_url . ')';
endif;
?>
<?php if ( $show_banner != 'off' ): ?>
    <!-- Banner -->
    <div class=" color-changer" data-color="<?php echo esc_attr( $breadcrumb_color ); ?>"
         data-c-target="#banner .banner p">
        <section id="banner">
            <div class="banner parallax-section" <?php echo esc_attr( $style ); ?>>
                <div class="overlay"></div>
                <div class="banner-content text-center">
                    <div class="container color-changer" data-color="<?php echo esc_attr( $title_color ); ?>"
                         data-c-target=".banner-left h1">
                        <div class="banner-left">
                            <h1><?php echo esc_attr( $custom_page_title ) ?></h1>
                            <p><?php echo esc_attr( $custom_page_description ) ?></p>
                        </div>
                        <?php if ( ts_get_breadcrumbs( '/' ) != '' ): ?>
                            <div class="breadcrumbs"><?php ts_breadcrumbs(); ?></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End Banner -->
<?php endif ?>
