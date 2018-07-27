<?php

class TS_ALASKA_Follow_us extends WP_Widget
{

    function TS_ALASKA_Follow_us()
    {

        $widget_ops = array( 'classname' => 'TS_ALASKA_Follow_us', 'description' => 'The Follow us social' );

        parent::__construct( 'TS_ALASKA_Follow_us', THEMESTUDIO_THEME_NAME . ' Follow_us ', $widget_ops );

    }


    function widget( $args, $instance )
    {

        extract( $args, EXTR_SKIP );
        echo $before_widget;
        $title = empty( $instance[ 'title' ] ) ? 'Follow us' : apply_filters( 'widget_title', $instance[ 'title' ] );
        $url_twitter = empty( $instance[ 'twitter' ] ) ? '' : $instance[ 'twitter' ];
        $url_tumblr = empty( $instance[ 'tumblr' ] ) ? '' : $instance[ 'tumblr' ];
        $url_youtube = empty( $instance[ 'youtube' ] ) ? '' : $instance[ 'youtube' ];
        $url_vine = empty( $instance[ 'vine' ] ) ? '' : $instance[ 'vine' ];
        $url_facebook = empty( $instance[ 'facebook' ] ) ? '' : $instance[ 'facebook' ];
        $url_google = empty( $instance[ 'google' ] ) ? '' : $instance[ 'google' ];
        $url_behance = empty( $instance[ 'behance' ] ) ? '' : $instance[ 'behance' ];
        $url_dribbble = empty( $instance[ 'dribbble' ] ) ? '' : $instance[ 'dribbble' ];

        echo '<div class="ts-social-footer widget">						
						<h3>' . $title . '</h3>';
        if ( trim( $url_twitter ) != '' ) {
            echo '		<a href="' . esc_url( $url_twitter ) . '" target="__blank"><span><i class="fa fa-twitter"></i></span></a>';
        }
        if ( trim( $url_facebook ) != '' ) {
            echo '		<a href="' . esc_url( $url_facebook ) . '" target="__blank"><span><i class="fa fa-facebook"></i></span></a>';
        }
        if ( trim( $url_google ) != '' ) {
            echo '		<a href="' . esc_url( $url_google ) . '" target="__blank"><span><i class="fa fa-google-plus"></i></span></a>';
        }
        if ( trim( $url_youtube ) != '' ) {
            echo '		<a href="' . esc_url( $url_youtube ) . '" target="__blank"><span><i class="fa fa-youtube"></i></span></a>';
        }
        if ( trim( $url_vine ) != '' ) {
            echo '		<a href="' . esc_url( $url_vine ) . '" target="__blank"><span><i class="fa fa-vine"></i></span></a>	';
        }
        if ( trim( $url_behance ) != '' ) {
            echo '		<a href="' . esc_url( $url_behance ) . '" target="__blank"><span><i class="fa fa-behance"></i></span></a>';
        }
        if ( trim( $url_dribbble ) != '' ) {
            echo '		<a href="' . esc_url( $url_dribbble ) . '" target="__blank"><span><i class="fa fa-dribbble"></i></span></a>';
        }
        if ( trim( $url_tumblr ) != '' ) {
            echo '		<a href="' . esc_url( $url_tumblr ) . '" target="__blank"><span><i class="fa fa-tumblr"></i></span></a>';
        }

        echo '	</div>
					<!-- social_footer -->';

        echo $after_widget;

    }


    function update( $new_instance, $old_instance )
    {

        $instance = $old_instance;

        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'twitter' ] = strip_tags( $new_instance[ 'twitter' ] );
        $instance[ 'tumblr' ] = strip_tags( $new_instance[ 'tumblr' ] );
        $instance[ 'youtube' ] = strip_tags( $new_instance[ 'youtube' ] );
        $instance[ 'vine' ] = strip_tags( $new_instance[ 'vine' ] );
        $instance[ 'facebook' ] = strip_tags( $new_instance[ 'facebook' ] );
        $instance[ 'google' ] = strip_tags( $new_instance[ 'google' ] );
        $instance[ 'behance' ] = strip_tags( $new_instance[ 'behance' ] );
        $instance[ 'dribbble' ] = strip_tags( $new_instance[ 'dribbble' ] );

