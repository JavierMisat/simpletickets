<?php
global $ts_alaska;
$header_social = isset( $ts_alaska[ 'ts-header-social-list' ] ) ? $ts_alaska[ 'ts-header-social-list' ] : array();
?>
<?php if ( $header_social ) : ?>
    <div class="social-top">
        <ul class="social">
            <?php foreach ( $header_social as $value ): ?>
                <li class="bounceIn animated"><a target="_blank" href="<?php echo esc_url( $value[ 'url' ] ); ?>"><i
                            class="fa fa-<?php echo esc_attr( $value[ 'title' ] ); ?>"></i></a></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>