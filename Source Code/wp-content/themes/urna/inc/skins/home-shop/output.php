<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}


/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();


/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.topbar, .content');
$output['topbar_link_color'] 			= array('.topbar .content a, .tbay-login a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i::after');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.top-contact .content a:hover, .tbay-login a:hover, .tbay-login .dropdown .account-menu ul li a:hover'),
    'background-color' => urna_texttrim('.top-contact .content a:after'),
);

/*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header')
);
$output['header_text_color'] 			= array('.tbay-search-form .select-category .SelectBox span, .top-contact .content, .top-info > .widget, .SumoSelect>.optWrapper>.options>li.opt:first-child');
$output['header_link_color'] 			= array('.top-contact .content a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label, .tbay-login a span, .tbay-login a i, .SumoSelect>.optWrapper>.options>li.opt, .top-wishlist a, .cart-dropdown .cart-icon, .cart-dropdown .text-cart');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.top-contact .content a:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, .tbay-login a:hover span, .tbay-login a:hover i, .SumoSelect>.optWrapper>.options>li.opt:hover, .top-wishlist a:hover, .cart-dropdown .cart-icon:hover, .cart-dropdown .text-cart:hover'),
    'background-color' => urna_texttrim('.top-contact .content a:after'),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .header-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav.megamenu > li > a, #track-order a');
$output['main_menu_link_color_active'] 	= array('.navbar-nav.megamenu > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-addon .tbay-addon-title .subtitle, .contact-info li');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu.treeview li > a, .tbay-addon-social .social > li a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu.treeview li > a:hover, .tbay-addon-social .social > li a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.copyright a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover');

return apply_filters('urna_get_output', $output);
