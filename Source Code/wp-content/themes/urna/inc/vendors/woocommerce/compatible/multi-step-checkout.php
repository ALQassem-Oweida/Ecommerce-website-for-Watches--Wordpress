<?php

if (!class_exists('WPMultiStepCheckout')) {
    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
    add_action('woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 20);
}