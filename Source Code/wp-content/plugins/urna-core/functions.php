<?php
/**
 * functions for Urna Core
 *
 * @package    urna-core
 * @author     Team Thembays <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Urna Core
 */

if ( !function_exists('urna_core_register_widgets_theme') ) {
    function urna_core_register_widgets_theme() {
          
        $widgets = array(
                        'Urna_Widget_Twitter', 
                        'Urna_Widget_Facebook_Like_Box', 
                        'Urna_Widget_Banner_Image',
                        'Urna_Widget_Custom_Menu',
                        'Urna_Widget_List_Categories',
                        'Urna_Widget_Popular_Post',
                        'Urna_Widget_Popup_Newsletter',
                        'Urna_Widget_Posts',
                        'Urna_Widget_Recent_Comment',
                        'Urna_Widget_Recent_Post',
                        'Urna_Widget_Single_Image',
                        'Urna_Widget_Socials',
                        'Urna_Widget_Top_Rate',
                        'Urna_Widget_Featured_Video'
                    );

        if( defined( 'YITH_WCBR' ) && YITH_WCBR ) {
          array_push($widgets,'Urna_Widget_Yith_Brand_Images');
        }        

        if ( class_exists( 'WooCommerce' ) ) {
          array_push($widgets,'Urna_Widget_Woo_Carousel');
        }

        $widgets = apply_filters( 'urna_core_register_widgets_theme', $widgets);


        foreach ($widgets as $widget) {
            if(class_exists($widget)) {
                register_widget( $widget );
            }   
        }
                    
    }

    add_action( 'widgets_init', 'urna_core_register_widgets_theme', 30 );
}

if( ! function_exists( 'urna_core_register_post_types' ) ) {
    function urna_core_register_post_types() {

        $types = array(
            'header', 
            'footer', 
            'brand', 
            'testimonial', 
            'megamenu', 
            'customtab'
        );

        $post_types = apply_filters( 'urna_core_register_post_types', $types);
        if ( !empty($post_types) ) {
            foreach ($post_types as $post_type) {
                if ( file_exists( URNA_CORE_DIR . 'classes/post-types/'.$post_type.'.php' ) ) {
                    require URNA_CORE_DIR . 'classes/post-types/'.$post_type.'.php';
                }
            }
        }
    }
}

if( ! function_exists( 'urna_core_widget_init' ) ) {
    function urna_core_widget_init() {
    	$widgets = apply_filters( 'urna_core_register_widgets', array() );
    	if ( !empty($widgets) ) {
    		foreach ($widgets as $widget) {
    			if ( file_exists( URNA_CORE_DIR . 'classes/widgets/'.$widget.'.php' ) ) {
    				require URNA_CORE_DIR . 'classes/widgets/'.$widget.'.php';
    			}
    		}
    	}
    }
}

if( ! function_exists( 'urna_core_get_widget_locate' ) ) {
    function urna_core_get_widget_locate( $name, $plugin_dir = URNA_CORE_DIR ) {
    	$template = '';
    	
    	// Child theme
    	if ( ! $template && ! empty( $name ) && file_exists( get_stylesheet_directory() . "/widgets/{$name}" ) ) {
    		$template = get_stylesheet_directory() . "/widgets/{$name}";
    	}

    	// Original theme
    	if ( ! $template && ! empty( $name ) && file_exists( get_template_directory() . "/widgets/{$name}" ) ) {
    		$template = get_template_directory() . "/widgets/{$name}";
    	}

    	// Plugin
    	if ( ! $template && ! empty( $name ) && file_exists( $plugin_dir . "/templates/widgets/{$name}" ) ) {
    		$template = $plugin_dir . "/templates/widgets/{$name}";
    	}

    	// Nothing found
    	if ( empty( $template ) ) {
    		throw new Exception( "Template /templates/widgets/{$name} in plugin dir {$plugin_dir} not found." );
    	}

    	return $template;
    }
}

if( ! function_exists( 'urna_core_display_svg_image' ) ) {
    function urna_core_display_svg_image( $url, $class = '', $wrap_as_img = true, $attachment_id = null ) {
        if ( ! empty( $url ) && is_string( $url ) ) {

            // we try to inline svgs
            if ( substr( $url, - 4 ) === '.svg' ) {

                //first let's see if we have an attachment and inline it in the safest way - with readfile
                //include is a little dangerous because if one has short_open_tags active, the svg header that starts with <? will be seen as PHP code
                if ( ! empty( $attachment_id ) && false !== @readfile( get_attached_file( $attachment_id ) ) ) {
                    //all good
                } elseif ( false !== ( $svg_code = get_transient( md5( $url ) ) ) ) {
                    //now try to get the svg code from cache
                    echo $svg_code;
                } else {

                    //if not let's get the file contents using WP_Filesystem
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );

                    WP_Filesystem();

                    global $wp_filesystem;
                    
                    $svg_code = $wp_filesystem->get_contents( $url );

                    if ( ! empty( $svg_code ) ) {
                        set_transient( md5( $url ), $svg_code, 12 * HOUR_IN_SECONDS );

                        echo $svg_code;
                    }
                }

            } elseif ( $wrap_as_img ) {

                if ( ! empty( $class ) ) {
                    $class = ' class="' . $class . '"';
                }

                echo '<img src="' . $url . '"' . $class . ' alt="" />';

            } else {
                echo $url;
            }
        }
    }
}


if( ! function_exists( 'urna_core_get_file_contents' ) ) {
    function urna_core_get_file_contents($url, $use_include_path, $context) {
    	return @file_get_contents($url, false, $context);
    }
}


