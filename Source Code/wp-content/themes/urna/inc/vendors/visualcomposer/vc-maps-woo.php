<?php

if ( !urna_vc_is_activated() || !class_exists('WooCommerce') ) {
    return;
}


if (!function_exists('urna_tbay_get_category_childs')) {
    function urna_tbay_get_category_childs($categories, $id_parent, $level, &$dropdown)
    {
        foreach ($categories as $key => $category) {
            if ($category->category_parent == $id_parent) {
                $dropdown = array_merge($dropdown, array( str_repeat("- ", $level) . $category->name . ' (' .$category->count .')' => $category->term_id ));
                unset($categories[$key]);
                urna_tbay_get_category_childs($categories, $category->term_id, $level + 1, $dropdown);
            }
        }
    }
}

if (!function_exists('urna_tbay_woocommerce_get_categories')) {
    function urna_tbay_woocommerce_get_categories()
    {
        $return = array( esc_html__(' --- Choose a Category --- ', 'urna') );

        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'taxonomy' => 'product_cat'
        );

        $categories = get_categories($args);
        urna_tbay_get_category_childs($categories, 0, 0, $return);
        return $return;
    }
}

if (!function_exists('urna_tbay_vc_get_term_object')) {
    function urna_tbay_vc_get_term_object($term)
    {
        $vc_taxonomies_types = vc_taxonomies_types();

        return array(
            'label' => $term->name,
            'value' => $term->term_id,
            'group_id' => $term->taxonomy,
            'group' => isset($vc_taxonomies_types[ $term->taxonomy ], $vc_taxonomies_types[ $term->taxonomy ]->labels, $vc_taxonomies_types[ $term->taxonomy ]->labels->name) ? $vc_taxonomies_types[ $term->taxonomy ]->labels->name : esc_html__('Taxonomies', 'urna'),
        );
    }
}




if (!function_exists('urna_tbay_category_field_search')) {
    function urna_tbay_category_field_search($search_string)
    {
        $data = array();
        $vc_taxonomies_types = array('product_cat');
        $vc_taxonomies = get_terms($vc_taxonomies_types, array(
            'hide_empty' => false,
            'search' => $search_string
        ));
        if (is_array($vc_taxonomies) && ! empty($vc_taxonomies)) {
            foreach ($vc_taxonomies as $t) {
                if (is_object($t)) {
                    $data[] = urna_tbay_vc_get_term_object($t);
                }
            }
        }
        return $data;
    }
}

if (!function_exists('urna_tbay_category_render')) {
    function urna_tbay_category_render($query)
    {
        $category = get_term_by('id', (int)$query['value'], 'product_cat');
        if (! empty($query) && !empty($category)) {
            $data = array();
            $data['value'] = $category->slug;
            $data['label'] = $category->name;
            return ! empty($data) ? $data : false;
        }
        return false;
    }
}

/*Add ajax load list categories*/
$bases = array( 'tbay_productstabs', 'tbay_products', 'tbay_product_countdown', 'tbay_products_menu_banner' );
foreach ($bases as $base) {
    add_filter('vc_autocomplete_'.$base .'_categories_callback', 'urna_tbay_category_field_search', 10, 1);
    add_filter('vc_autocomplete_'.$base .'_categories_render', 'urna_tbay_category_render', 10, 1);
}

/**
 * Include vc element woocommerce
 */
if (!function_exists('urna_tbay_include_vc_element_woocommerce')) {
    function urna_tbay_include_vc_element_woocommerce()
    {
        $vc_elements_array = array(
            'tbay-products',
            'tbay-productstabs',
            'tbay-categoriestabs',
            'tbay-product-countdown',
            'tbay-product-flash-sales',
            'tbay-productcategory',
            'tbay-list-categories',
            'tbay-custom-image-list-categories',
            'tbay-custom-image-list-tags',
            'tbay-woocommerce-tag',
            'tbay-product-recently-viewed',
        );

        $vc_elements = apply_filters('urna_woocommerce_vc_elements_array', $vc_elements_array);

        foreach ($vc_elements as $file) {
            $path =     URNA_VISUALCOMPOSER .'/content/woocommerce/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }
}

urna_tbay_include_vc_element_woocommerce();
urna_tbay_visualcomposer_woocommerce_skin_load_file();
