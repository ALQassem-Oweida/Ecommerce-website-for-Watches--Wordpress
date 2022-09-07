<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();



/*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header, #tbay-header .header-main, #tbay-header .header-mainmenu')
);
$output['header_text_color'] 			= array('.top-info span,.top-info, #tbay-header p,#tbay-header .cart-dropdown .text-cart,#tbay-header .text-cart .woocommerce-Price-amount');
$output['header_link_color'] 			= array('#track-order a, .tbay-login .account-button, .tbay-custom-language .select-button, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i::after, .yith-compare-header a, .top-wishlist a, .cart-dropdown .cart-icon, .cart-dropdown .text-cart, .category-inside-title, #tbay-header .navbar-nav > li > a, #tbay-header .recent-view h3');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.tbay-login .account-button:hover, #track-order a:hover,.tbay-custom-language li:hover .select-button, .tbay-custom-language .select-button:hover, .tbay-custom-language li:hover .select-button:after, .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont:hover label i:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, .yith-compare-header a:hover, .top-wishlist a:hover, .cart-dropdown:hover .cart-icon, .cart-dropdown:hover .text-cart, #tbay-header .category-inside-title:hover, #tbay-header .category-inside-title:focus, #tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a, #tbay-header .recent-view h3:hover')
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.top-info,.top-info span,.topbar p');
$output['topbar_link_color'] 			= array('#track-order a, .tbay-login .account-button, .tbay-custom-language .select-button, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i::after');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.tbay-login .account-button:hover, #track-order a:hover,.tbay-custom-language li:hover .select-button, .tbay-custom-language .select-button:hover, .tbay-custom-language li:hover .select-button:after, .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont:hover label i:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover')
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .header-mainmenu .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .tbay-footer .contact-info li, .copyright');
$output['footer_link_color'] 			= array('.tbay-footer .contact-info a, .tbay-footer .menu li > a, .copyright a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .contact-info a:hover, .tbay-footer .menu li > a:hover,.tbay-footer .menu li:hover > a,.tbay-footer .menu li.active > a, .copyright a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.copyright a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover');


return apply_filters('urna_get_output', $output);
