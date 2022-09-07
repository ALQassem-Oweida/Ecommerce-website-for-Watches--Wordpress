<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna Product Recently Viewed map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_product_recently_viewed')) {
    function urna_vc_map_tbay_product_recently_viewed()
    {
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
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                "type" => "textarea_html",
                "class" => "",
                "heading" => esc_html__('Empty text', 'urna'),
                "param_name" => "empty_text",
                'default'  => esc_html__('You have no recent viewed item.', 'urna')
            ),
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Only image?', 'urna'),
                "description" 	=> esc_html__('Show/hidden only image', 'urna'),
                "param_name" 	=> "only_image",
                "std"       	=> "yes",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
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

        $custom_params = array(
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Show custom link?', 'urna'),
                "description" 	=> esc_html__('Show/hidden custom link', 'urna'),
                "param_name" 	=> "check_link_rv",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                'type' 			=> 'vc_link',
                'heading' 		=> esc_html__('Custom link', 'urna'),
                "group" 		=> esc_html__('Custom Link', 'urna'),
                'param_name' 	=> 'link',
                'description' 	=> esc_html__('Add custom link.', 'urna'),
                'dependency' 	=> array(
                        'element' 	=> 'check_link_rv',
                        'value' 	=> 'yes',
                ),
            ),
        );

        
        $responsive     = apply_filters('urna_vc_map_param_responsive_recently_viewed', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $custom_params, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Product Recently Viewed', 'urna'),
            "base" => "tbay_product_recently_viewed",
            "icon" 	   	  => "vc-icon-urna",
            "class" => "",
            "category" => esc_html__('Urna Woocommerce', 'urna'),
            'description'	=> esc_html__('Display Product Recently Viewed', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_product_recently_viewed');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_product_recently_viewed extends WPBakeryShortCode
    {
    }
}
