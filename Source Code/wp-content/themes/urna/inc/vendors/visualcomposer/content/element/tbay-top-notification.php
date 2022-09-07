<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna custom image list tags element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_top_notification')) {
    function urna_vc_map_tbay_top_notification()
    {
        $params = array(
            array(
                "type" => "textfield",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "admin_label" => true,
                "value" => '',
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('Members Settings', 'urna'),
                'param_name' => 'tabs',
                'description' => '',
                'value' => '',
                'params' => array(
                    array(
                        "type" => "textarea",
                        "class" => "",
                        "heading" => esc_html__('Description', 'urna'),
                        "param_name" => "description",
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback',
                ),
            )
        );

        $carousel       = apply_filters('urna_vc_map_param_carousel', array());
        $last_params    = apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Top Notification', 'urna'),
            "base" => "tbay_top_notification",
            "icon" => "vc-icon-urna",
            'description'=> esc_html__('Display Top Notification', 'urna'),
            "class" => "",
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_top_notification');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_top_notification extends WPBakeryShortCode
    {
    }
}
