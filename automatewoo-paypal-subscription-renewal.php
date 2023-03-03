<?php
/**
 * Plugin Name: AutomateWoo PayPal Subscription Renewal
 * Description: Create a pending renewal order for PayPal subscriptions when the renewal date is reached.
 * Version: 1.0.0
 * Author: Rahees Ahmed
 * Author URI: https://github.com/raheesahmed
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook the function to create a renewal order when a PayPal subscription payment is due.
add_action( 'woocommerce_scheduled_subscription_payment', 'automatewoo_create_paypal_renewal_order', 10, 3 );

function automatewoo_create_paypal_renewal_order( $amount_to_charge, $order, $product_id ) {

    // Check if the subscription is using PayPal as the payment method.
    if ( $order->get_payment_method() == 'paypal' ) {

        // Create a new order for the subscription renewal.
        $renewal_order = wc_create_order( array(
            'customer_id' => $order->get_customer_id(),
            'status'      => 'pending',
        ) );

        // Add the subscription products to the renewal order.
        foreach ( $order->get_items() as $item ) {
            $product = $item->get_product();
            $renewal_order->add_product( $product, $item->get_quantity() );
        }

        // Set the total amount for the renewal order.
        $renewal_order->set_total( $amount_to_charge );

        // Complete the renewal order immediately.
        $renewal_order->update_status( 'completed', __( 'Automatic Renewal Order Completed', 'textdomain' ) );
    }
}
