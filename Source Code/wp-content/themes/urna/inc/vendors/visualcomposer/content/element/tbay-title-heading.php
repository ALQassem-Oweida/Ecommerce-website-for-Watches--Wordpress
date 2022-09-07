<?php

/**
* ------------------------------------------------------------------------------------------------
* Urna Heading element map
* ------------------------------------------------------------------------------------------------
*/

if (! function_exists('urna_vc_map_tbay_title_heading')) {
    function urna_vc_map_tbay_title_heading()
    {
        $params = array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'urna'),
                'param_name' => 'title',
                'value'       => esc_html__('Title', 'urna'),
                'description' => esc_html__('Enter heading title.', 'urna'),
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
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'urna'),
                'param_name' => 'font_color',
                'description' => esc_html__('Select font color', 'urna')
            ),
             
            array(
                "type" => "textarea",
                'heading' => esc_html__('Description', 'urna'),
                "param_name" => "descript",
                "value" => '',
                'description' => esc_html__('Enter description for title.', 'urna')
            ),

            array(
                'type' => 'textfield',
                'heading' => esc_html__('Text Button', 'urna'),
                'param_name' => 'textbutton',
                'description' => esc_html__('Text Button', 'urna'),
                "admin_label" => true
            ),

            array(
                'type' => 'textfield',
                'heading' => esc_html__(' Link Button', 'urna'),
                'param_name' => 'linkbutton',
                'description' => esc_html__('Link Button', 'urna'),
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Button Style', 'urna'),
                "param_name" => "buttons",
                'value' 	=> array(
                    esc_html__('Default Outline', 'urna') => 'btn-default btn-outline',
                    esc_html__('Primary Outline', 'urna') => 'btn-primary btn-outline',
                    esc_html__('Lighten', 'urna') => 'btn-lighten'
                ),
                'std' => ''
            )

        );

        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params 		= array_merge($params, $last_params);

        vc_map(array(
            'name'        => esc_html__('Urna Heading', 'urna'),
            'base'        => 'tbay_title_heading',
            'icon' 		  => 'vc-icon-urna',
            "class"       => "",
            "category" => esc_html__('Urna Elements', 'urna'),
            'description' => esc_html__('Create title', 'urna'),
            "params"      => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_title_heading');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_title_heading extends WPBakeryShortCode
    {
    }
}
