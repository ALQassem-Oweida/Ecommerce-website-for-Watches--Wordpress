<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna gallery element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_custom_menu')) {
    function urna_vc_map_tbay_custom_menu()
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

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "value" => '',
                "admin_label"	=> true
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
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Select menu style', 'urna'),
                'param_name' => 'select_menu',
                'value'       => array(
                    'Default'  		  => 'none',
                    'Treeview Menu'   => 'treeview',
                    'Vertical Menu'   => 'tbay-vertical'
                ),
                'description' => esc_html__('Select the type of menu you want to display  ex: none, treeview, vertical', 'urna') ,
                'save_always' => true,
                'admin_label' => true,
            )
        );

        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params 		= array_merge($params, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Custom Menu', 'urna'),
            "base" => "tbay_custom_menu",
            "icon" => "vc-icon-urna",
            "class" => "",
            "description"=> esc_html__('Show Custom Menu', 'urna'),
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_custom_menu');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_custom_menu extends WPBakeryShortCode
    {
    }
}
