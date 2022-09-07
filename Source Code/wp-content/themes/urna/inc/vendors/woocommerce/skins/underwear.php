<?php

if (!class_exists('WooCommerce')) {
    return;
}

if (! function_exists('urna_woocommerce_setup_size_image')) {
    add_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
    function urna_woocommerce_setup_size_image()
    {
        $thumbnail_width = 420;
        $main_image_width = 600;
        $cropping_custom_width = 27;
        $cropping_custom_height = 32;

        // Image sizes
        update_option('woocommerce_thumbnail_image_width', $thumbnail_width);
        update_option('woocommerce_single_image_width', $main_image_width);

        update_option('woocommerce_thumbnail_cropping', 'custom');
        update_option('woocommerce_thumbnail_cropping_custom_width', $cropping_custom_width);
        update_option('woocommerce_thumbnail_cropping_custom_height', $cropping_custom_height);
    }
}

if (urna_tbay_get_global_config('config_media', false)) {
    remove_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
}

if (! function_exists('urna_skin_tbay_icon_add_cart')) {
    function urna_skin_tbay_icon_add_cart()
    {
        $output = '<i class="linear-icon-bag2"></i>';

        return $output;
    }
    add_filter('urna_get_icon_add_to_cart', 'urna_skin_tbay_icon_add_cart', 2);
}

if (! function_exists('urna_change_swatch_variable')) {
    function urna_change_swatch_variable()
    {
        $layout = apply_filters('urna_woo_config_product_layout', 10, 2);
        if ($layout !== 'v10') {
            return;
        }
        remove_action('urna_woo_before_shop_loop_item_caption', 'urna_tbay_woocommerce_variable', 5);
        add_action('urna_tbay_after_shop_loop_item_title', 'urna_tbay_woocommerce_variable', 15);
    }
    add_action('woocommerce_before_shop_loop_item_title', 'urna_change_swatch_variable', 15);
}
