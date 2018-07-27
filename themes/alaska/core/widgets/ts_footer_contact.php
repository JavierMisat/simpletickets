<?php

class TS_ALASKA_Footer_about extends WP_Widget
{

    function TS_ALASKA_Footer_about()
    {

        $widget_ops = array( 'classname' => 'TS_ALASKA_Footer_about', 'description' => 'The top footer contact' );

        parent::__construct( 'TS_ALASKA_Footer_about', THEMESTUDIO_THEME_NAME . ' footer contact ', $widget_ops );

    }


    function widget( $args, $instance )
    {

        extract( $args, EXTR_SKIP );
        echo $before_widget;
        $title = empty( $instance[ 'title' ] ) ? 'About company' : apply_filters( 'widget_title', $instance[ 'title' ] );
        $description = $instance[ 'description' ];
        $address = $instance[ 'address' ];
        if ( trim( $address ) != '' ) {
            $address_html = '<p><span>A : ' . $address . '</span></p>	';
        }
        $email = $instance[ 'email' ];
        if ( trim( $email ) != '' ) {
            $email_html = '<p><span>E : </span><a href="mailto:' . $email . '">' . $email . '</a></p>';
        }

        echo '<div class="ts-company-info widget">
						<h3>' . $title . '</h3>
						<p>' . $description . '</p>
						' . $address_html . '
						' . $email_html . '
					</div>';

        echo $after_widget;

    }


    function update( $new_instance, $old_instance )
    {

        $instance = $old_instance;

        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );

        $instance[ 'description' ] = strip_tags( $new_instance[ 'description' ] );

        $instance[ 'address' ] = strip_tags( $new_instance[ 'address' ] );

        $instance[ 'email' ] = strip_tags( $new_instance[ 'email' ] );

        return $instance;

    }


    function form( $instance )
    {

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'description' => '', 'address' => '', 'email' => '', 'textarea' => '' ) );

        $title = strip_tags( $instance[ 'title' ] );

        $description = strip_tags( $instance[ 'description' ] );

        $address = strip_tags( $instance[ 'address' ] );

        $email = strip_tags( $instance[ 'email' ] );

        $textarea = strip_tags( $instance[ 'textarea' ] );

        ?>

        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title (default "About company"): <input
                    class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                    name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                    value="<?php echo esc_attr( $title ); ?>"/></label></p>

        <p>
            <label
                for="<?php echo $this->get_field_id( 'textarea' ); ?>"><?php _e( 'Description:', 'alaska' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>"
                      name="<?php echo $this->get_field_name( 'description' ); ?>" rows="7"
                      cols="20"><?php echo $description; ?></textarea>
        </p>

        <p><label for="<?php echo $this->get_field_id( 'address' ); ?>">Address : <input class="widefat"
                                                                                         id="<?php echo $this->get_field_id( 'address' ); ?>"
                                                                                         name="<?php echo $this->get_field_name( 'address' ); ?>"
                                                                                         type="text"
                                                                                         value="<?php echo esc_attr( $address ); ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'email' ); ?>">Email : <input class="widefat"
                                                                                     id="<?php echo $this->get_field_id( 'email' ); ?>"
                                                                                     name="<?php echo $this->get_field_name( 'email' ); ?>"
                                                                                     type="text"
                                                                                     value="<?php echo esc_attr( $email ); ?>"/></label>
        </p>
        <?php

    }

}

function themestudio_footer_about_widget()
{
    register_widget( 'TS_ALASKA_Footer_about' );
}

add_action( 'widgets_init', 'themestudio_footer_about_widget' );