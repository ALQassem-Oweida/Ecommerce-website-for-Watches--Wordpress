<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna ourteam element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_ourteam')) {
    function urna_vc_map_tbay_ourteam()
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
                "type" => "attach_image",
                "param_name" => "image_icon",
                "value" => '',
                'heading'	=> esc_html__('Title Icon', 'urna')
            ),
              array(
                'type' => 'param_group',
                'heading' => esc_html__('Members Settings', 'urna'),
                'param_name' => 'members',
                'description' => '',
                'value' => '',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => esc_html__('Name', 'urna'),
                        "param_name" => "name",
                        'admin_label' => true,
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => esc_html__('Job', 'urna'),
                        "param_name" => "job",
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__('Image', 'urna'),
                        "param_name" => "image"
                    ),

                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => esc_html__('Facebook', 'urna'),
                        "param_name" => "facebook",
                    ),

                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => esc_html__('Twitter Link', 'urna'),
                        "param_name" => "twitter",
                    ),

                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => esc_html__('Google plus Link', 'urna'),
                        "param_name" => "google",
                    ),

                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => esc_html__('Linkin Link', 'urna'),
                        "param_name" => "linkin",
                    ),

                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => esc_html__('Instagram Link', 'urna'),
                        "param_name" => "instagram",
                    ),

                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback',
                ),
            ),
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params 		= array_merge($params, $responsive, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Our Team', 'urna'),
            "base" => "tbay_ourteam",
            "icon" => "vc-icon-urna",
            'description'=> esc_html__('Display Our Team In FrontEnd', 'urna'),
            "class" => "",
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_ourteam');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_ourteam extends WPBakeryShortCode
    {
    }
}
