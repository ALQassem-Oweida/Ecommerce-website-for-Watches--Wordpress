<?php

if ( !urna_vc_is_activated() ) {
    return;
}

/**
 * Include vc element
 */
if (!function_exists('urna_tbay_include_vc_element')) {
    function urna_tbay_include_vc_element()
    {
        $vc_elements_array = array(
            'tbay-title-heading',
            'tbay-gridposts',
            'tbay-brands',
            'tbay-socials-link',
            'tbay-newsletter',
            'tbay-video',
            'tbay-testimonials',
            'tbay-ourteam',
            'tbay-features',
            'tbay-banner',
            'tbay-custom-menu',
            'tbay-button',
        );

        $vc_elements = apply_filters('urna_vc_elements_array', $vc_elements_array);

        foreach ($vc_elements as $file) {
            $path =  	URNA_VISUALCOMPOSER .'/content/element/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }
}

urna_tbay_include_vc_element();
