<?php

if (!urna_is_woo_variation_swatches_pro()) {
    return;
}

if (! function_exists('urna_is_quantity_field_archive')) {
    function urna_is_quantity_field_archive()
    {
        global $product;

        if ($product && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually()) {
            $max_value = $product->get_max_purchase_quantity();
            $min_value = $product->get_min_purchase_quantity();

            if ($max_value && $min_value === $max_value) {
                return false;
            }
            
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('urna_quantity_swatches_pro_field_archive')) {
    function urna_quantity_swatches_pro_field_archive()
    {
        global $product;
        if (urna_is_quantity_field_archive()) {
            woocommerce_quantity_input(array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ));
        }
    }
}

if (! function_exists('urna_variation_swatches_pro_group_button')) {
    function urna_variation_swatches_pro_group_button()
    {
        $class_active = '';

        if (!apply_filters('urna_quantity_mode', 10, 2)) {
            $class_active .= 'woo-swatches-pro-btn';
        }

        if (!apply_filters('urna_quantity_mode', 10, 2)) {
            echo '<div class="'. esc_attr($class_active) .'">';
        }

        if (apply_filters('urna_quantity_mode', 10, 2)) {
            urna_quantity_swatches_pro_field_archive();
        }

        woocommerce_template_loop_add_to_cart();
        if (!apply_filters('urna_quantity_mode', 10, 2)) {
            echo '</div>';
        }
    }
    add_action('woocommerce_after_shop_loop_item', 'urna_variation_swatches_pro_group_button', 10);
}


if (! function_exists('urna_wvs_theme_support')) {
    function urna_wvs_theme_support()
    {
        remove_action('woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30);
        remove_action('woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7);
        
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

        add_filter('woo_variation_swatches_archive_product_wrapper', function () {
            return '.product-block';
        });
        
        add_filter('woo_variation_swatches_archive_add_to_cart_text', function () {
            return '<i class="linear-icon-cart-plus"></i><span class="title-cart">' . esc_html__('Add to cart', 'urna'). '</span>';
        });

        add_filter('woo_variation_swatches_archive_add_to_cart_select_options', function () {
            return '<i class="linear-icon-cart-plus"></i><span class="title-cart">' . esc_html__('Select options', 'urna') . '</span>';
        });
    }
    add_action('init', 'urna_wvs_theme_support', 99);
}

if (! function_exists('urna_tbay_woocommerce_grid_variable_swatches_pro')) {
    function urna_tbay_woocommerce_grid_variable_swatches_pro()
    {
        add_action('urna_woo_after_shop_loop_item_caption', 'wvs_pro_archive_variation_template', 10);
    }
    add_action('urna_tbay_after_shop_loop_item_title', 'urna_tbay_woocommerce_grid_variable_swatches_pro', 30);
}

if (! function_exists('urna_tbay_woocommerce_list_variable_swatches_pro')) {
    function urna_tbay_woocommerce_list_variable_swatches_pro()
    {
        add_action('woocommerce_after_shop_loop_item_title', 'wvs_pro_archive_variation_template', 20);
    }
    add_action('urna_woocommerce_before_shop_list_item', 'urna_tbay_woocommerce_list_variable_swatches_pro', 5);
}



// remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 30 );
// remove_action( 'woocommerce_after_shop_loop_item', 'wvs_pro_archive_variation_template', 7 );

// add_action( 'urna_woo_list_after_short_description', 'wvs_pro_archive_variation_template', 20 );
