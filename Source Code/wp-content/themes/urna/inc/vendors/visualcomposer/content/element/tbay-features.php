<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna gallery element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_features')) {
    function urna_vc_map_tbay_features()
    {
        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "admin_label" => true,
                "value" => '',
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
                'heading' => esc_html__('Members Settings', 'urna'),
                'param_name' => 'items',
                'description' => '',
                'value' => '',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_html__('Title', 'urna'),
                        "param_name" => "title",
                    ),
                    array(
                        "type" => "textarea",
                        "class" => "",
                        "heading" => esc_html__('Description', 'urna'),
                        "param_name" => "description",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Icon Font", 'urna'),
                        "param_name" => "icon",
                        "value" => '',
                        'description' => esc_html__('This support display icon from ', 'urna')
                                        . '<a href="' . (is_ssl()  ? 'https' : 'http') . '://fontawesome.com/v4.7.0/icons/" target="_blank">'
                                        . esc_html__('Font Awesome', 'urna') . '</a>, <a href="' . (is_ssl()  ? 'https' : 'http') . '://fonts.thembay.com/material-design-iconic/" target="_blank">'
                                        . esc_html__('Material Design Iconic', 'urna') . '</a>, <a href="' . (is_ssl()  ? 'https' : 'http') . '://fonts.thembay.com/linearicons/" target="_blank">'
                                        . esc_html__('Linearicons', 'urna') . '</a>, <a href="' . (is_ssl()  ? 'https' : 'http') . '://fonts.thembay.com/simple-line-icons/" target="_blank">'
                                        . esc_html__('Simple line icons', 'urna') . '</a>'
                    ),
                    array(
                        "type" => "attach_image",
                        "description" => esc_html__('In case of choosing both, the image will be prioritized.', 'urna'),
                        "param_name" => "image",
                        "value" => '',
                        'heading'	=> esc_html__('Image', 'urna')
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback',
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                'value' 	=> array(
                    esc_html__('Style 1', 'urna') => '',
                    esc_html__('Style 2', 'urna') => 'style-2',
                    esc_html__('Style 3', 'urna') => 'style-3'
                )
            ),
        );
    
        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params 		= array_merge($params, $responsive, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Features', 'urna'),
            "base" => "tbay_features",
            "icon" => "vc-icon-urna",
            'description'=> esc_html__('Display Features In FrontEnd', 'urna'),
            "class" => "",
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_features');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_features extends WPBakeryShortCode
    {
    }
}
