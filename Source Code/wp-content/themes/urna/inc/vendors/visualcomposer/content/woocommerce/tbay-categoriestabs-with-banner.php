<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna categories tabs element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_categoriestabs_with_banner')) {
    function urna_vc_map_tbay_categoriestabs_with_banner()
    {
        $categories = urna_tbay_woocommerce_get_categories();

        $types = array(
            'Best Selling' => 'best_selling',
            'Featured Products' => 'featured_product',
            'Top Rate' => 'top_rate',
            'New Arrivals' => 'recent_product',
            'On Sale' => 'on_sale',
            'Random Products' => 'random_product'
        );

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "value" => '',
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            
            array(
                'type' => 'param_group',
                'heading' => esc_html__('Tabs', 'urna'),
                'param_name' => 'categoriestabs',
                'description' => '',
                'value' => '',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__('Category', 'urna'),
                        "param_name" => "category",
                        "value" => $categories,
                        "admin_label" => true,
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Positions Banner', 'urna'),
                        'param_name' => 'banner_positions',
                        'value' 	=> array(
                                    esc_html__('Left', 'urna') => 'left',
                                    esc_html__('Right', 'urna') =>'right'
                                ),
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Banner', 'urna'),
                        'param_name' => 'banner',
                        'description' => esc_html__('You can choose a image you banner', 'urna'),
                    ),

                    array(
                        'type' 			=> 'textfield',
                        'heading' 		=> esc_html__('External link', 'urna'),
                        'param_name' 	=> 'banner_link',
                        'description' 	=> esc_html__('Select external link.', 'urna'),
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback',
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Type', 'urna'),
                "param_name" => "type_product",
                "value" => $types,
                "admin_label" => true,
                "description" => esc_html__('Select Type Product.', 'urna')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Number Products', 'urna'),
                'value' => 12,
                'param_name' => 'number',
                'description' => esc_html__('Number products per page to show', 'urna'),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout', 'urna'),
                "param_name" => "layout_type",
                "value" => array(
                            esc_html__('Grid', 'urna') =>'grid',
                            esc_html__('Carousel', 'urna') => 'carousel'),
                "admin_label" => true,
                "description" => esc_html__('Select Columns.', 'urna')
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Show Ajax Product Tabs?', 'urna'),
                "description"   => esc_html__('Show/hidden Ajax Product Tabs', 'urna'),
                "param_name"    => "ajax_tabs",
                "std"           => "",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $last_params);

        vc_map(array(
            'name' => esc_html__('Urna Products Categories Tabs With Banner', 'urna'),
            'base' => 'tbay_categoriestabs_with_banner',
            'icon' 	   	  => 'vc-icon-urna',
            'category' => esc_html__('Urna Woocommerce', 'urna'),
            'description' => esc_html__('Display  categories in Tabs', 'urna'),
            'params' => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_categoriestabs_with_banner');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_categoriestabs_with_banner extends WPBakeryShortCode
    {
    }
}
