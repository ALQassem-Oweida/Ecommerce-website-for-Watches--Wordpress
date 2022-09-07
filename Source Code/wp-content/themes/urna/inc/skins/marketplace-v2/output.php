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
$output['header_text_color'] 			= array('.top-contact .content,#tbay-header p');
$output['header_link_color'] 			= array('#track-order a,#tbay-header .recent-view .urna-recent-viewed-products h3,#tbay-header .tbay-login>a, #tbay-header .tbay-custom-language a.select-button, #tbay-header .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont,.yith-compare-header a,.top-wishlist a,.cart-dropdown .cart-icon,.navbar-nav>li>a,.caret,.tbay-custom-language .select-button:after,.woocommerce-currency-switcher-form .SumoSelect>.CaptionCont>label i:after,.tbay-homepage-demo #tbay-header .category-inside-title');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after,#tbay-header .tbay-login >a:hover, #tbay-header .tbay-custom-language a.select-button:hover, .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, .tbay-custom-language .select-button:hover:after, .navbar-nav.megamenu > li.active > a, .navbar-nav.megamenu > li.active > a .caret, .navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:hover > a .caret,.navbar-nav.megamenu > li > a:hover, .navbar-nav.megamenu > li > a:hover .caret, .yith-compare-header a:hover, #track-order a:hover, #tbay-header .recent-view .urna-recent-viewed-products h3:hover,.top-wishlist a:hover,.cart-dropdown a:hover .cart-icon'),
    'background-color' => urna_texttrim(''),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.topbar p');
$output['topbar_link_color'] 			= array('#track-order a,#tbay-header .recent-view .urna-recent-viewed-products h3,#tbay-header .tbay-login>a, #tbay-header .tbay-custom-language a.select-button, #tbay-header .woocommerce-currency-switcher-form .SumoSelect>.CaptionCont,.tbay-custom-language .select-button:after,.woocommerce-currency-switcher-form .SumoSelect>.CaptionCont>label i:after');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('#tbay-header .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after,#tbay-header .tbay-login >a:hover, #tbay-header .tbay-custom-language a.select-button:hover, .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, .tbay-custom-language .select-button:hover:after, #track-order a:hover, #tbay-header .recent-view .urna-recent-viewed-products h3:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav.megamenu > li > a, .navbar-nav .caret');
$output['main_menu_link_color_active'] 	= array('.navbar-nav.megamenu > li.active > a, .navbar-nav.megamenu > li.active > a .caret, .navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:hover > a .caret,.navbar-nav.megamenu > li > a:hover, .navbar-nav.megamenu > li > a:hover .caret');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li, .copyright');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu li > a, .copyright a');
$output['footer_link_color_hover'] 		= array(
    'color' => urna_texttrim('.contact-info a:hover, .tbay-footer ul.menu li > a:hover, .copyright a:hover, .tbay-footer ul.menu li.active > a'),
    'background-color' => urna_texttrim('.tbay-footer .menu.treeview li > a:hover:before'),
);

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.copyright a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover');

return apply_filters('urna_get_output', $output);
