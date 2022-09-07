<?php
if ( !urna_vc_is_activated() ) {
    return;
}

if (!function_exists('urna_tbay_load_private_woocommerce_element')) {
    function urna_tbay_load_private_woocommerce_element()
    {
        $attributes_image_list_categories = array(
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Display Shop Now?', 'urna'),
                "description"   => esc_html__('Show/hidden Shop Now in each category', 'urna'),
                "param_name"    => "shop_now",
                'weight' => 2,
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                "type"      => "textfield",
                "heading"   => esc_html__('Text Button Shop Now', 'urna'),
                "param_name" => "shop_now_text",
                "value"     => '',
                'weight' => 1,
                'std'       => esc_html__('Shop Now', 'urna'),
                'dependency'    => array(
                        'element'   => 'shop_now',
                        'value'     => array(
                            'yes',
                        ),
                ),

            )
        );

        vc_add_params('tbay_custom_image_list_categories', $attributes_image_list_categories);
    }
}

add_action('vc_after_set_mode', 'urna_tbay_load_private_woocommerce_element', 98);
