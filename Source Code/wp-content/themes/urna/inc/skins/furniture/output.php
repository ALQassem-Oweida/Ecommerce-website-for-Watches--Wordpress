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
$output['header_text_color'] 			= array('.top-contact .content, .cart-dropdown .text-cart, .tbay-search-form .select-category.input-group-addon');
$output['header_link_color'] 			= array('#tbay-header .color,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .tbay-custom-language .select-button, .menu-my-order-container a, .topbar a i, .tbay-login > a, .top-wishlist a, .cart-dropdown .cart-icon,.yith-compare-header i,.navbar-nav > li > a,.recent-view h3,.tbay-search-form .button-search.icon i, .tbay-custom-language .select-button:after');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .color:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, .menu-my-order-container a:hover, .topbar a:hover i, .tbay-login >a:hover, .top-wishlist a:hover, .cart-dropdown:hover .cart-icon,.yith-compare-header i:hover,.navbar-nav > li > a:hover,.navbar-nav > li:hover > a,.navbar-nav > li.active > a,.recent-view h3:hover,.tbay-custom-language a:hover span,.tbay-search-form .button-search.icon i:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .topbar')
);
$output['topbar_text_color'] 			= array('#tbay-header .topbar p,#tbay-header .top-contact .content');
$output['topbar_link_color'] 			= array('.topbar .content a,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .tbay-custom-language .select-button, .menu-my-order-container a, .topbar a i, .tbay-login >a, .tbay-custom-language .select-button:after');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.topbar .content a:hover, .topbar a:hover > i, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, .menu-my-order-container a:hover, .topbar a:hover i, .tbay-login >a:hover, .tbay-custom-language a:hover span'),
    'background-color' => urna_texttrim(''), 
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .header-mainmenu .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav.megamenu > li > a,.recent-view h3');
$output['main_menu_link_color_active'] 	= array('.navbar-nav.megamenu > li.active > a,.recent-view h3:hover,.navbar-nav.megamenu > li:hover > a,.navbar-nav.megamenu > li > a:hover');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-addon .tbay-addon-title .subtitle, .contact-info li');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu li > a, .tbay-footer .tbay-addon-social .social > li a,.tbay-footer a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu li > a:hover, .tbay-footer .menu li.active > a, .tbay-footer .tbay-addon-social .social > li a:hover,.tbay-footer a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.copyright a,.tbay-footer .tbay-copyright .menu li a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover,.tbay-footer .tbay-copyright .menu li a:hover,.tbay-footer .tbay-copyright .menu li:hover a,.tbay-footer .tbay-copyright .menu li.active a');

return apply_filters('urna_get_output', $output);
