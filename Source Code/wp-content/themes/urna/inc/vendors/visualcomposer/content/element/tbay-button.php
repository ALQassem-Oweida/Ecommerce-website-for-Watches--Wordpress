<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna button element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_button')) {
    function urna_vc_map_tbay_button()
    {
        $params = array(
            array(
                'type' 			=> 'vc_link',
                'heading' 		=> esc_html__('Custom link', 'urna'),
                'param_name' 	=> 'link',
                'description' 	=> esc_html__('Add custom link.', 'urna'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style', 'urna'),
                'description' => esc_html__('Select button display style.', 'urna'),
                'param_name' => 'style',
                'value' => array(
                    esc_html__('Default', 'urna') => 'default',
                    esc_html__('Primary', 'urna') => 'primary',
                ),
                'std' => 'primary',
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Add icon?', 'urna'),
                'param_name' => 'add_icon',
                "value" 		=> array(
                                esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Icon library', 'urna'),
                'value' => array(
                    esc_html__('Font Awesome', 'urna') => 'fontawesome',
                    esc_html__('Simple Line', 'urna') 	=> 'simpleline',
                    esc_html__('Linear Icons', 'urna') 	=> 'linearicons',
                    esc_html__('Material', 'urna') 		=> 'material',
                ),
                'param_name' => 'type',
                'dependency' => array(
                    'element' 	=> 'add_icon',
                    'value' 	=> 'yes',
                ),
                'description' => esc_html__('Select icon library.', 'urna'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Icon Alignment', 'urna'),
                'description' => esc_html__('Select icon alignment.', 'urna'),
                'param_name' => 'i_align',
                'dependency' => array(
                    'element' 	=> 'add_icon',
                    'value' 	=> 'yes',
                ),
                'value' => array(
                    esc_html__('Left', 'urna') => 'left',
                    // default as well
                    esc_html__('Right', 'urna') => 'right',
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'fontawesome',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_simpleline',
                'value' => 'icon-user',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'simpleline',
                    'iconsPerPage' => 100,
                    // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'simpleline',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_linearicons',
                'value' => 'linear-icon-home',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'linearicons',
                    'iconsPerPage' => 100,
                    // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'linearicons',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'material',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'material',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            )
        );

        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params 		= array_merge($params, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Button', 'urna'),
            "base" => "tbay_button",
            "icon" => "vc-icon-urna",
            "class" => "",
            "description"=> esc_html__('Custom button', 'urna'),
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_button');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_button extends WPBakeryShortCode
    {
    }
}
