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
                    if (is_object($single_menu) && isset($single_menu->name, $single_menu->term_id)) {
                        $custom_menus[ $single_menu->name ] = $single_menu->term_id;
                    }
                }
            }
        }

        $attributes = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "weight" => 2,
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "weight" => 2,
                "class" => "",
                "holder" => "div",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "weight" => 2,
                "holder" => "div",
                "class" => "",
                "holder" => "div",
                "heading" => esc_html__('Title Date', 'urna'),
                "param_name" => "countdown_title",
                "std" => "Deal ends in:",
            ),
            array(
                'type' => 'autocomplete',
                "weight" => 2,
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
                "weight" => 2,
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
                "type"          => "checkbox",
                "weight" => 2,
                "heading"       => esc_html__('Display Show Banner?', 'urna'),
                "description"   => esc_html__('Show/hidden Show banner', 'urna'),
                "param_name"    => "show_banner",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                'type'          => 'attach_images',
                'weight'        => 2,
                'heading'       => esc_html__('Banner', 'urna'),
                'group'         => esc_html__('Banner Settings', 'urna'),
                'param_name'    => 'banners',
                'description'   => esc_html__('You can choose a image you banner', 'urna'),
                'dependency'    => array(
                        'element'   => 'show_banner',
                        'value'     => array(
                            'yes',
                        ),
                ),
            ),
            array(
                'type'          => 'textfield',
                'weight'        => 2,
                'heading'       => esc_html__('External link', 'urna'),
                'group'         => esc_html__('Banner Settings', 'urna'),
                'param_name'    => 'banner_link',
                'description'   => esc_html__('Select external link.', 'urna'),
                'dependency'    => array(
                        'element'   => 'show_banner',
                        'value'     => array(
                            'yes',
                        ),
                ),
            ),
            array(
                "type"          => "checkbox",
                'weight'        => 2,
                "heading"       => esc_html__('Display Show Menu?', 'urna'),
                "description"   => esc_html__('Show/hidden show menu', 'urna'),
                "param_name"    => "show_menu",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                'type'          => 'dropdown',
                'weight'        => 2,
                'heading'       => esc_html__('Menu', 'urna'),
                'group'         => esc_html__('Menu Settings', 'urna'),
                'param_name'    => 'nav_menu',
                'value'         => $custom_menus,
                'description'   => empty($custom_menus) ? esc_html__('Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'urna') : esc_html__('Select menu to display.', 'urna'),
                'save_always'   => true,
                'dependency'    => array(
                        'element'   => 'show_menu',
                        'value'     => array(
                            'yes',
                        ),
                ),
            ),
        );

        vc_remove_param('tbay_product_countdown', 'title');
        vc_remove_param('tbay_product_countdown', 'subtitle');
        vc_remove_param('tbay_product_countdown', 'countdown_title');
        vc_remove_param('tbay_product_countdown', 'categories');
        vc_remove_param('tbay_product_countdown', 'layout_type');
        vc_add_params('tbay_product_countdown', $attributes);
    }
}

add_action('vc_after_set_mode', 'urna_tbay_load_private_woocommerce_element', 98);
