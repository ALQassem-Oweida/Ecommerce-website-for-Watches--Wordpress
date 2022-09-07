<?php

if (!class_exists('WooCommerce')) {
    return;
}

if (! function_exists('urna_woocommerce_setup_size_image')) {
    add_action('after_setup_theme', 'urna_woocommerce_setup_size_image');
    function urna_woocommerce_setup_size_image()
    {
        $thumbnail_width = 313;
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

if (! function_exists('urna_woo_subtitle_field')) {
    /* Subtitle Product */
    function urna_woo_subtitle_field()
    {
        woocommerce_wp_text_input(
            array(
                'id'          => '_subtitle',
                'label'       => esc_html__('Subtitle', 'urna'),
                'placeholder' => esc_html__('Subtitle....', 'urna'),
                'description' => esc_html__('Enter the subtitle.', 'urna')
            )
        );
    }
    add_action('woocommerce_product_options_general_product_data', 'urna_woo_subtitle_field');
}
if (! function_exists('urna_woo_subtitle_field_save')) {
    function urna_woo_subtitle_field_save($post_id)
    {
        $subtitle = $_POST['_subtitle'];
        if (isset($subtitle)) {
            update_post_meta($post_id, '_subtitle', esc_attr($subtitle));
        }
    }
    add_action('woocommerce_process_product_meta', 'urna_woo_subtitle_field_save');
}

if (! function_exists('urna_woo_get_subtitle')) {
    function urna_woo_get_subtitle()
    {
        global $product;

        $_subtitle = get_post_meta($product->get_id(), '_subtitle', true);

        if (!empty($_subtitle)) {
            echo '<div class="tbay-subtitle">'. $_subtitle .'</div>';
        }
    }

    add_action('urna_woo_before_shop_loop_item_caption', 'urna_woo_get_subtitle', 5);
}