        return $instance;

    }


    function form( $instance )
    {

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'twitter' => '', 'tumblr' => '', 'youtube' => '', 'vine' => '', 'facebook' => '', 'google' => '', 'behance' => '', 'dribbble' => '' ) );

        $title = strip_tags( $instance[ 'title' ] );
        $twitter = strip_tags( $instance[ 'twitter' ] );
        $tumblr = strip_tags( $instance[ 'tumblr' ] );
        $youtube = strip_tags( $instance[ 'youtube' ] );
        $vine = strip_tags( $instance[ 'vine' ] );
        $facebook = strip_tags( $instance[ 'facebook' ] );
        $google = strip_tags( $instance[ 'google' ] );
        $behance = strip_tags( $instance[ 'behance' ] );
        $dribbble = strip_tags( $instance[ 'dribbble' ] );


        ?>

        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title (default "Follow us"): <input
                    class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                    name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                    value="<?php echo esc_attr( $title ); ?>"/></label></p>
        <p><label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Url Twitter : <input class="widefat"
                                                                                             id="<?php echo $this->get_field_id( 'twitter' ); ?>"
                                                                                             name="<?php echo $this->get_field_name( 'twitter' ); ?>"
                                                                                             type="text"
                                                                                             value="<?php echo esc_attr( $twitter ); ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Url Facebook : <input class="widefat"
                                                                                               id="<?php echo $this->get_field_id( 'facebook' ); ?>"
                                                                                               name="<?php echo $this->get_field_name( 'facebook' ); ?>"
                                                                                               type="text"
                                                                                               value="<?php echo esc_attr( $facebook ); ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'google' ); ?>">Url google plus : <input class="widefat"
                                                                                                id="<?php echo $this->get_field_id( 'google' ); ?>"
                                                                                                name="<?php echo $this->get_field_name( 'google' ); ?>"
                                                                                                type="text"
                                                                                                value="<?php echo esc_attr( $google ); ?>" /></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'youtube' ); ?>">Url youtube : <input class="widefat"
                                                                                             id="<?php echo $this->get_field_id( 'youtube' ); ?>"
                                                                                             name="<?php echo $this->get_field_name( 'youtube' ); ?>"
                                                                                             type="text"
                                                                                             value="<?php echo esc_attr( $youtube ); ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'vine' ); ?>">Url Vine: <input class="widefat"
                                                                                      id="<?php echo $this->get_field_id( 'vine' ); ?>"
                                                                                      name="<?php echo $this->get_field_name( 'vine' ); ?>"
                                                                                      type="text"
                                                                                      value="<?php echo esc_attr( $vine ); ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'behance' ); ?>">Url Behance : <input class="widefat"
                                                                                             id="<?php echo $this->get_field_id( 'behance' ); ?>"
                                                                                             name="<?php echo $this->get_field_name( 'behance' ); ?>"
                                                                                             type="text"
                                                                                             value="<?php echo esc_attr( $behance ); ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'dribbble' ); ?>">Url Dribbble : <input class="widefat"
                                                                                               id="<?php echo $this->get_field_id( 'dribbble' ); ?>"
                                                                                               name="<?php echo $this->get_field_name( 'dribbble' ); ?>"
                                                                                               type="text"
                                                                                               value="<?php echo esc_attr( $dribbble ); ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'tumblr' ); ?>">Url tumblr: <input class="widefat"
                                                                                          id="<?php echo $this->get_field_id( 'tumblr' ); ?>"
                                                                                          name="<?php echo $this->get_field_name( 'tumblr' ); ?>"
                                                                                          type="text"
                                                                                          value="<?php echo esc_attr( $tumblr ); ?>"/></label>
        </p>
        <?php

    }

}

function themestudio_Follow_us_widget()
{
    register_widget( 'TS_ALASKA_Follow_us' );
}

add_action( 'widgets_init', 'themestudio_Follow_us_widget' );