<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna products element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_products')) {
    function urna_vc_map_tbay_products()
    {
        $types = array(
            'Best Selling' => 'best_selling',
            'Featured Products' => 'featured_product',
            'Top Rate' => 'top_rate',
            'New Arrivals' => 'recent_product',
            'On Sale' => 'on_sale',
            'Random Products' => 'random_product'
        );


        $layouts = array(
            'Grid'=>'grid',
            'Carousel'=>'carousel',
            'Vertical'=>'vertical'
        );

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "admin_label" => true,
                "value" => ''
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
                'type' => 'autocomplete',
                'heading' => esc_html__('Categories', 'urna'),
                'value' => '',
                'param_name' => 'categories',
                "admin_label" => true,
                'description' => esc_html__('Choose categories if you want show products of them', 'urna'),
                    'settings' => array(
                        'multiple' => true,
                        'min_length' => 1,
                        'groups' => true,
                        // In UI show results grouped by groups, default false
                        'unique_values' => true,
                        // In UI show results except selected. NB! You should manually check values in backend, default false
                        'display_inline' => true,
                        // In UI show results inline view, default false (each value in own line)
                        'delay' => 500,
                        // delay for search. default 500
                        'auto_focus' => true,
                        // auto focus input, default true
                    ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                "value" => $layouts
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Type', 'urna'),
                "param_name" => "type",
                "value" => $types,
                "admin_label" => true,
                "description" => esc_html__('Select Type.', 'urna')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number of products to show', 'urna'),
                "param_name" => "number",
                "value" => '4'
            ),
        );

        $custom_params = array(
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Display Show More?', 'urna'),
                "description" 	=> esc_html__('Show/hidden Show More', 'urna'),
                "param_name" 	=> "show_button",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                "type" 		=> "textfield",
                "class" 	=> "",
                "heading" 	=> esc_html__('Text Button', 'urna'),
                "param_name" => "button_text",
                "value" 	=> '',
                'std'       => esc_html__('Show more', 'urna'),
                'dependency' 	=> array(
                        'element' 	=> 'show_button',
                        'value' 	=> array(
                            'yes',
                        ),
                ),
            ),
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $custom_params, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Products', 'urna'),
            "base" => "tbay_products",
            "icon" 	   	  => "vc-icon-urna",
            'description'=> esc_html__('Show products as bestseller, featured in block', 'urna'),
            "class" => "",
            "category" => esc_html__('Urna Woocommerce', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_products');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_products extends WPBakeryShortCode
    {
    }
}
