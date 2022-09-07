<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna Video element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_video')) {
    function urna_vc_map_tbay_video()
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
                "type" => "attach_image",
                "heading" => esc_html__('Thumbnail image', 'urna'),
                "param_name" => "thumbnail_image"
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Video URL', 'urna'),
                "param_name" => "video_url",
                "value" => 'https://vimeo.com/51589652',
                "description" => esc_html__('Enter the video url at https://vimeo.com/ or https://www.youtube.com/', 'urna'),
                "admin_label"	=> true
            )
        );

        $last_params    = apply_filters('urna_vc_map_param_last_params', array());
        $params = array_merge($params, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Video', 'urna'),
            "base" => "tbay_video",
            "icon" => "vc-icon-urna",
            "class" => "",
            "description"=> esc_html__('Show video', 'urna'),
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_video');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_video extends WPBakeryShortCode
    {
    }
}
