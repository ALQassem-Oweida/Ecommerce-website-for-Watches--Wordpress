<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna woocommerce tag element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_woocommerce_tag')) {
    function urna_vc_map_tbay_woocommerce_tag()
    {
        $columns = apply_filters('urna_admin_visualcomposer_columns', array(1,2,3,4,5,6));
        $rows 	 = apply_filters('urna_admin_visualcomposer_rows', array(1,2,3));

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "value" => '',
                "admin_label" => true,
                'std' => esc_html__('Trending tags', 'urna'),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number tag to show', 'urna'),
                "param_name" => "number",
                'std' => '12',
                "admin_label" => true,
            )
        );

        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params = array_merge($params, $last_params);

        vc_map(array(
            'name' => esc_html__('Woocommerce Tag', 'urna'),
            'base' => 'tbay_woocommerce_tag',
            'icon' 	   	  => 'vc-icon-urna',
            'category' => esc_html__('Urna Woocommerce', 'urna'),
            'description' => esc_html__('Display  Urna Woocommerce', 'urna'),
            'params' => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_woocommerce_tag');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_woocommerce_tag extends WPBakeryShortCode
    {
    }
}
