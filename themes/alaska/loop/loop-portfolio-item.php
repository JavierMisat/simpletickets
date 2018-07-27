<?php
    global $ts_alaska, $post;
    $portfolio_hover_color = get_post_meta( $post->ID, "themestudio_portfolio_hover_color", true );
    $p_rgba = hex2rgb($portfolio_hover_color);
    $portfolio_hover_style = 'style="background-color:rgba('.$p_rgba[0].', '.$p_rgba[1].', '.$p_rgba[2].', '.$ts_alaska['portfolio_hover_opacity'].')"';
    $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
 ?>


<li class="cbp-item <?php echo themestudio_isotope_terms() ?>" style="width:<?php echo esc_attr($ts_alaska['portfolio-item-width'] )?>px; height: <?php echo esc_attr($ts_alaska['portfolio-item-height']) ?>px">
    <div class="cbp-caption">
        <div class="cbp-caption-defaultWrap">
            <?php the_post_thumbnail('portfolio-grid-4-full');?>
        </div>
        <div class="cbp-caption-activeWrap" <?php //echo $portfolio_hover_style  ?>>
            <div class="cbp-l-caption-alignCenter">
                <div class="cbp-l-caption-body">
                    <a class="cbp-defaultPage cbp-l-caption-buttonLeft" href="<?php the_permalink() ?>">more info</a>
                    <a data-title="<?php the_title( ); ?>" class="cbp-lightbox cbp-l-caption-buttonRight" href="<?php echo esc_url($url) ?>">view larger</a>
                </div>
            </div>
        </div>
    </div>
    <div class="cbp-l-grid-projects-title"><?php the_title( ); ?></div>
    <div class="cbp-l-grid-projects-desc"><?php echo get_the_term_list(get_the_id(),'portfolio_cats', '',', ' ) ?></div>
</li>