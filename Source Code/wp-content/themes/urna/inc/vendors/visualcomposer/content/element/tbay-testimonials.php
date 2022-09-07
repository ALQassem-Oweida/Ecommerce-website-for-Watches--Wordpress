<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna testimonials element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_testimonials')) {
    function urna_vc_map_tbay_testimonials()
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
                  "type" => "textfield",
                  "heading" => esc_html__('Number', 'urna'),
                  "param_name" => "number",
                  "value" => '4',
            )
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Testimonials', 'urna'),
            "base" => "tbay_testimonials",
            "icon" => "vc-icon-urna",
            'description'=> esc_html__('Display Testimonials In FrontEnd', 'urna'),
            "class" => "",
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_testimonials');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_testimonials extends WPBakeryShortCode
    {
    }
}
