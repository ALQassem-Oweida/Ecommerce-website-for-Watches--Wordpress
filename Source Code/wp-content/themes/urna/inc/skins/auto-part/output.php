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
    'background'=> urna_texttrim('#tbay-header,#tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header p');
$output['header_link_color'] 			= array('#tbay-header .navbar-nav>li>a, #tbay-header .tbay-custom-language .select-button, #tbay-header .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont, #tbay-header .tbay-login>a, #tbay-header .top-wishlist>a, #tbay-header .cart-dropdown>a, #tbay-header .track-order a, #tbay-header .recent-view h3,.tbay-custom-language .select-button:after,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .navbar-nav>li>a:hover,#tbay-header .navbar-nav>li:hover>a,#tbay-header .navbar-nav>li.active>a, #tbay-header .tbay-custom-language .select-button:hover,.tbay-custom-language li:hover .select-button:after, .tbay-custom-language .select-button:hover:after,#tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after,#tbay-header .tbay-login>a:hover, #tbay-header .top-wishlist>a:hover, #tbay-header .cart-dropdown>a:hover, #tbay-header .track-order a:hover, #tbay-header .recent-view h3:hover,#tbay-header .vertical-menu .category-inside-title,#tbay-header .vertical-menu .category-inside-title:hover,#tbay-header .vertical-menu .category-inside-title:focus'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav>li>a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav>li>a:hover,#tbay-header .navbar-nav>li.active>a,#tbay-header .navbar-nav>li:hover>a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title,.tbay-footer .tbay-addon.tbay-addon-newsletter > h3');
$output['footer_text_color'] 			= array('.contact-info li,.copyright,.tbay-footer .tbay-addon-newsletter.tbay-addon > h3 .subtitle');
$output['footer_link_color'] 			= array('.tbay-footer a,.tbay-footer .menu li > a,.tbay-copyright .none-menu .menu li a');
$output['footer_link_color_hover'] 		= array('.tbay-footer a:hover,.tbay-footer .menu li > a:hover,.tbay-footer .menu li:hover > a,.tbay-footer .menu li.active > a,.tbay-footer .menu li:focus > a,.tbay-copyright .none-menu .menu li a:hover,.tbay-copyright .none-menu .menu li:hover a,.tbay-copyright .none-menu .menu li.active a,.tbay-copyright .none-menu .menu li:focus a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p,.tbay-footer .tbay-copyright .copyright,.tbay-footer .tbay-copyright');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a,.tbay-copyright .none-menu .menu li a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover,.tbay-copyright .none-menu .menu li a:hover,.tbay-copyright .none-menu .menu li:hover a,.tbay-copyright .none-menu .menu li:focus a,.tbay-copyright .none-menu .menu li.active a');

return apply_filters('urna_get_output', $output);
