<?php

if (!class_exists('WooCommerce')) {
    return;
}

/**
 * Urna Template Hooks
 *
 * Action/filter hooks used for Urna functions/templates.
 *
 */

defined('ABSPATH') || exit;
/**
 * Product Add to cart.
 *
 * @see woocommerce_template_single_add_to_cart()
 * @see woocommerce_simple_add_to_cart()
 * @see woocommerce_grouped_add_to_cart()
 * @see woocommerce_variable_add_to_cart()
 * @see woocommerce_external_add_to_cart()
 * @see woocommerce_single_variation()
 * @see woocommerce_single_variation_add_to_cart_button()
 */
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
add_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
add_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
add_action('woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30);
add_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
add_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
add_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);


/**
 * Product Quick View
 *
 * @see woocommerce_show_product_sale_flash()
 */
add_action('urna_before_image_quickview', 'woocommerce_show_product_sale_flash', 10);
