<?php

if (!class_exists('woo_brands')) {
    return;
}

/*Get title My Account in top bar mobile*/
if (! function_exists('urna_tbay_woo_brands_get_title_mobile')) {
    function urna_tbay_woo_brands_get_title_mobile($title = '')
    {
        if (is_tax('product_brand')) {
            $term_id = get_queried_object_id();
            $term = get_term($term_id);
            
            $title = esc_html__('Brand: ', 'urna').$term->name;
        }

        return $title;
    }
    add_filter('urna_get_filter_title_mobile', 'urna_tbay_woo_brands_get_title_mobile', 10, 1);
}
