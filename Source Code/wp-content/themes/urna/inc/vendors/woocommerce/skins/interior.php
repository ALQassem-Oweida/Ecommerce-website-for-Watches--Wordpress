<?php

if (!class_exists('WooCommerce')) {
    return;
}


if (! function_exists('urna_woocommerce_setup_size_image')) {
    add_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
    function urna_woocommerce_setup_size_image()
    {
        $thumbnail_width = 465;
        $main_image_width = 600;
        
        $cropping_custom_width = 1;
        $cropping_custom_height = 1;

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

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);



if (! function_exists('urna_tbay_custom_categories_count_item')) {
    function urna_tbay_custom_categories_count_item()
    {
        $output = esc_html__('products', 'urna');

        return $output;
    }

    add_filter('urna_tbay_categories_count_item', 'urna_tbay_custom_categories_count_item', 10, 1);
}
