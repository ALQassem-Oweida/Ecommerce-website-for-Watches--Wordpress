<?php
if ( !urna_vc_is_activated() ) {
    return;
}

if (!function_exists('urna_tbay_load_private_woocommerce_element')) {
    function urna_tbay_load_private_woocommerce_element()
    {
        $custom_menus = array();
        if (is_admin()) {
            $menus = get_terms('nav_menu', array( 'hide_empty' => false ));
            if (is_array($menus) && ! empty($menus)) {
                foreach ($menus as $single_menu) {
                    if (is_object($single_menu) && isset($single_menu->name, $single_menu->slug)) {
                        $custom_menus[ $single_menu->name ] = $single_menu->slug;
                    }
                }
            }
        }

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
                        'type' => 'dropdown',
                        'heading' => esc_html__('Menu', 'urna'),
                        'param_name' => 'nav_menu',
                        'value' => $custom_menus,
                        'description' => empty($custom_menus) ? esc_html__('Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'urna') : esc_html__('Select menu to display.', 'urna'),
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback',
                ),
            )
        );

        vc_remove_param('tbay_custom_image_list_categories', 'title');
        vc_remove_param('tbay_custom_image_list_categories', 'subtitle');
        vc_remove_param('tbay_custom_image_list_categories', 'categoriestabs');
        vc_add_params('tbay_custom_image_list_categories', $attributes);
    }
}

add_action('vc_after_set_mode', 'urna_tbay_load_private_woocommerce_element', 98);
