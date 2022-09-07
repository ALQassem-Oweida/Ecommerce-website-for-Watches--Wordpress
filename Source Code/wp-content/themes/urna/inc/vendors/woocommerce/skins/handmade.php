<?php

if (!class_exists('WooCommerce')) {
    return;
}
    

if (! function_exists('urna_woocommerce_setup_size_image')) {
    add_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
    function urna_woocommerce_setup_size_image()
    {
        $thumbnail_width = 366;
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



if (! function_exists('urna_tbay_custom_countdown_flash_sale_day')) {
    function urna_tbay_custom_countdown_flash_sale_day()
    {
        $output = '<span class="label">'. esc_html__('days', 'urna') .'</span>';

        return $output;
    }

    add_filter('urna_tbay_countdown_flash_sale_day', 'urna_tbay_custom_countdown_flash_sale_day', 10, 1);
}

if (! function_exists('urna_tbay_custom_countdown_flash_sale_hour')) {
    function urna_tbay_custom_countdown_flash_sale_hour()
    {
        $output = '<span class="label">'. esc_html__('hours', 'urna') .'</span>';

        return $output;
    }

    add_filter('urna_tbay_countdown_flash_sale_hour', 'urna_tbay_custom_countdown_flash_sale_hour', 10, 1);
}

if (! function_exists('urna_tbay_custom_countdown_flash_sale_mins')) {
    function urna_tbay_custom_countdown_flash_sale_mins()
    {
        $output = '<span class="label">'. esc_html__('mins', 'urna') .'</span>';

        return $output;
    }

    add_filter('urna_tbay_countdown_flash_sale_mins', 'urna_tbay_custom_countdown_flash_sale_mins', 10, 1);
}

if (! function_exists('urna_tbay_custom_countdown_flash_sale_secs')) {
    function urna_tbay_custom_countdown_flash_sale_secs()
    {
        $output = '<span class="label">'. esc_html__('secs', 'urna') .'</span>';

        return $output;
    }

    add_filter('urna_tbay_countdown_flash_sale_secs', 'urna_tbay_custom_countdown_flash_sale_secs', 10, 1);
}
