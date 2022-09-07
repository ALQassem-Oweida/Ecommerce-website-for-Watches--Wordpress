<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna banner element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_banner')) {
    function urna_vc_map_tbay_banner()
    {
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
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                "type" => "textarea",
                "heading" => esc_html__('Description', 'urna'),
                "param_name" => "description",
                "value" => '',
            ),
            array(
                "type" => "attach_image",
                "heading" => esc_html__('Images', 'urna'),
                "param_name" => "image",
                "admin_label" => true,
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Add link?', 'urna'),
                'param_name' => 'add_link',
                "value" 		=> array(
                                esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                'type' 			=> 'textfield',
                'heading' 		=> esc_html__('Custom link', 'urna'),
                'param_name' 	=> 'link',
                'description' 	=> esc_html__('Add custom link.', 'urna'),
                "group" => esc_html__('Link Settings', 'urna'),
                'dependency' => array(
                    'element' 	=> 'add_link',
                    'value' 	=> 'yes',
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style', 'urna'),
                'description' => esc_html__('Select display style.', 'urna'),
                'param_name' => 'style',
                'value' => array(
                    esc_html__('None', 'urna') => 'none',
                    esc_html__('Button', 'urna') => 'button',
                    esc_html__('Icon', 'urna') => 'icon',
                ),
                "group" => esc_html__('Link Settings', 'urna'),
                'dependency' => array(
                    'element' 	=> 'add_link',
                    'value' 	=> 'yes',
                ),
                'std' => 'button',
                "admin_label" => true,
            ),
            array(
                'type' 			=> 'textfield',
                'heading' 		=> esc_html__('Text button', 'urna'),
                'param_name' 	=> 'text_button',
                "group" => esc_html__('Link Settings', 'urna'),
                'dependency' => array(
                    'element'=>'add_link',
                    'value'=>'yes',
                    'element'=>'style',
                    'value'=>'button',
                ),
                'std'  => esc_html__('Shop now', 'urna')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Icon library', 'urna'),
                'value' => array(
                    esc_html__('Linear Icons', 'urna') 	=> 'linearicons',
                    esc_html__('Font Awesome', 'urna') => 'fontawesome',
                    esc_html__('Simple Line', 'urna') 	=> 'simpleline',
                    esc_html__('Material', 'urna') 		=> 'material',
                ),
                'param_name' => 'type',
                "group" => esc_html__('Link Settings', 'urna'),
                'dependency' => array(
                        'element'=>'add_link',
                        'value'=>'yes',
                        'element'=>'style',
                        'value'=>'icon',
                ),
                'description' => esc_html__('Select icon library.', 'urna'),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust',
                "group" => esc_html__('Link Settings', 'urna'),
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                        'element'=>'add_link',
                        'value'=>'yes',
                        'element'=>'style',
                        'value'=>'icon',
                        'element'=>'type',
                        'value'=>'fontawesome',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_simpleline',
                'value' => 'icon-user',
                "group" => esc_html__('Link Settings', 'urna'),
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'simpleline',
                    'iconsPerPage' => 100,
                    // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element'=>'add_link',
                    'value'=>'yes',
                    'element'=>'style',
                    'value'=>'icon',
                    'element'=>'type',
                    'value'=>'simpleline',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_linearicons',
                'value' => 'linear-icon-plus',
                "group" => esc_html__('Link Settings', 'urna'),
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'linearicons',
                    'iconsPerPage' => 100,
                    // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element'=>'add_link',
                    'value'=>'yes',
                    'element'=>'style',
                    'value'=>'icon',
                    'element'=>'type',
                    'value'=>'linearicons',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__('Icon', 'urna'),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                "group" => esc_html__('Link Settings', 'urna'),
                // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'type' => 'material',
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element'=>'add_link',
                    'value'=>'yes',
                    'element'=>'style',
                    'value'=>'icon',
                    'element'=>'type',
                    'value'=>'material',
                ),
                'description' => esc_html__('Select icon from library.', 'urna'),
            )
        );

        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());
        $params = array_merge($params, $last_params);


        vc_map(array(
            "name" => esc_html__('Urna Banner', 'urna'),
            "base" => "tbay_banner",
            "icon" => "vc-icon-urna",
            "class" => "",
            "description"=> esc_html__('Show Text Images', 'urna'),
            "category" => esc_html__('Urna Elements', 'urna'),
            "params" => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_banner');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_banner extends WPBakeryShortCode
    {
    }
}
