<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna newsletter element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_newsletter')) {
    function urna_vc_map_tbay_newsletter()
    {
        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "value" => '',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
            ),
            array(
                "type" => "textarea",
                "heading" => esc_html__('Description', 'urna'),
                "param_name" => "description",
                "value" => '',
            )
        );

        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params 		= array_merge($params, $last_params);
        vc_map(array(
            "name" => esc_html__('Urna Newsletter', 'urna'),
            "base" => "tbay_newsletter",
            "icon" => "vc-icon-urna",
            "class" => "",
            "description"=> esc_html__('Show newsletter form', 'urna'),
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_newsletter');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_newsletter extends WPBakeryShortCode
    {
    }
}