if( ! function_exists( 'urna_core_scrape_instagram' ) ) {
    function urna_core_scrape_instagram( $username ) {

      $username = trim( strtolower( $username ) );
        switch ( substr( $username, 0, 1 ) ) {
            case '#':
                $url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
                $transient_prefix = 'h';
                break;
            default:
                $url              = 'https://instagram.com/' . str_replace( '@', '', $username );
                $transient_prefix = 'u';
                break;
        }
        if ( false === ( $instagram = get_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {
            $remote = wp_remote_get( $url );
            if ( is_wp_error( $remote ) ) {
                return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'urna-core' ) );
            }
            if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
                return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'urna-core' ) );
            }
            $shards      = explode( 'window._sharedData = ', $remote['body'] );
            $insta_json  = explode( ';</script>', $shards[1] );
            $insta_array = json_decode( $insta_json[0], true );
            if ( ! $insta_array ) {
                return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'urna-core' ) );
            }
            if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
                $images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
            } elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
                $images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
            } else {
                return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'urna-core' ) );
            }
            if ( ! is_array( $images ) ) {
                return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'urna-core' ) );
            }
            $instagram = array();
            foreach ( $images as $image ) {
                if ( true === $image['node']['is_video'] ) {
                    $type = 'video';
                } else {
                    $type = 'image';
                }
                $caption = __( 'Instagram Image', 'urna-core' );
                if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
                    $caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
                }
                $instagram[] = array(
                    'description' => $caption,
                    'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
                    'time'        => $image['node']['taken_at_timestamp'],
                    'comments'    => $image['node']['edge_media_to_comment']['count'],
                    'likes'       => $image['node']['edge_liked_by']['count'],
                    'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
                    'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
                    'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][3]['src'] ),
                    'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
                    'type'        => $type,
                );
            } // End foreach().
            // do not set an empty transient - should help catch private or empty accounts.
            if ( ! empty( $instagram ) ) {
                $instagram = base64_encode( serialize( $instagram ) );
                set_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', MINUTE_IN_SECONDS * 15 ) );
            }
        }
        if ( ! empty( $instagram ) ) {
            return unserialize( base64_decode( $instagram ) );
        } else {
            return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'urna-core' ) );
        }
    }
}


if( ! function_exists( 'urna_core_instagram_wpiw_proxy' ) ) {
    function urna_core_instagram_wpiw_proxy() {
        return true;
    }
    add_filter('wpiw_proxy', 'urna_core_instagram_wpiw_proxy');
}


if( ! function_exists( 'urna_core_time_ago' ) ) {
    function urna_core_time_ago($distant_timestamp, $max_units = 3) {
        $i = 0;
        
        $time = time() - $distant_timestamp; // to get the time since that moment
        $tokens = array(
            31536000    => esc_html__('year', 'urna-core'),
            2592000     => esc_html__('month', 'urna-core'),
            604800      => esc_html__('week', 'urna-core'),
            86400       => esc_html__('day', 'urna-core'),
            3600        => esc_html__('hour', 'urna-core'),
            60          => esc_html__('minute', 'urna-core'),
            1           => esc_html__('second', 'urna-core')
        );

        $responses = array();
        while ($i < $max_units) {
            foreach ($tokens as $unit => $text) {
                if ($time < $unit) {
                    continue;
                }
                $i++;
                $numberOfUnits = floor($time / $unit);

                array_push($responses, $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? esc_html__( 's', 'urna-core' ) : ''));
                $time -= ($unit * $numberOfUnits);
                break;
            }
        }

        if (!empty($responses)) {
            return implode(', ', $responses) . esc_html__( ' ago', 'urna-core' );
        }

        return esc_html__('Just now', 'urna-core');
    }
}

if( ! function_exists( 'urna_core_images_only' ) ) {
    function urna_core_images_only( $media_item ) {
        if ( $media_item['type'] == 'image' )
            return true;
        return false;
    }
}

if( ! function_exists( 'urna_core_remove_image_srcset' ) ) {
    function urna_core_remove_image_srcset( $media_item ) {
        add_filter( 'wp_calculate_image_srcset', '__return_false' );
    }
    add_action( 'init', 'urna_core_remove_image_srcset', 10 );
}


if( ! function_exists( 'urna_core_product_add_metaboxes' ) ) {
    add_action( 'add_meta_boxes', 'urna_core_product_add_metaboxes', 50 );
    function urna_core_product_add_metaboxes() {

        if( function_exists( 'urna_size_guide_metabox_output' ) ) {
            //Add metaboxes size guide to product
            add_meta_box( 'woocommerce-product-size-guide-images', esc_html__( 'Product Size Guide (Only Variable product)', 'urna-core' ), 'urna_size_guide_metabox_output', 'product', 'side', 'low' );
        }       

        if( function_exists( 'urna_swatch_attribute_template' ) ) {
            add_meta_box( 'woocommerce-product-swatch-attribute', esc_html__( 'Swatch attribute to display', 'urna-core' ), 'urna_swatch_attribute_template', 'product', 'side' );    
        }    

        if( function_exists( 'urna_single_select_single_layout_template' ) ) {
            add_meta_box( 'woocommerce-product-single-layout', esc_html__( 'Select Single Product Layout', 'urna-core' ), 'urna_single_select_single_layout_template', 'product', 'side' );  
        }

    }
}

if ( !function_exists( 'urna_core_fix_customize_image_wvs_support' ) ) {
    function urna_core_fix_customize_image_wvs_support(){
        remove_filter( 'pre_update_option_woocommerce_thumbnail_image_width', 'wvs_clear_transient' );
        remove_filter( 'pre_update_option_woocommerce_thumbnail_cropping', 'wvs_clear_transient' );
    }
    add_action('admin_init', 'urna_core_fix_customize_image_wvs_support', 10);
}