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
    'background'=> urna_texttrim('#tbay-header .header-main,.top-bar')
);
$output['header_text_color'] 			= array('#tbay-header .header-main p,.top-contact span,.top-contact,#tbay-header .tbay-custom-language .select-button,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span');
$output['header_link_color'] 			= array('.track-order a,.track-order a,.cart-dropdown > a, .tbay-login > a,#tbay-header .top-wishlist .wishlist-icon,#tbay-header .navbar-nav > li > a');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.top-bar .track-order a:hover,.top-bar .track-order a:focus,.top-bar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after,#tbay-header .top-wishlist .wishlist-icon:hover,#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a'),
    'background-color' => urna_texttrim(''),
);

/*Custom Top Bar color*/

$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .top-bar')
);
$output['topbar_text_color'] 			= array('.top-contact span,.topbar p,.top-bar .top-contact,#tbay-header .tbay-custom-language .select-button, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span');
$output['topbar_link_color'] 			= array('.tbay-custom-language .select-button,.tbay-custom-language .select-button::after,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after,.track-order a,#tbay-header .top-wishlist .wishlist-icon, #tbay-header .top-wishlist .wishlist');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.top-bar .tbay-custom-language li:hover .select-button,.top-bar .tbay-custom-language li:hover .select-button:after,.top-bar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover,.top-bar .track-order a:hover,.top-bar .track-order a:focus,.top-bar .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after,#tbay-header .top-wishlist .wishlist-icon:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon.tbay-addon-newsletter .tbay-addon-title,.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title,.text-white');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-copyright p,.tbay-footer p,.tbay-footer .contact-info li');
$output['footer_link_color'] 			= array('.tbay-footer .menu li > a,.tbay-footer a,.tbay-copyright .wpb_text_column a,#tbay-footer .contact-info li a');
$output['footer_link_color_hover'] 		= array('#tbay-footer .menu li > a:hover,#tbay-footer .menu li:hover > a,#tbay-footer .menu li > a:focus,#tbay-footer .menu li.active > a,#tbay-footer a:hover,#tbay-footer .contact-info li a:hover,.tbay-copyright .wpb_text_column a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a');
$output['copyright_link_color_hover'] 	= array('#tbay-footer .tbay-copyright a:hover');

return apply_filters('urna_get_output', $output);
