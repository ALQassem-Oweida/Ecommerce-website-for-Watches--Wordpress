<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna Socials link element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_socials_link')) {
    function urna_vc_map_tbay_socials_link()
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
                "type" => "textarea",
                "heading" => esc_html__('Description', 'urna'),
                "param_name" => "description",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Style', 'urna'),
                "param_name" => 'style',
                "value" => array(
                    esc_html__('Style 1', 'urna') => 'style1',
                    esc_html__('Style 2', 'urna') => 'style2',
                    esc_html__('Style 3', 'urna') => 'style3',
                ),
                'std'       => 'style1',
                "admin_label"	=> true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Facebook Page URL', 'urna'),
                "param_name" => "facebook_url",
                "value" => '',
                "admin_label"	=> true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Twitter Page URL', 'urna'),
                "param_name" => "twitter_url",
                "value" => '',
                "admin_label"	=> true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Youtube Page URL', 'urna'),
                "param_name" => "youtube-play_url",
                "value" => '',
                "admin_label"	=> true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Instagram Page URL', 'urna'),
                "param_name" => "instagram_url",
                "value" => '',
                "admin_label"	=> true
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Pinterest Page URL', 'urna'),
                "param_name" => "pinterest_url",
                "value" => '',
                "admin_label"	=> true
            )
        );

        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params 		= array_merge($params, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Socials link', 'urna'),
            "base" => "tbay_socials_link",
            "icon" => "vc-icon-urna",
            "description"=> esc_html__('Show socials link', 'urna'),
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_socials_link');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_socials_link extends WPBakeryShortCode
    {
    }
}
