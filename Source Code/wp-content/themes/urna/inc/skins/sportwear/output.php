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
    'background'=> urna_texttrim('.topbar, #tbay-header .header-main, #tbay-header .header-mainmenu ')
);
$output['header_text_color'] 			= array(
    'color' => urna_texttrim('.top-contact .content, .topbar-right .top-info span,.cart-dropdown .text-cart'),
    'background-color' => urna_texttrim(''),
);
$output['header_link_color'] 			= array(
    'color' => urna_texttrim('.top-contact .content a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label, .tbay-login >a, .top-wishlist a, .cart-dropdown .cart-icon, #tbay-header .tbay-custom-language .select-button, .navbar-nav.megamenu > li > a, #track-order a, .tbay-custom-language .select-button:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after,#tbay-header .navbar-nav > li > a,#tbay-header .navbar-nav .caret'),
    'background-color' => urna_texttrim('.top-contact .content a:before'),
);

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.top-contact .content a:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .tbay-login >a:hover, .top-wishlist a:hover, .cart-dropdown:hover .cart-icon, #tbay-header .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, #track-order a:hover,#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,#tbay-header .navbar-nav > li.active > a .caret:before,#tbay-header .navbar-nav > li:hover > a .caret:before'),
    'background-color' => urna_texttrim('.top-contact .content a:hover:before'),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.top-contact .content, .topbar-right .top-info span');
$output['topbar_link_color'] 			= array(
    'color' => urna_texttrim('.top-contact .content a, #tbay-header #track-order a'),
    'background-color' => urna_texttrim('.top-contact .content a:before'),
);

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.top-contact .content a:hover, #tbay-header #track-order a:hover'),
    'background-color' => urna_texttrim('.top-contact .content a:hover:before'),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a,#tbay-header .navbar-nav .caret');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,#tbay-header .navbar-nav > li.active > a .caret:before,#tbay-header .navbar-nav > li:hover > a .caret:before');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer, .tbay-footer .tbay-copyright')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title, .tbay-footer .tbay-addon-features .ourservice-heading');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li, .tbay-footer .tbay-addon-features .description, .copyright');
$output['footer_link_color'] 			= array('.tbay-footer a, .tbay-footer .menu li > a');
$output['footer_link_color_hover'] 		= array('.copyright a:hover, .tbay-footer .menu li > a:hover, .tbay-footer .menu li.active a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.copyright a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover');

return apply_filters('urna_get_output', $output);
