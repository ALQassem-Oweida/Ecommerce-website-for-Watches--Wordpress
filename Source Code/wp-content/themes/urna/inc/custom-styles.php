<?php

//convert hex to rgb
if (!function_exists('urna_tbay_getbowtied_hex2rgb')) {
    function urna_tbay_getbowtied_hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);
        
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); // returns the rgb values separated by commas
        //return $rgb; // returns an array with the rgb values
    }
}


if (!function_exists('urna_tbay_color_lightens_darkens')) {
    /**
     * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
     * @param str $hex Colour as hexadecimal (with or without hash);
     * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
     * @return str Lightened/Darkend colour as hexadecimal (with hash);
     */
    function urna_tbay_color_lightens_darkens($hex, $percent)
    {
        
        // validate hex string
        if( empty($hex) ) return $hex;
        
        $hex = preg_replace('/[^0-9a-f]/i', '', $hex);
        $new_hex = '#';
        
        if (strlen($hex) < 6) {
            $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
        }
        
        // convert to decimal and change luminosity
        for ($i = 0; $i < 3; $i++) {
            $dec = hexdec(substr($hex, $i*2, 2));
            $dec = min(max(0, $dec + $dec * $percent), 255);
            $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
        }
        
        return $new_hex;
    }
}

if (!function_exists('urna_tbay_default_theme_primary_color')) {
    function urna_tbay_default_theme_primary_color()
    {
        $active_theme = urna_tbay_get_theme();

        $theme_variable = array();

        $theme_variable['bg_buy_now']                                      = '#ffae00';

        switch ($active_theme) {
            case 'furniture':
                $theme_variable['main_color'] 			                   = '#ca0815';
                $theme_variable['main_color_second'] 	                   = '#ff9c00';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'sportwear':
                $theme_variable['main_color'] 			                   = '#bd101b';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'technology-v1':
                $theme_variable['main_color'] 			                   = '#ffc000';
                $theme_variable['main_color_second'] 	                   = '#db0808';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'technology-v2':
                $theme_variable['main_color'] 			                   = '#666ee8';
                $theme_variable['main_color_second'] 	                   = '#ffd200';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'technology-v3':
                $theme_variable['main_color'] 			                   = '#ffd200';
                $theme_variable['main_color_second'] 	                   = '#e40101';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'minimal':
                $theme_variable['main_color']                              = '#bb0b0b';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'handmade':
                $theme_variable['main_color']                              = '#ff0000';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'interior':
                $theme_variable['main_color']                              = '#ff5301';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'fashion':
                $theme_variable['main_color'] 			                   = '#ff6c00';
                $theme_variable['main_color_second'] 	                   = '#db0808';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'fashion-v2':
                $theme_variable['main_color'] 			                   = '#e50100';
                $theme_variable['main_color_second'] 	                   = '#ff6c00';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'home-shop':
                $theme_variable['main_color'] = '#ff0000';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'home-landing':
                $theme_variable['main_color'] = '#ffc600';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'organic':
                $theme_variable['main_color'] 			                   = '#86bc44';
                $theme_variable['main_color_second'] 	                   = '#ff9600';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'jewelry':
                $theme_variable['main_color'] 			                   = '#151039';
                $theme_variable['main_color_second'] 	                   = '#ffae00';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'beauty':
                $theme_variable['main_color'] 			                   = '#f88573';
                $theme_variable['main_color_second'] 	                   = '#ff1818';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'book':
                $theme_variable['main_color'] 			                   = '#8e410e';
                $theme_variable['main_color_second'] 	                   = '#ffd800';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'kitchen':
                $theme_variable['main_color']                              = '#cd1218';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'fashion-v3':
                $theme_variable['main_color']                              = '#d02121';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'men':
                $theme_variable['main_color']                              = '#d02121';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'bike':
                $theme_variable['main_color']                              = '#ffcc00';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'marketplace-v1':
                $theme_variable['main_color'] 			                   = '#ffa200';
                $theme_variable['main_color_second'] 	                   = '#0a3040';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'watch':
                $theme_variable['main_color']                              = '#ff5562';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'marketplace-v2':
                $theme_variable['main_color'] 			                   = '#ca0815';
                $theme_variable['main_color_second'] 	                   = '#ffb503';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'women':
                $theme_variable['main_color']                              = '#d02121';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'auto-part':
                $theme_variable['main_color']                              = '#fcb913';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'shoe':
                $theme_variable['main_color']                              = '#f26725';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'toy':
                $theme_variable['main_color'] 			                   = '#ffd900';
                $theme_variable['main_color_second'] 	                   = '#004e98';
                $theme_variable['main_color_third'] 	                   = '#ca0815';
                $theme_variable['enable_main_color_second']                = true;
                $theme_variable['enable_main_color_third']                 = true;
                break;

            case 'glass':
                $theme_variable['main_color']                              = '#504ca2';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'pet':
                $theme_variable['main_color']                              = '#7a59ab';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;

            case 'bag':
                $theme_variable['main_color']                              = '#ff9c00';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;
            case 'sound':
                $theme_variable['main_color']                              = '#ca0815';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;
            case 'underwear':
                $theme_variable['main_color']                              = '#fcb1b1';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;
            case 'camera':
                $theme_variable['main_color']                              = '#ca0815';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;
            case 'kidfashion':
                $theme_variable['main_color']                              = '#e4508f';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;
            case 'wedding':
                $theme_variable['main_color']                              = '#cfb195';
                $theme_variable['enable_main_color_second']                = false;
                $theme_variable['enable_main_color_third']                 = false;
                break;
        }

        return apply_filters('urna_get_default_theme_color', $theme_variable);
    }
}

