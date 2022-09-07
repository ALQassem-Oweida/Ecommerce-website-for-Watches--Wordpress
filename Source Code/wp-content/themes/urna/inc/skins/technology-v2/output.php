<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();


//*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header, #tbay-header .header-main, .topbar:before,#tbay-header .header-mainmenu')
);
$output['header_text_color'] 			= array('#tbay-header p,#tbay-header .top-cart .text-cart,#tbay-header .top-cart .text-cart .woocommerce-Price-amount');
$output['header_link_color'] 			= array('#track-order a, .tbay-login .account-button, .topbar-right i, .topbar .social a, .topbar .tbay-custom-language .select-button, .topbar .tbay-custom-language .select-button:after, .topbar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .topbar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont label i:after, .category-inside-title, .navbar-nav.megamenu>li>a, .recent-view h3,#tbay-header .yith-compare-header a, #tbay-header .cart-dropdown .cart-icon, #tbay-header .top-wishlist a,#tbay-header .tbay-search-form .button-search.icon');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.topbar .tbay-login .account-button:hover, #track-order a:hover,.topbar .social a:hover, .topbar-right a:hover i, .topbar  .tbay-custom-language li:hover .select-button, .topbar .tbay-custom-language .select-button:hover, .topbar .tbay-custom-language li:hover .select-button:after, .topbar .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont:hover label i:after, .topbar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, #tbay-header .yith-compare-header a:hover, #tbay-header .cart-dropdown .cart-icon:hover, #tbay-header .top-wishlist a:hover, #tbay-header .category-inside-title:hover, #tbay-header .category-inside-title:focus, #tbay-header .navbar-nav > li:hover > a, #tbay-header .navbar-nav > li:focus > a, #tbay-header .navbar-nav > li.active > a, .recent-view h3:hover,#tbay-header .tbay-search-form .button-search.icon:hover')
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar, .topbar:before')
);
$output['topbar_text_color'] 			= array('.topbar p');
$output['topbar_link_color'] 			= array('#track-order a, .tbay-login .account-button, .topbar-right i, .topbar a, .topbar .tbay-custom-language .select-button, .topbar .tbay-custom-language .select-button:after, .topbar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .topbar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont label i:after, .topbar .social a');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.topbar .tbay-login .account-button:hover, #track-order a:hover,.topbar a:hover, .topbar-right a:hover i, .topbar  .tbay-custom-language li:hover .select-button, .topbar .tbay-custom-language .select-button:hover, .topbar .tbay-custom-language li:hover .select-button:after, .topbar .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont:hover label i:after, .topbar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, .topbar .social a:hover')
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .header-mainmenu .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li.active > a,#tbay-header .navbar-nav > li:hover > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-addon .tbay-addon-title .subtitle, .contact-info li, .copyright');
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
