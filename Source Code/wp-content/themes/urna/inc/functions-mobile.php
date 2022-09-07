<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_button_mobile_menu')) {
    function urna_tbay_get_button_mobile_menu()
    {
        $output 	= '';
        $output 	.= '<a href="#tbay-mobile-menu-navbar" class="btn btn-sm">';
        $output  .= '<i class="linear-icon-menu"></i>';
        $output  .= '</a>';

        $output 	.= '<a href="#page" class="btn btn-sm">';
        $output  .= '<i class="linear-icon-cross"></i>';
        $output  .= '</a>';

        
        return apply_filters('urna_tbay_get_button_mobile_menu', '<div class="active-mobile">'. $output . '</div>', 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_button_mobile_menu')) {
    function urna_the_button_mobile_menu()
    {
        wp_enqueue_script('jquery-mmenu');
        $ouput = urna_tbay_get_button_mobile_menu();
        
        echo trim($ouput);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Logo Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_logo_mobile')) {
    function urna_tbay_get_logo_mobile()
    {
        $mobilelogo 			= urna_tbay_get_config('mobile-logo');
        $active_theme 			= urna_tbay_get_theme();

        $output 	= '<div class="mobile-logo">';
        if (isset($mobilelogo['url']) && !empty($mobilelogo['url'])) {
            $url    	= $mobilelogo['url'];
            $output 	.= '<a href="'. esc_url(home_url('/')) .'">';

            if (isset($mobilelogo['width']) && !empty($mobilelogo['width'])) {
                $output 		.= '<img class="logo-mobile-img" src="'. esc_url($url) .'" width="'. esc_attr($mobilelogo['width']) .'" height="'. esc_attr($mobilelogo['height']) .'" alt="'. get_bloginfo('name') .'">';
            } else {
                $output 		.= '<img class="logo-mobile-img" src="'. esc_url($url) .'" alt="'. get_bloginfo('name') .'">';
            }

                
            $output 		.= '</a>';
        } else {
            $output 		.= '<div class="logo-theme">';
            $output 	.= '<a href="'. esc_url(home_url('/')) .'">';
            $output 	.= '<img class="logo-mobile-img" src="'. esc_url_raw(URNA_IMAGES.'/'.$active_theme.'/mobile-logo.png') .'" alt="'. get_bloginfo('name') .'">';
            $output 	.= '</a>';
            $output 		.= '</div>';
        }
        $output 	.= '</div>';
        
        return apply_filters('urna_tbay_get_logo_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Logo Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_logo_mobile')) {
    function urna_the_logo_mobile()
    {
        $ouput = urna_tbay_get_logo_mobile();
        
        echo trim($ouput);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Mini cart mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_the_mini_cart_header_mobile')) {
    function urna_the_mini_cart_header_mobile()
    {
        global $woocommerce;
        $icon = urna_tbay_get_config('woo_mini_cart_icon', 'linear-icon-cart');
        $_id 	= urna_tbay_random_key();
        if (!defined('URNA_WOOCOMMERCE_ACTIVED') || urna_catalog_mode_active()) {
            return;
        } ?>

		<?php if (urna_tbay_get_config('woo_mini_cart_position', 'popup') !== 'no-popup') : ?>
        <div class="top-cart">
        	<?php urna_tbay_get_page_templates_parts('offcanvas-cart', 'right'); ?>
            <div class="tbay-topcart">
				<div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown dropdown">
					<a class="dropdown-toggle mini-cart v2" data-offcanvas="offcanvas-right" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#">
						<span class="cart-icon">
						<?php if (!empty($icon)) : ?>
							<i class="<?php echo esc_attr($icon); ?>"></i>
						
						<?php else: ?>
							<i class="linear-icon-cart"></i>
						<?php endif; ?>
							<span class="mini-cart-items">
							   <?php echo sprintf('%d', $woocommerce->cart->cart_contents_count); ?>
							</span>
						</span>
					</a>            
				</div>
			</div> 
		</div>
		<?php else : ?>
			<div class="top-cart">
				<div class="tbay-topcart">
					<div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown">
						<a class="mini-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
							<span class="cart-icon">
								<?php if (!empty($icon)) : ?>
									<i class="<?php echo esc_attr($icon); ?>"></i>
								
								<?php else: ?>
									<i class="linear-icon-cart"></i>
								<?php endif; ?>
								<span class="mini-cart-items">
									<?php echo sprintf('%d', $woocommerce->cart->cart_contents_count); ?>
								</span>
							</span>
						</a>   
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The search header mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_the_search_header_mobile')) {
    function urna_the_search_header_mobile()
    {
        $mobile_header_search 	= urna_tbay_get_config('mobile_header_search', false);

        if (!$mobile_header_search) {
            return;
        } ?>
			<div class="search-device">
				<a id="search-icon" class="search-icon" href="javascript:;"><?php echo apply_filters('urna_get_icon_search_mobile', '<i class="icon-magnifier icons"></i>', 2); ?></a>
				<?php urna_tbay_get_page_templates_parts('device/productsearchform', 'mobileheader'); ?>
			</div>

		<?php
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Top right header mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_top_header_mobile')) {
    function urna_top_header_mobile() { ?>
		<div class="top-right-mobile">
			<?php
                /**
                * Hook: urna_top_header_mobile.
                *
                * @hooked urna_the_mini_cart_header_mobile - 5
                * @hooked urna_the_search_header_mobile - 10
                */
                add_action('urna_top_header_mobile', 'urna_the_mini_cart_header_mobile', 5);
                add_action('urna_top_header_mobile', 'urna_the_search_header_mobile', 10);
                do_action('urna_top_header_mobile');
            ?>
		</div>
	<?php }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Back on Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_back_mobile')) {
    function urna_tbay_get_back_mobile()
    {
        $output 	= '<div class="topbar-mobile-history">';
        $output 	.= '<a href="javascript:history.back()">';
        $output  	.= apply_filters('urna_get_mobile_history_icon', '<i class="linear-icon-arrow-left"></i>', 2);
        $output  	.= '</a>';
        $output  	.= '</div>';
        
        return apply_filters('urna_tbay_get_back_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The icon Back On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_back_mobile')) {
    function urna_the_back_mobile()
    {
        $ouput = urna_tbay_get_back_mobile();
        
        echo trim($ouput);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Title Page Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_title_page_mobile')) {
    function urna_tbay_get_title_page_mobile()
    {
        $output = '';
        if (!class_exists('WooCommerce')) {
            return;
        }
        if (!is_product_category()) {
            $output 	.= '<div class="topbar-title">';
            $output  	.= apply_filters('urna_get_filter_title_mobile', 10, 2);
            $output  	.= '</div>';
        } else {
            $output  	.= apply_filters('urna_get_filter_title_mobile', 10, 2);
        }

        
        return apply_filters('urna_tbay_get_title_page_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The icon Back On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_title_page_mobile')) {
    function urna_the_title_page_mobile()
    {
        $ouput = urna_tbay_get_title_page_mobile();
        echo trim($ouput);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Home Page On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_icon_home_page_mobile')) {
    function urna_tbay_get_icon_home_page_mobile()
    {
        $output 	= '<div class="topbar-icon-home">';
        $output 	.= '<a href="'. esc_url(home_url('/')) .'">';
        $output  	.= apply_filters('urna_get_mobile_home_icon', '<i class="linear-icon-home3"></i>', 2);
        $output  	.= '</a>';
        $output  	.= '</div>';
        
        return apply_filters('urna_tbay_get_icon_home_page_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Home Page On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_icon_home_page_mobile')) {
    function urna_the_icon_home_page_mobile()
    {
        $ouput = urna_tbay_get_icon_home_page_mobile();
        
        echo trim($ouput);
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * The Hook Config Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_hook_header_mobile_all_page')) {
    function urna_the_hook_header_mobile_all_page()
    {
        $always_display_logo 			= urna_tbay_get_config('always_display_logo', false);
        
        if ($always_display_logo || urna_tbay_is_home_page()) {
            return;
        }

        remove_action('urna_header_mobile_content', 'urna_the_logo_mobile', 10);
        add_action('urna_header_mobile_content', 'urna_the_title_page_mobile', 10);

        if (defined('URNA_WOOCOMMERCE_ACTIVED') && !urna_catalog_mode_active() && (is_product() || is_cart() || is_checkout())) {
            add_action('urna_top_header_mobile', 'urna_the_icon_home_page_mobile', 15);
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Hook Menu Mobile All page Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_hook_header_mobile_menu_all_page')) {
    function urna_the_hook_header_mobile_menu_all_page()
    {
        $menu_mobile_all_page 	= urna_tbay_get_config('menu_mobile_all_page', false);
        
        if ($menu_mobile_all_page || urna_tbay_is_home_page()) {
            return;
        }
        remove_action('urna_header_mobile_content', 'urna_the_button_mobile_menu', 5);
        add_action('urna_header_mobile_content', 'urna_the_back_mobile', 5);
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Home Page On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_icon_home_footer_mobile')) {
    function urna_tbay_get_icon_home_footer_mobile()
    {
        $active = (is_front_page()) ? 'active' : '';

        $output	 = '<div class="device-home '. $active .' ">';
        $output  .= '<a href="'. esc_url(home_url('/')) .'" >';
        $output  .= apply_filters('urna_get_mobile_home_icon', '<i class="linear-icon-home3"></i>', 2);
        $output  .= '<span>'. esc_html__('Home', 'urna'). '</span>';
        $output  .='</a>';
        $output  .='</div>';
        
        return apply_filters('urna_tbay_get_icon_home_footer_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Home Page On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_icon_home_footer_mobile')) {
    function urna_the_icon_home_footer_mobile()
    {
        $ouput = urna_tbay_get_icon_home_footer_mobile();
        
        echo trim($ouput);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Wishlist On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_icon_wishlist_footer_mobile')) {
    function urna_tbay_get_icon_wishlist_footer_mobile()
    {
        $output = '';
        
        if (!class_exists('YITH_WCWL')) {
            return $output;
        }

        $wishlist_url 	= YITH_WCWL()->get_wishlist_url();
        $wishlist_count = YITH_WCWL()->count_products();

        $output	 .= '<div class="device-wishlist">';
        $output  .= '<a class="text-skin wishlist-icon" href="'. esc_url($wishlist_url) .'" >';
        $output  .= apply_filters('urna_get_mobile_wishlist_icon', '<i class="linear-icon-heart"></i>', 2);
        $output  .= '<span class="count count_wishlist">'. esc_html($wishlist_count) .'</span>';
        $output  .= '<span>'. esc_html__('Wishlist', 'urna'). '</span>';
        $output  .='</a>';
        $output  .='</div>';
        
        return apply_filters('urna_tbay_get_icon_wishlist_footer_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Wishlist On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_icon_wishlist_footer_mobile')) {
    function urna_the_icon_wishlist_footer_mobile()
    {
        $ouput = urna_tbay_get_icon_wishlist_footer_mobile();
        
        echo trim($ouput);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Order On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_icon_order_footer_mobile')) {
    function urna_tbay_get_icon_order_footer_mobile()
    {
        $enable_menu_order 	=  urna_tbay_get_config('mobile_footer_menu_order', true);

        $output = '';

        if (!$enable_menu_order || !defined('URNA_WOOCOMMERCE_ACTIVED') || urna_catalog_mode_active()) {
            return $output;
        }
        $title 	=  urna_tbay_get_config('mobile_footer_menu_order_title', esc_html__('Order', 'urna'));
        $icon 	=  urna_tbay_get_config('mobile_footer_menu_order_icon', 'linear-icon-pencil4');
        $url 	=  urna_tbay_get_config('mobile_footer_menu_order_page');
        
        if (!empty($url)) {
            $url = get_permalink($url);
        }


        $output	 .= '<div class="device-order">';
        $output  .= '<a class="mobile-order" href="'. esc_url($url) .'" >';
        $output  .= '<i class="'. esc_attr($icon) .'"></i>';
        $output  .= '<span>'. $title .'</span>';
        $output  .='</a>';
        $output  .='</div>';
        
        return apply_filters('urna_tbay_get_icon_order_footer_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Order On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_icon_order_footer_mobile')) {
    function urna_the_icon_order_footer_mobile()
    {
        $ouput = urna_tbay_get_icon_order_footer_mobile();
        
        echo trim($ouput);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Account On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_tbay_get_icon_account_footer_mobile')) {
    function urna_tbay_get_icon_account_footer_mobile()
    {
        $output = '';

        $show_login = urna_tbay_get_config('show_login', false);
        $show_login_popup 	= urna_tbay_get_config('show_login_popup', true);
        $mobile_footer_account 	=  urna_tbay_get_config('mobile_footer_account', true);

        if (!defined('URNA_WOOCOMMERCE_ACTIVED') || urna_catalog_mode_active() || !$show_login) {
            return $output;
        }

        $icon_text 	= apply_filters('urna_get_mobile_user_icon', '<i class="linear-icon-user"></i>', 2);
        $icon_text .= '<span>'.esc_html__('Account', 'urna').'</span>';

        $active 	= (is_account_page()) ? 'active' : '';

        $output	 .= '<div class="device-account '. esc_attr($active) .'">';

        if (is_user_logged_in() || !$show_login_popup || !$mobile_footer_account) {
            $url_login = apply_filters('urna_woocommerce_my_account_url', get_permalink(wc_get_page_id('myaccount')));
            $output .= '<a class="logged-in" href="'. esc_url($url_login) .'"  title="'. esc_attr__('Login', 'urna') .'">';
        } else {
            $output .= '<a class="popup-login" href="javascript:void(0);"  title="'. esc_attr__('Login', 'urna') .'">';
        }

        $output .= $icon_text;
        $output .= '</a>';

        $output  .='</div>';
        
        return apply_filters('urna_tbay_get_icon_account_footer_mobile', $output, 10);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Account On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_icon_account_footer_mobile')) {
    function urna_the_icon_account_footer_mobile()
    {
        $ouput = urna_tbay_get_icon_account_footer_mobile();
        
        echo trim($ouput);
    }
}
