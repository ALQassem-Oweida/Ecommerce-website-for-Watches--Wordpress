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
    'background'=> urna_texttrim('#tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header p');
$output['header_link_color'] 			= array('.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label, .tbay-login >a, .top-wishlist a, .cart-dropdown .cart-icon, #tbay-search-form-canvas button, #tbay-header .navbar-nav > li > a, .canvas-menu-sidebar a');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span:hover, .tbay-login a:hover span, .tbay-login a:hover i, .SumoSelect>.optWrapper>.options>li.opt:hover, .top-wishlist a:hover, .cart-dropdown .cart-icon:hover, #tbay-search-form-canvas button:hover, .canvas-menu-sidebar a:hover, #tbay-header .navbar-nav > li > a:hover, #tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a'),
    'background-color' => urna_texttrim(''),
);


/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .header-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer, .tbay-footer .tbay-copyright')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title,.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .tbay-footer .vc_row:not(.tbay-copyright) .wpb_text_column p,.tbay-footer .tbay-copyright .wpb_text_column p,.copyright,.tbay-footer .vc_row:not(.tbay-copyright) .wpb_text_column p .color-white');
$output['footer_link_color'] 			= array('.tbay-footer ul.menu li > a, .tbay-addon-social .social.style3 li a, .copyright a, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:before');
$output['footer_link_color_hover'] 		= array('.tbay-footer ul.menu li > a:hover, .tbay-addon-social .social.style3 li a:hover, .copyright a:hover, .tbay-footer ul.menu li.active > a, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:hover:before');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column p,.copyright');
$output['copyright_link_color'] 		= array('.copyright a, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:before');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:hover:before');

return apply_filters('urna_get_output', $output);
