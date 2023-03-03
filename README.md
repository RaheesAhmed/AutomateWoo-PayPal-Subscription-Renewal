# AutomateWoo-PayPal-Subscription-Renewal
Create a pending renewal order for PayPal subscriptions when the renewal date is reached.

We use the add_action function to add the create_paypal_renewal_order function as a callback for the woocommerce_scheduled_subscription_payment hook, which is triggered when a payment is due for a subscription.

Inside the create_paypal_renewal_order function, we first check if the payment method for the subscription is PayPal using the get_payment_method function.

If the payment method is PayPal, we create a new order object using the wc_create_order function, which creates a new order in the WooCommerce database. We set the customer ID to be the same as the customer who placed the original subscription order and set the order status to "pending".

Next, we loop through the items in the original subscription order using the get_items function, and add each item to the new renewal order using the add_product function.

We set the total amount for the new order using the set_total function, which is the amount that needs to be charged for the subscription renewal.

Finally, we update the status of the new order to "completed" using the update_status function, with a custom message. This completes the renewal order immediately and the subscription renewal is processed automatically.
