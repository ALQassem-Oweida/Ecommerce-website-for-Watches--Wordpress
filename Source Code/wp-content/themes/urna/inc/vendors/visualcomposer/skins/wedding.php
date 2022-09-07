<?php
if ( !urna_vc_is_activated() ) {
    return;
}

if (!function_exists('urna_tbay_load_private_woocommerce_element')) {
    function urna_tbay_load_private_woocommerce_element()
    {
        $categories = urna_tbay_woocommerce_get_categories();

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
                'heading' => esc_html__('List Categories', 'urna'),
                'param_name' => 'categoriestabs',
                'description' => '',
                'weight' => 2,
                'value' => '',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__('Category', 'urna'),
                        "param_name" => "category",
                        "value" => $categories,
                        "admin_label" => true,
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Image', 'urna'),
                        'param_name' => 'images',
                        'description' => esc_html__('Main Image of Category', 'urna'),
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Sub Image', 'urna'),
                        'param_name' => 'sub_images',
                    ),
                    array(
                        "type" => "textarea",
                        "class" => "",
                        "heading" => esc_html__('Description', 'urna'),
                        "param_name" => "description",
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
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback',
                ),
            ),
        );

        vc_remove_param('tbay_custom_image_list_categories', 'title');
        vc_remove_param('tbay_custom_image_list_categories', 'subtitle');
        vc_remove_param('tbay_custom_image_list_categories', 'categoriestabs');
        vc_add_params('tbay_custom_image_list_categories', $attributes);
    }
}

add_action('vc_after_set_mode', 'urna_tbay_load_private_woocommerce_element', 98);