if (!function_exists('urna_tbay_default_theme_primary_fonts')) {
    function urna_tbay_default_theme_primary_fonts()
    {
        $active_theme = urna_tbay_get_theme();

        $theme_variable = array();

        switch ($active_theme) {
            case 'furniture':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'sportwear':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'technology-v1':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'technology-v2':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'technology-v3':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'minimal':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'handmade':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'interior':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'fashion':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'fashion-v2':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'home-shop':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'home-landing':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'organic':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'jewelry':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['secondary_font']                          = 'Playfair Display';
                $theme_variable['font_second_enable']                      = true;
                break;

            case 'beauty':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'book':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'kitchen':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'fashion-v3':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'men':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'bike':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'marketplace-v1':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'watch':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'marketplace-v2':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'women':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'auto-part':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'shoe':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'toy':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['secondary_font']                          = 'Fredoka One, cursive';
                $theme_variable['font_second_enable']                      = true;
                break;

            case 'glass':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;

            case 'pet':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['secondary_font']                          = 'Fredoka One, cursive';
                $theme_variable['font_second_enable']                      = true;
                break;

            case 'bag':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;
            case 'sound':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;
            case 'underwear':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['secondary_font']                          = 'Mr De Haviland, cursive';
                $theme_variable['font_second_enable']                      = true;
                break;
            case 'camera':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;
            case 'kidfashion':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['font_second_enable']                      = false;
                break;
            case 'wedding':
                $theme_variable['main_font']                               = 'Poppins, sans-serif';
                $theme_variable['secondary_font']                          = 'Great Vibes';
                $theme_variable['font_second_enable']                      = true;
                break;
        }

        return apply_filters('urna_get_default_theme_fonts', $theme_variable);
    }
}

if (!function_exists('urna_tbay_check_empty_customize')) {
    function urna_check_empty_customize($option, $default){
        if( !is_array( $option ) ) {
            if( !empty($option) && $option !== 'Array' ) {
                echo trim( $option );
            } else {
                echo trim( $default );
            }
        } else {
            if( !empty($option['background-color']) ) {
                echo trim( $option['background-color'] );
            } else {
                echo trim( $default );
            }
        } 
    }
}

if (!function_exists('urna_tbay_theme_primary_color')) {
    function urna_tbay_theme_primary_color()
    {
        $default                        = urna_tbay_default_theme_primary_color();

        $main_color                     = urna_tbay_get_config(('main_color'),$default['main_color']);

        if( $default['enable_main_color_second'] ) {
            $main_color_second              = urna_tbay_get_config(('main_color_second'),$default['main_color_second']);
        }

        if( $default['enable_main_color_third'] ) {
            $main_color_third               = urna_tbay_get_config(('main_color_third'),$default['enable_main_color_third']);
        }

        $bg_buy_now                     = urna_tbay_get_config( ('bg_buy_now' ), $default['bg_buy_now']);

        /*Theme Color*/
        ?>
        :root {
            --tb-theme-color: <?php urna_check_empty_customize( $main_color, $default['main_color'] ); ?>;
            --tb-theme-color-hover: <?php urna_check_empty_customize( urna_tbay_color_lightens_darkens($main_color, -0.05), urna_tbay_color_lightens_darkens($default['main_color'], -0.05) ); ?>;
            <?php if( $default['enable_main_color_second'] ): ?> 
                --tb-theme-color-second: <?php urna_check_empty_customize( $main_color_second, $default['main_color_second'] ); ?>;
            <?php endif; ?>
            <?php if( $default['enable_main_color_third'] ): ?> 
                --tb-theme-color-third: <?php urna_check_empty_customize( $main_color_third, $default['main_color_third'] ); ?>;
            <?php endif; ?>
            --tb-theme-bg-buy-now: <?php urna_check_empty_customize( $bg_buy_now, $default['bg_buy_now'] ) ?>;
            --tb-theme-bg-buy-now-hover: <?php urna_check_empty_customize( urna_tbay_color_lightens_darkens($bg_buy_now, -0.1), urna_tbay_color_lightens_darkens($default['bg_buy_now'], -0.1) ) ?>;  
        } 
        <?php
    }
}

