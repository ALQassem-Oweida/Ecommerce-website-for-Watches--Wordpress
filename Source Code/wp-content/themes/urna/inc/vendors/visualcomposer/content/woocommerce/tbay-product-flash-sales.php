<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna product flash sales element map
* ------------------------------------------------------------------------------------------------
*/

require get_template_directory() . '/inc/vendors/visualcomposer/custom-param-type/datepicker.php';

if (!function_exists('urna_productIdAutocompleteSuggester')) {
    function urna_productIdAutocompleteSuggester($query)
    {
        global $wpdb;
        $product_id = (int) $query;
        $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
                    FROM {$wpdb->posts} AS a
                    LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
                    WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes($query), stripslashes($query)), ARRAY_A);

        $results = array();
        if (is_array($post_meta_infos) && ! empty($post_meta_infos)) {
            foreach ($post_meta_infos as $value) {
                $data = array();
                $data['value'] = $value['id'];
                $data['label'] = esc_html__('Id', 'urna') . ': ' . $value['id'] . ((strlen($value['title']) > 0) ? ' - ' . esc_html__('Title', 'urna') . ': ' . $value['title'] : '') . ((strlen($value['sku']) > 0) ? ' - ' . esc_html__('Sku', 'urna') . ': ' . $value['sku'] : '');
                $results[] = $data;
            }
        }

        return $results;
    }
}

if (!function_exists('urna_productIdAutocompleteRender')) {
    function urna_productIdAutocompleteRender($query)
    {
        $query = trim($query['value']); // get value from requested
        if (! empty($query)) {
            // get product
            $product_object = wc_get_product((int) $query);
            if (is_object($product_object)) {
                $product_sku = $product_object->get_sku();
                $product_title = $product_object->get_title();
                $product_id = $product_object->get_id();

                $product_sku_display = '';
                if (! empty($product_sku)) {
                    $product_sku_display = ' - ' . esc_html__('Sku', 'urna') . ': ' . $product_sku;
                }

                $product_title_display = '';
                if (! empty($product_title)) {
                    $product_title_display = ' - ' . esc_html__('Title', 'urna') . ': ' . $product_title;
                }

                $product_id_display = esc_html__('Id', 'urna') . ': ' . $product_id;

                $data = array();
                $data['value'] = $product_id;
                $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

                return ! empty($data) ? $data : false;
            }

            return false;
        }

        return false;
    }
}

//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter('vc_autocomplete_tbay_product_flash_sales_ids_callback', 'urna_productIdAutocompleteSuggester', 10, 1); // Get suggestion(find). Must return an array
add_filter('vc_autocomplete_tbay_product_flash_sales_ids_render', 'urna_productIdAutocompleteRender', 10, 1); // Render exact item. Must return an array (label,value)

if (!function_exists('urna_vc_map_tbay_product_flash_sales')) {
    function urna_vc_map_tbay_product_flash_sales()
    {
        $orderbys = array(
            esc_html__('Sorting', 'urna') => 'post__in',
            esc_html__('Date', 'urna') => 'date',
            esc_html__('Price', 'urna') => 'price',
            esc_html__('Title', 'urna') => 'title',
            esc_html__('Last modified date', 'urna') => 'modified',
            esc_html__('Random order', 'urna') => 'rand',
            esc_html__('ID', 'urna') => 'ID'
        );


        $orders = array(
            esc_html__('Ascending', 'urna') => 'ASC',
            esc_html__('Descending', 'urna') => 'DESC',
        );

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "holder" => "div",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "holder" => "div",
                "heading" => esc_html__('Title Date', 'urna'),
                "param_name" => "date_title",
                "std" => "Deal ends in:",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "holder" => "div",
                "heading" => esc_html__('Title deal ended', 'urna'),
                "param_name" => "date_title_ended",
                "std" => "Deal ended.",
            ),
            array(
                "type" => "datepicker",
                "holder" => "div",
                "heading" => esc_html__('End Date', 'urna'),
                "param_name" => "end_date",
            ),
            array(
                'type' => 'autocomplete',
                'heading' => esc_html__('Products', 'urna'),
                'param_name' => 'ids',
                'admin_label' => true,
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'unique_values' => true,
                    // In UI show results except selected. NB! You should manually check values in backend
                ),
                'save_always' => true,
                'description' => esc_html__('Enter List of Products', 'urna'),
            ),
            array(
                'type' => 'hidden',
                'param_name' => 'skus',
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                "value" => array(
                    'Grid'=>'grid',
                    'Carousel'=>'carousel',
                )
            )
        );

        $custom_params = array(
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Show custom link?', 'urna'),
                "description" 	=> esc_html__('Show/hidden custom link', 'urna'),
                "param_name" 	=> "check_custom_link",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                'type' 			=> 'dropdown',
                'heading' 		=> esc_html__('Position button', 'urna'),
                "group" 		=> esc_html__('Custom Link', 'urna'),
                'param_name' 	=> 'position',
                'description' 	=> esc_html__('Add custom link.', 'urna'),
                'dependency' 	=> array(
                        'element' 	=> 'check_custom_link',
                        'value' 	=> 'yes',
                ),
                'value' => array(
                    esc_html__('Top', 'urna') 	=> 'top',
                    esc_html__('Bottom', 'urna') 	=> 'bottom',
                ),
            ),
            array(
                'type' 			=> 'vc_link',
                'heading' 		=> esc_html__('Custom link', 'urna'),
                "group" 		=> esc_html__('Custom Link', 'urna'),
                'param_name' 	=> 'link',
                'description' 	=> esc_html__('Add custom link.', 'urna'),
                'dependency' 	=> array(
                        'element' 	=> 'check_custom_link',
                        'value' 	=> 'yes',
                ),
            ),
            // Data settings
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order by', 'urna'),
                'param_name' => 'orderby',
                'admin_label' => true,
                'value' => $orderbys,
                'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'urna'),
                'group' => esc_html__('Data Settings', 'urna'),
                'param_holder_class' => 'vc_grid-data-type-not-ids',
                'std' 	=> 'post__in'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Sort order', 'urna'),
                'param_name' => 'order',
                'admin_label' => true,
                'group' => esc_html__('Data Settings', 'urna'),
                'value' => $orders,
                'param_holder_class' => 'vc_grid-data-type-not-ids',
                'description' => esc_html__('Select sorting order.', 'urna'),
            )
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $custom_params, $last_params);


        vc_map(array(
            "name" => esc_html__('Urna Product Flash Sales', 'urna'),
            "base" => "tbay_product_flash_sales",
            "icon" 	   	  => "vc-icon-urna",
            "class" => "",
            "category" => esc_html__('Urna Woocommerce', 'urna'),
            'description'	=> esc_html__('Display Product flash Sales with Count Down', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_product_flash_sales');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_product_flash_sales extends WPBakeryShortCode
    {
    }
}
