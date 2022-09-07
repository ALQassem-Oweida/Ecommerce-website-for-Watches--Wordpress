<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna product countdown element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_product_countdown')) {
    function urna_vc_map_tbay_product_countdown()
    {
        $columns = apply_filters('urna_admin_visualcomposer_columns', array(1,2,3,4,5,6));
        $rows 	 = apply_filters('urna_admin_visualcomposer_rows', array(1,2,3));

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "holder" => "div",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "holder" => "div",
                "heading" => esc_html__('Title Date', 'urna'),
                "param_name" => "countdown_title",
                "std" => "Deal ends in:",
            ),
            array(
                'type' => 'autocomplete',
                'heading' => esc_html__('Categories', 'urna'),
                'value' => '',
                'param_name' => 'categories',
                "admin_label" => true,
                'description' => esc_html__('Choose a categories if you want to show products of that them', 'urna'),
                    'settings' => array(
                        'multiple' => true,
                        'min_length' => 1,
                        'groups' => true,
                        // In UI show results grouped by groups, default false
                        'unique_values' => true,
                        // In UI show results except selected. NB! You should manually check values in backend, default false
                        'display_inline' => true,
                        // In UI show results inline view, default false (each value in own line)
                        'delay' => 500,
                        // delay for search. default 500
                        'auto_focus' => true,
                        // auto focus input, default true
                    ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout', 'urna'),
                "param_name" => "layout_type",
                "value" => array(
                    'Grid'=>'grid',
                    'Carousel'=>'carousel',
                ),
                "admin_label" => true,
                "description" => esc_html__('Select Layout.', 'urna')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number items to show', 'urna'),
                "param_name" => "number",
                'std' => '8',
            ),
        );
        
        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Product CountDown', 'urna'),
            "base" => "tbay_product_countdown",
            "icon" 	   	  => "vc-icon-urna",
            "class" => "",
            "category" => esc_html__('Urna Woocommerce', 'urna'),
            'description'	=> esc_html__('Display Product Sales with Count Down', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_product_countdown');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_product_countdown extends WPBakeryShortCode
    {
    }
}
