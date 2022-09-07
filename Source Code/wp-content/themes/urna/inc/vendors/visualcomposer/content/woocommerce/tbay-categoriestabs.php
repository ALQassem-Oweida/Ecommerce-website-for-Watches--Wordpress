<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna categories tabs element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_categoriestabs')) {
    function urna_vc_map_tbay_categoriestabs()
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
                "heading"       => esc_html__('Show Ajax Categories Tabs?', 'urna'),
                "description"   => esc_html__('Show/hidden Ajax Categories Tabs', 'urna'),
                "param_name"    => "ajax_tabs",
                "std"           => "",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Display View All Products?', 'urna'),
                "description" 	=> esc_html__('Show/hidden View All Products', 'urna'),
                "param_name" 	=> "show_view_all",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
                'dependency' 	=> array(
                        'element' 	=> 'layout_type',
                        'value_not_equal_to' 	=> 'carousel'
                ),
            ),
            array(
                "type" 		=> "textfield",
                "class" 	=> "",
                "heading" 	=> esc_html__('Text Button View All', 'urna'),
                "param_name" => "button_text_view_all",
                "value" 	=> '',
                'std'       => esc_html__('view all', 'urna'),
                'dependency' 	=> array(
                    'element' 	=> 'show_view_all',
                    'value' 	=> array(
                        'yes',
                    ),
                ),
            ),
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $last_params);

        vc_map(array(
            'name' => esc_html__('Urna Products Categories Tabs ', 'urna'),
            'base' => 'tbay_categoriestabs',
            'icon' 	   	  => 'vc-icon-urna',
            'category' => esc_html__('Urna Woocommerce', 'urna'),
            'description' => esc_html__('Display  categories in Tabs', 'urna'),
            'params' => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_categoriestabs');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_categoriestabs extends WPBakeryShortCode
    {
    }
}
