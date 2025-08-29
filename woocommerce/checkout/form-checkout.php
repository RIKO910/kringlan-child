<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<div class="" style="display: flex; width: 100%">
    <div style="width: 35%; padding:20px;">
        <ul style="list-style:none; padding:0; margin:0;">
            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                $_product   = $cart_item['data'];
                $product_id = $cart_item['product_id'];

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
                    $thumbnail = $_product->get_image( 'woocommerce_thumbnail' );
                    $product_name = $_product->get_name();
                    ?>
                    <li style="align-items:center;">
                        <div style="margin-right:15px;">
                            <span style="font-weight:bold;"><?php echo esc_html( $product_name ); ?></span><br>
                        </div>
                        <div style="margin-right:15px; margin-top: 10px;">
                            <?php echo $thumbnail; ?>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <form style="width: 65%" name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

        <?php if ( $checkout->get_checkout_fields() ) : ?>

            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

            <div class="col2-set" id="customer_details" style="width: 100%">
                <div class="col-1">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                </div>

                <div class="col-2">
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>


                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="woocommerce-checkout-review-order" style="width: 100%; margin-top: 10px">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </div>

            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

        <?php endif; ?>

    </form>

</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
