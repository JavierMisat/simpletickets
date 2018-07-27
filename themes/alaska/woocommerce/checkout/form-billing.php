<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */
?>
<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'alaska' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing Details', 'alaska' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <?php
    $fields = $checkout->get_checkout_fields( 'billing' );

    foreach ( $fields as $key => $field ) {
        if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
            $field['country'] = $checkout->get_value( $field['country_field'] );
        }
        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
    }
    ?>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>

        <?php if ( ! $checkout->is_registration_required() ) : ?>

            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> <span><?php echo esc_html__( 'Create an account?', 'alaska' ); ?></span>
                </label>
            </p>

        <?php endif; ?>


        <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

        <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

            <div class="create-account">
                <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>

        <?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
</div>
