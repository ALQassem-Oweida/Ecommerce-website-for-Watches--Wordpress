<?php
if ( !urna_vc_is_activated() ) {
    return;
}

if (!function_exists('urna_tbay_load_private_woocommerce_element')) {
    function urna_tbay_load_private_woocommerce_element()
    {
        $tags   = urna_tbay_woocommerce_get_tags();

        $attributes = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                'weight' => 2,
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "value" =>''
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                'weight' => 2,
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('List Tags', 'urna'),
                'param_name' => 'tagstabs',
                "category"          =>  "Content",
                'description' => '',
                'weight' => 2,
                'value' => '',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__('Tag', 'urna'),
                        "param_name" => "tag",
                        'description' => esc_html__('Select tag.', 'urna'),
                        "value" => $tags,
                        "admin_label" => true,
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'urna'),
                        'param_name' => 'images',
                    ),
                    array(
                        "type"          => "checkbox",
                        "heading"       => esc_html__('Show custom link?', 'urna'),
                        "description"   => esc_html__('Show/hidden custom link', 'urna'),
                        "param_name"    => "check_custom_link",
                        "value"         => array(
                                            esc_html__('Yes', 'urna') =>'yes' ),
                    ),
                      array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__('Custom link', 'urna'),
                        'param_name'    => 'custom_link',
                        'description'   => esc_html__('Select custom link.', 'urna'),
                        'dependency'    => array(
                                'element'   => 'check_custom_link',
                                'value'     => 'yes',
                        ),
                    ),
                    array(
                        "type"          => "checkbox",
                        "heading"       => esc_html__('Show Button?', 'urna'),
                        "description"   => esc_html__('Show/hidden show button', 'urna'),
                        "param_name"    => "shop_now",
                        "value"         => array(
                                            esc_html__('Yes', 'urna') =>'yes' ),
                    ),
                    array(
                        "type"          => "textfield",
                        "heading"       => esc_html__('Custom Text Button', 'urna'),
                        "description"   => esc_html__('custom text of button shop now', 'urna'),
                        "param_name"    => "shop_now_text",
                        "value"         => esc_html__('Shop now', 'urna'),
                        'dependency'    => array(
                                'element'   => 'shop_now',
                                'value'     => 'yes',
                        ),
                    ),
                    array(
                        "type"          => "textarea",
                        "heading"       => esc_html__('Description', 'urna'),
                        "param_name"    => "description"
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback',
                ),
            )
        );

        vc_remove_param('tbay_custom_image_list_tags', 'title');
        vc_remove_param('tbay_custom_image_list_tags', 'subtitle');
        vc_remove_param('tbay_custom_image_list_tags', 'tagstabs');
        vc_add_params('tbay_custom_image_list_tags', $attributes);
    }
}

add_action('vc_after_set_mode', 'urna_tbay_load_private_woocommerce_element', 98);
