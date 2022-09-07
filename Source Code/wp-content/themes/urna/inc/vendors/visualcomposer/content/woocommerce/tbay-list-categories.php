<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna List Categories element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_list_categories')) {
    function urna_vc_map_tbay_list_categories()
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
                "value" =>''
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
                "type"       => "textfield",
                "heading"    => esc_html__('Number of categories to show', 'urna'),
                "param_name" => "number",
                "value"      => '6',
                "admin_label" => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                'std'       => 'grid',
                "value" => array(
                    esc_html__('Grid', 'urna') =>'grid',
                    esc_html__('Carousel', 'urna') => 'carousel',
                 ),
                "admin_label" => true,
            ),
        );

        $button_params = array(
            array(
                "type" 			=> "dropdown",
                "heading" 		=> esc_html__('Button Show', 'urna'),
                "description" 	=> esc_html__('Show/hidden config button show', 'urna'),
                "param_name" 	=> 'button_show_type',
                "value" 		=> array(
                                    esc_html__('None', 'urna') => 'none',
                                    esc_html__('Show All', 'urna') => 'all'),
                'std'       	=> 'none',
            ),
            array(
                "type" 		=> "textfield",
                "class" 	=> "",
                "heading" 	=> esc_html__('Text Button Show All', 'urna'),
                "param_name" => "show_all_text",
                "value" 	=> '',
                'std'       => esc_html__('Show All', 'urna'),
                'dependency' 	=> array(
                        'element' 	=> 'button_show_type',
                        'value' 	=> array(
                            'all',
                        ),
                )
            )
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $button_params, $last_params);

        vc_map(array(
            "name"     => esc_html__('Urna List Categories', 'urna'),
            "base"     => "tbay_list_categories",
            "icon" 	   	  => "vc-icon-urna",
            'description' => esc_html__('Show images and links of sub categories in block', 'urna'),
            "class"    => "",
            "category" => esc_html__('Urna Woocommerce', 'urna'),
            "params"   => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_list_categories');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_list_categories extends WPBakeryShortCode
    {
    }
}
