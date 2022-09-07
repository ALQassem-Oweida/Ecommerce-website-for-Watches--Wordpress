<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna product category element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_productcategory')) {
    function urna_vc_map_tbay_productcategory()
    {
        $categories = urna_tbay_woocommerce_get_categories();

        $columns = apply_filters('urna_admin_visualcomposer_columns', array(1,2,3,4,5,6));
        $rows 	 = apply_filters('urna_admin_visualcomposer_rows', array(1,2,3));

        $layouts = array(
            'Grid'=>'grid',
            'Carousel'=>'carousel',
        );

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
                "type" => "dropdown",
                "heading" => esc_html__('Category', 'urna'),
                "param_name" => "category",
                "value" => $categories,
                "admin_label" => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                "value" => $layouts
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number of products to show', 'urna'),
                "param_name" => "number",
                "value" => '4'
            ),
        );

        $custom_params = array(
            array(
                "type"        => "attach_image",
                "description" => esc_html__('Upload an image for categories', 'urna'),
                "param_name"  => "image_cat",
                "value"       => '',
                'heading'     => esc_html__('Image', 'urna')
            ),
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Display Show More?', 'urna'),
                "description" 	=> esc_html__('Show/hidden Show More', 'urna'),
                "param_name" 	=> "show_button",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                "type" 		=> "textfield",
                "class" 	=> "",
                "heading" 	=> esc_html__('Text Button', 'urna'),
                "param_name" => "button_text",
                "value" 	=> '',
                'std'       => esc_html__('Show more', 'urna'),
                'dependency' 	=> array(
                        'element' 	=> 'show_button',
                        'value' 	=> array(
                            'yes',
                        ),
                ),
            ),
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $custom_params, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Product Category', 'urna'),
            "base" => "tbay_productcategory",
            "icon" 	   	  => "vc-icon-urna",
            "class" => "",
            "category" => esc_html__('Urna Woocommerce', 'urna'),
            'description'=> esc_html__('Show Products In Carousel, Grid', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_productcategory');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_productcategory extends WPBakeryShortCode
    {
    }
}