if (!function_exists('urna_tbay_custom_styles')) {
    function urna_tbay_custom_styles()
    {
        ob_start();

        urna_tbay_theme_primary_color();

        $default_fonts              = urna_tbay_default_theme_primary_fonts();

        if (!defined('URNA_CORE_ACTIVED')) {
            ?>
            :root {
                --tb-text-primary-font: <?php echo trim($default_fonts['main_font']); ?>;
                <?php if ($default_fonts['font_second_enable']) : ?>
                    --tb-text-second-font: <?php echo trim($default_fonts['secondary_font']); ?>;
                <?php endif; ?>
            }  
            <?php
        }

        if (defined('URNA_CORE_ACTIVED')) {
            
            $logo_img_width             = urna_tbay_get_config('logo_img_width');
            $logo_padding               = urna_tbay_get_config('logo_padding');

            $logo_img_width_mobile      = urna_tbay_get_config('logo_img_width_mobile');
            $logo_mobile_padding        = urna_tbay_get_config('logo_mobile_padding');
            $sale_border_radius         = urna_tbay_get_config('sale_border_radius');
            $enable_custom_label_sale   = (bool) urna_tbay_get_config('enable_custom_label_sale', false);
            $line_height_sale           = urna_tbay_get_config('line_height_label_sale');
            $min_width_label_sale       = urna_tbay_get_config('min_width_label_sale');

            $custom_css             = urna_tbay_get_config('custom_css');
            $css_desktop            = urna_tbay_get_config('css_desktop');
            $css_tablet             = urna_tbay_get_config('css_tablet');
            $css_wide_mobile        = urna_tbay_get_config('css_wide_mobile');
            $css_mobile             = urna_tbay_get_config('css_mobile');

            $show_typography        = (bool) urna_tbay_get_config('show_typography', false);

            if ($show_typography) {
                $font_source            = urna_tbay_get_config('font_source');
                $primary_font           = urna_tbay_get_config('main_font')['font-family'];
                $main_google_font_face = urna_tbay_get_config('main_google_font_face');
                $main_custom_font_face = urna_tbay_get_config('main_custom_font_face');

                $second_font                    = urna_tbay_get_config('secondary_font')['font-family'];
                $secondary_google_font_face     = urna_tbay_get_config('secondary_google_font_face');
                $secondary_custom_font_face     = urna_tbay_get_config('secondary_custom_font_face');

                if ($font_source  == "2" && $main_google_font_face) {
                    $primary_font = $main_google_font_face;
                    $second_font = $secondary_google_font_face;
                } elseif ($font_source  == "3" && $main_custom_font_face) {
                    $primary_font = $main_custom_font_face;
                    $second_font = $secondary_custom_font_face;
                } ?>
                :root {
                    --tb-text-primary-font: <?php urna_check_empty_customize( $primary_font, $default_fonts['main_font'] ); ?>;

                    <?php if ($default_fonts['font_second_enable']) : ?>
                        --tb-text-second-font: <?php urna_check_empty_customize( $second_font, $default_fonts['secondary_font'] ); ?>;
                    <?php endif; ?>
                }  
                <?php
            } else {
                ?>
                :root { 
                    --tb-text-primary-font: <?php echo trim($default_fonts['main_font']); ?>;

                    <?php if ($default_fonts['font_second_enable']) : ?>
                        --tb-text-second-font: <?php echo trim($default_fonts['secondary_font']); ?>;
                    <?php endif; ?>
                }
                <?php
            }

            ?>

            <?php if ($logo_img_width != "") : ?>
            .site-header .logo img {
                max-width: <?php echo esc_html($logo_img_width); ?>px;
            } 
            <?php endif; ?>

            <?php if ($logo_padding != "") : ?>
            .site-header .logo img {

                <?php if (!empty($logo_padding['padding-top'])) : ?>
                    padding-top: <?php echo esc_html($logo_padding['padding-top']); ?>;
                <?php endif; ?>

                <?php if (!empty($logo_padding['padding-right'])) : ?>
                    padding-right: <?php echo esc_html($logo_padding['padding-right']); ?>;
                <?php endif; ?>
                
                <?php if (!empty($logo_padding['padding-bottom'])) : ?>
                    padding-bottom: <?php echo esc_html($logo_padding['padding-bottom']); ?>;
                <?php endif; ?>

                <?php if (!empty($logo_padding['padding-left'])) : ?>
                     padding-left: <?php echo esc_html($logo_padding['padding-left']); ?>;
                <?php endif; ?>

            }
            <?php endif; ?> 

            @media (max-width: 1199px) {

                <?php if ($logo_img_width_mobile != "") : ?>
                /* Limit logo image height for mobile according to mobile header height */
                .mobile-logo a img {
                    max-width: <?php echo esc_html($logo_img_width_mobile); ?>px;
                }     
                <?php endif; ?>       

                <?php if ($logo_mobile_padding != "") : ?>
                .mobile-logo a img {

                    <?php if (!empty($logo_mobile_padding['padding-top'])) : ?>
                        padding-top: <?php echo esc_html($logo_mobile_padding['padding-top']); ?>;
                    <?php endif; ?>

                    <?php if (!empty($logo_mobile_padding['padding-right'])) : ?>
                        padding-right: <?php echo esc_html($logo_mobile_padding['padding-right']); ?>;
                    <?php endif; ?>

                    <?php if (!empty($logo_mobile_padding['padding-bottom'])) : ?>
                        padding-bottom: <?php echo esc_html($logo_mobile_padding['padding-bottom']); ?>;
                    <?php endif; ?>

                    <?php if (!empty($logo_mobile_padding['padding-left'])) : ?>
                         padding-left: <?php echo esc_html($logo_mobile_padding['padding-left']); ?>;
                    <?php endif; ?>
                   
                }
                <?php endif; ?>

                <?php if ($enable_custom_label_sale) : ?>
                    .woocommerce .product .product-block span.onsale .saled,.woocommerce .product .product-block span.onsale .featured {
                        line-height: <?php echo esc_html($line_height_sale); ?>px;
                        min-width: <?php echo esc_html($min_width_label_sale); ?>px;
                    }
                    
                <?php endif; ?>
            }
            
            
            .woocommerce .product span.onsale > span,
            .image-mains span.onsale .saled, 
            .image-mains span.onsale .featured {
                
                <?php if (!empty($sale_border_radius['padding-top'])) : ?>
                    border-top-left-radius: <?php echo esc_html($sale_border_radius['padding-top']); ?>;
                    -webkit-border-top-left-radius: <?php echo esc_html($sale_border_radius['padding-top']); ?>;
                     -moz-border-top-left-radius: <?php echo esc_html($sale_border_radius['padding-top']); ?>;
                <?php endif; ?>

                <?php if (!empty($sale_border_radius['padding-right'])) : ?>
                    border-top-right-radius: <?php echo esc_html($sale_border_radius['padding-right']); ?>;
                     -webkit-border-top-right-radius: <?php echo esc_html($sale_border_radius['padding-right']); ?>;
                      -moz-border-top-right-radius: <?php echo esc_html($sale_border_radius['padding-right']); ?>;
                <?php endif; ?>

                <?php if (!empty($sale_border_radius['padding-bottom'])) : ?>
                    border-bottom-right-radius: <?php echo esc_html($sale_border_radius['padding-bottom']); ?>;
                     -webkit-border-bottom-right-radius: <?php echo esc_html($sale_border_radius['padding-bottom']); ?>;
                      -moz-border-bottom-right-radius: <?php echo esc_html($sale_border_radius['padding-bottom']); ?>;
                <?php endif; ?>

                <?php if (!empty($sale_border_radius['padding-left'])) : ?>
                    border-bottom-left-radius: <?php echo esc_html($sale_border_radius['padding-left']); ?>;
                     -webkit-border-bottom-left-radius: <?php echo esc_html($sale_border_radius['padding-left']); ?>;
                      -moz-border-bottom-left-radius: <?php echo esc_html($sale_border_radius['padding-left']); ?>;
                <?php endif; ?>

            }

            /* Custom CSS */
            <?php
            if ($custom_css != '') {
                echo trim($custom_css);
            }
            if ($css_desktop != '') {
                echo '@media (min-width: 1024px) { ' . ($css_desktop) . ' }';
            }
            if ($css_tablet != '') {
                echo '@media (min-width: 768px) and (max-width: 1023px) {' . ($css_tablet) . ' }';
            }
            if ($css_wide_mobile != '') {
                echo '@media (min-width: 481px) and (max-width: 767px) { ' . ($css_wide_mobile) . ' }';
            }
            if ($css_mobile != '') {
                echo '@media (max-width: 480px) { ' . ($css_mobile) . ' }';
            } 
        } ?>

	<?php
        $content = ob_get_clean();
        $content = str_replace(array("\r\n", "\r"), "\n", $content);
        $lines = explode("\n", $content);
        $new_lines = array();
        foreach ($lines as $i => $line) {
            if (!empty($line)) {
                $new_lines[] = trim($line);
            }
        }

        $custom_css = implode($new_lines);

        wp_enqueue_style('urna-style', URNA_THEME_DIR . '/style.css', array(), '1.0');

        wp_add_inline_style('urna-style', $custom_css);
    }
}

add_action('wp_enqueue_scripts', 'urna_tbay_custom_styles', 200);
