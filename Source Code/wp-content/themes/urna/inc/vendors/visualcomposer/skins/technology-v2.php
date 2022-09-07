<?php
if ( !urna_vc_is_activated() ) {
    return;
}

if (!function_exists('urna_tbay_load_private_woocommerce_element')) {
    function urna_tbay_load_private_woocommerce_element()
    {
        $att = array(
            "type"          => "checkbox",
            "heading"       => esc_html__('Show Short Description?', 'urna'),
            "description"   => esc_html__('Show/hidden Short Description', 'urna'),
            "param_name"    => "show_des",
            "value"         => array( esc_html__('Yes', 'urna') =>'yes' ),
            'std' => '',
            'weight' => 1,
        );
        vc_add_param('tbay_categoriestabs', $att);
        vc_add_param('tbay_products', $att);
        vc_add_param('tbay_productstabs', $att);
    }
}

add_action('vc_after_set_mode', 'urna_tbay_load_private_woocommerce_element', 98);
