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
    'background'=> urna_texttrim('#tbay-header, #tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header .cart-dropdown .subtotal .woocommerce-Price-amount,#tbay-header p');
$output['header_link_color'] 			= array('#tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span,#tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label, #tbay-header .tbay-login >a,#tbay-header .top-wishlist a,#tbay-header .cart-dropdown .cart-icon i,#tbay-header .tbay-custom-language .select-button, #tbay-header .category-inside-title, .navbar-nav.megamenu > li > a, #tbay-header #track-order a,#tbay-header .recent-view h3');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover > span, #tbay-header .tbay-login >a:hover,#tbay-header .top-wishlist a:hover,#tbay-header .cart-dropdown:hover .cart-icon i,#tbay-header .tbay-custom-language .select-button:hover,#tbay-header .tbay-custom-language li:hover .select-button,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header #track-order a:hover,#tbay-header .recent-view h3:hover,#tbay-header .navbar-nav.megamenu > li.active > a,#tbay-header .category-inside-title:hover,#tbay-header .category-inside-title:focus,.recent-view h3:hover:after'),
    'background-color' => urna_texttrim(''),
);


/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav.megamenu > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li, .copyright');
$output['footer_link_color'] 			= array('.tbay-footer .menu li > a, .copyright a,.contact-info li a');
$output['footer_link_color_hover'] 		= array(
    'color' => urna_texttrim('.contact-info li a:hover, .tbay-footer ul.menu li > a:hover, .copyright a:hover, .tbay-footer ul.menu li.active > a'),
    'background-color' => urna_texttrim('.tbay-footer .menu.treeview li > a:hover:before'),
);

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.tbay-copyright .none-menu .menu li a, .copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-copyright .none-menu .menu li a:hover, .copyright a:hover');

return apply_filters('urna_get_output', $output);
