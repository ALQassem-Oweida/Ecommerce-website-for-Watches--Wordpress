<?php

if (!class_exists('WooCommerce')) {
    return;
}
        

if (! function_exists('urna_woocommerce_setup_size_image')) {
    add_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
    function urna_woocommerce_setup_size_image()
    {
        $thumbnail_width = 390;
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

if (! function_exists('urna_change_admin_visualcomposer_columns')) {
    function urna_change_admin_visualcomposer_columns($output)
    {
        $output = array(1,2,3,4,5,6,7,8);
        return $output;
    }
    add_filter('urna_admin_visualcomposer_columns', 'urna_change_admin_visualcomposer_columns');
}

if (! function_exists('urna_change_admin_visualcomposer_brands_columns')) {
    function urna_change_admin_visualcomposer_brands_columns($output)
    {
        $output = array(1,2,3,4,5,6,7,8,9,10);
        return $output;
    }
    add_filter('urna_admin_visualcomposer_brands_columns', 'urna_change_admin_visualcomposer_brands_columns');
}
