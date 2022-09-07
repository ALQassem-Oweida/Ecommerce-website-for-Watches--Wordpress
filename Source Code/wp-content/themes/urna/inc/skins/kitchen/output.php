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
    'background'=> urna_texttrim('.topbar, #tbay-header .header-main, #tbay-header .header-mainmenu')
);
$output['header_text_color'] 			= array('.top-contact .content,.text-black,.cart-dropdown .text-cart');
$output['header_link_color'] 			= array('#tbay-header #track-order a, #tbay-header .tbay-login >a,#tbay-header .tbay-custom-language .select-button, #tbay-header .tbay-custom-language .select-button:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i::after, .yith-compare-header a, .top-wishlist a, .cart-dropdown .cart-icon, .category-inside-title, .navbar-nav.megamenu>li>a, #tbay-header .recent-view h3, .flashsale-header a');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .tbay-login >a:hover, #tbay-header #track-order a:hover,#tbay-header .tbay-custom-language li:hover .select-button, #tbay-header .tbay-custom-language .select-button:hover, #tbay-header .tbay-custom-language li:hover .select-button:after, .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont:hover label i:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, .yith-compare-header a:hover, .top-wishlist a:hover, .cart-dropdown:hover .cart-icon, #tbay-header .category-inside-title:hover, #tbay-header .category-inside-title:focus, .navbar-nav.megamenu>li:focus>a, .navbar-nav.megamenu>li:hover>a, .navbar-nav.megamenu>li.active>a, #tbay-header .recent-view h3:hover,.flashsale-header a:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.top-contact .content,.text-black');
$output['topbar_link_color'] 			= array('#tbay-header #track-order a, #tbay-header .tbay-login >a, #tbay-header .tbay-custom-language .select-button, #tbay-header .tbay-custom-language .select-button:after, #tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, #tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i::after, #tbay-header .recent-view h3');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('#tbay-header .tbay-login >a:hover, #tbay-header #track-order a:hover, #tbay-header.tbay-custom-language li:hover .select-button, #tbay-header .tbay-custom-language .select-button:hover, #tbay-header .tbay-custom-language li:hover .select-button:after, #tbay-header .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont:hover label i:after, #tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, #tbay-header .recent-view h3:hover,#tbay-header .tbay-custom-language li:hover .select-button'),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav.megamenu > li > a, .navbar-nav.megamenu > li > a, .navbar-nav.megamenu > li > a');
$output['main_menu_link_color_active'] 	= array('.navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:focus > a, .navbar-nav.megamenu > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer, .tbay-footer .tbay-copyright')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title,.tbay-footer .tbay-copyright .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-addon .tbay-addon-title .subtitle, .contact-info li, .tbay-footer .vc_row:not(.tbay-copyright) .wpb_text_column p, .tbay-footer .tbay-copyright .wpb_text_column p,.copyright');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu li > a, .tbay-addon-social .social.style3 > li a,.tbay-copyright a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu li > a:hover, .tbay-footer ul.menu li.active > a, .tbay-addon-social .social.style3 > li a:hover, .tbay-copyright a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-copyright .wpb_text_column p');
$output['copyright_link_color'] 		= array('.tbay-copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-copyright a:hover');

return apply_filters('urna_get_output', $output);
