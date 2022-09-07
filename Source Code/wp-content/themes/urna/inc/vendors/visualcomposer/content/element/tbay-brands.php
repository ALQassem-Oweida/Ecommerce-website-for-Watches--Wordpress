<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna brands element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_brands')) {
    function urna_vc_map_tbay_brands()
    {
        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "value" => '',
                "admin_label"	=> true
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
                "type" => "textfield",
                "heading" => esc_html__('Number', 'urna'),
                "param_name" => "number",
                "value" => '6'
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                'value' 	=> array(
                    esc_html__('Carousel', 'urna') => 'carousel',
                    esc_html__('Grid', 'urna') => 'grid'
                ),
                'std' => ''
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('On click action', 'urna'),
                'param_name' => 'onclick',
                'value' => array(
                    esc_html__('Same window', 'urna') => '_self',
                    esc_html__('New window', 'urna') => '_blank',
                ),
                'description' => esc_html__('Select action for click action.', 'urna'),
                'std' => '_blank',
            ),
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
                'type' 			=> 'vc_link',
                'heading' 		=> esc_html__('Custom link', 'urna'),
                "group" 		=> esc_html__('Custom Link', 'urna'),
                'param_name' 	=> 'link',
                'description' 	=> esc_html__('Add custom link.', 'urna'),
                'dependency' 	=> array(
                        'element' 	=> 'check_custom_link',
                        'value' 	=> 'yes',
                ),
            )
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive_brands', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $custom_params, $last_params);

        vc_map(array(
            "name" 	=> esc_html__('Urna Brands', 'urna'),
            "base" 	=> "tbay_brands",
            'icon' 	=> 'vc-icon-urna',
            "class" => "",
            "description"=> esc_html__('Display brands on front end', 'urna'),
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_brands');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_brands extends WPBakeryShortCode
    {
    }
}
