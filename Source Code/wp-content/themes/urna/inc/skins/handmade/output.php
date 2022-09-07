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

/*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .header-main, #tbay-header .header-mainmenu')
);
$output['header_text_color'] 			= array(
    'color' => urna_texttrim('#tbay-header .top-contact .content,.text-black'),
    'background-color' => urna_texttrim(''),
);
$output['header_link_color'] 			= array(
    'color' => urna_texttrim('.top-contact .content a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label, .tbay-login >a, .top-wishlist a, .cart-dropdown .cart-icon, .tbay-custom-language .select-button, .navbar-nav.megamenu > li > a, #track-order a, .tbay-search-form button i, .canvas-menu-sidebar a i,#tbay-search-form-canvas-v3 .search-open,#tbay-header .navbar-nav.megamenu > li > a'),
    'background-color' => urna_texttrim(''),
);

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.top-contact .content a:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .tbay-login a:hover span, .tbay-login a:hover i, .SumoSelect>.optWrapper>.options>li.opt:hover, .top-wishlist a:hover, .cart-dropdown .cart-icon:hover, .cart-dropdown .text-cart:hover, .tbay-custom-language .select-button:hover, .tbay-search-form button i:hover, .canvas-menu-sidebar a i:hover,.recent-view h3:hover,#tbay-header .tbay-search-form button i:hover,#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim(' #tbay-header .header-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav.megamenu > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav.megamenu > li > a:hover, #tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer, .tbay-footer .tbay-copyright')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .wpb_text_column p,.tbay-footer .text-black');
$output['footer_link_color'] 			= array('.copyright a,.contact-info a, .tbay-footer .menu li > a, .tbay-addon-social .social.style3 > li a, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:before');
$output['footer_link_color_hover'] 		= array('.copyright a:hover,.contact-info a:hover, .tbay-footer .menu li > a:hover, .tbay-addon-social .social.style3 > li a:hover, .tbay-addon-social .social.style3 li a:hover i, .tbay-footer ul.menu li.active > a, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:hover:before');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column p,.tbay-footer .text-black,.copyright');
$output['copyright_link_color'] 		= array('.copyright a, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:before');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:hover:before');

return apply_filters('urna_get_output', $output);
