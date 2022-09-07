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
    'background'=> urna_texttrim('#tbay-header .header-main, .topbar, #tbay-header .header-mainmenu')
);
$output['header_text_color'] 			= array('.top-contact .content,#tbay-header .top-wishlist .text,#tbay-header .cart-dropdown .text-cart');
$output['header_link_color'] 			= array('.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .tbay-custom-language .select-button, .menu-my-order-container a, .topbar a i, .tbay-login a span, .top-wishlist a, .cart-dropdown .cart-icon,.yith-compare-header i,.recent-view h3,.tbay-search-form .button-search.icon i, .tbay-custom-language .select-button:after,#tbay-header .navbar-nav > li > a,#tbay-header .navbar-nav .caret');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, .menu-my-order-container a:hover, .topbar a:hover i, .tbay-login a:hover span, .top-wishlist a:hover, .cart-dropdown:hover .cart-icon,.yith-compare-header i:hover,#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,.recent-view h3:hover,.tbay-custom-language .select-button:hover span,.tbay-search-form .button-search.icon i:hover,#tbay-header .navbar-nav .caret:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.top-contact .content');
$output['topbar_link_color'] 			= array('#tbay-header .social > li a, .tbay-custom-language .select-button:after, .tbay-custom-language .select-button, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after, .tbay-login > a,.topbar a i, .tbay-login a span');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, .menu-my-order-container a:hover, .topbar a:hover i, .tbay-login a:hover span,.tbay-custom-language .select-button:hover span'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a,#tbay-header .navbar-nav .caret');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover, #tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,#tbay-header .navbar-nav .caret:hover');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li, .tbay-footer .wpb_text_column p,.tbay-footer .text-black');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu.treeview li > a, .tbay-addon-social .social.style3 > li a,.tbay-footer .tbay-copyright .menu li a, .tbay-copyright .color');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu.treeview li > a:hover,.tbay-footer .menu.treeview li.active > a, #tbay-footer .menu li.active > a, .tbay-addon-social .social.style3 > li a:hover,.tbay-footer .tbay-copyright .menu li a:hover, .tbay-copyright .color:hover,.tbay-footer .tbay-copyright .menu li.active a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column,.tbay-footer .tbay-copyright .wpb_text_column p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright .menu li a, .tbay-copyright .color');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright .menu li a:hover,.tbay-footer .tbay-copyright .menu li.active a, .tbay-copyright .color:hover');

return apply_filters('urna_get_output', $output);
