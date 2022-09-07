<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();
$output['topbar_bg'] = $output['topbar_text_color'] = $output['topbar_link_color'] = $output['topbar_link_color_hover'] = array();

//*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .menu-category-menu-image-container, #tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header p');
$output['header_link_color'] 			= array('#track-order a, .tbay-login .account-button, .topbar-right i, .tbay-custom-language .select-button, .tbay-custom-language .select-button:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont label i:after, .top-wishlist a, .cart-dropdown .cart-icon, .cart-dropdown .text-cart, .category-inside-title, .navbar-nav.megamenu>li>a, #tbay-header .recent-view h3,#tbay-header .tbay-search-form .button-search.icon,#tbay-header .btn-toggle-canvas');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.tbay-login .account-button:hover, #track-order a:hover, .topbar-right a:hover i, .tbay-custom-language li:hover .select-button, .tbay-custom-language .select-button:hover, .tbay-custom-language li:hover .select-button:after, .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont:hover label i:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, .top-wishlist a:hover, .cart-dropdown:hover .cart-icon, .cart-dropdown:hover .text-cart, #tbay-header .category-inside-title:hover, #tbay-header .category-inside-title:focus, .navbar-nav.megamenu>li:focus>a, .navbar-nav.megamenu>li:hover>a, .navbar-nav.megamenu>li.active>a, #tbay-header .recent-view h3:hover,#tbay-header .btn-toggle-canvas:hover')
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-offcanvas-main')
);
$output['main_menu_link_color'] 		= array('.offcanvas-head .btn-toggle-canvas, .tbay-offcanvas-main .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('.tbay-offcanvas-main .navbar-nav.megamenu > li.active > a, .tbay-offcanvas-main .navbar-nav > li:hover > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li,.copyright');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu li > a, .copyright a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu li > a:hover,.tbay-footer .menu li:hover > a,.tbay-footer .menu li.active > a, .copyright a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.copyright a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover');

return apply_filters('urna_get_output', $output);
