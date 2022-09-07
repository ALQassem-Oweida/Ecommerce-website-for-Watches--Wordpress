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
$output['header_text_color'] 			= array('#tbay-header .cart-dropdown .text-cart');
$output['header_link_color'] 			= array('.category-inside-title, .tbay-login >a, .top-wishlist a, .cart-dropdown > a, .yith-compare-header a, .navbar-nav.megamenu > li > a, .navbar-nav .caret, #tbay-header .recent-view h3,#tbay-header .navbar-nav>li>a,#tbay-header .navbar-nav .caret');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.category-inside-title:hover, .tbay-login a:hover span, .tbay-login >a:hover, .top-wishlist a:hover, .cart-dropdown > a:hover, .yith-compare-header a:hover, .navbar-nav.megamenu > li.active > a, .navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:focus > a, .navbar-nav > li:hover > a .caret:before, .navbar-nav > li:focus > a .caret:before, .navbar-nav > li.active > a .caret:before, #tbay-header .recent-view h3:hover,#tbay-header .navbar-nav>li>a:hover,
	#tbay-header .navbar-nav>li>a:focus,#tbay-header .navbar-nav>li.active>a'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav.megamenu > li > a,#tbay-header .navbar-nav>li>a,#tbay-header .navbar-nav .caret');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav>li>a:hover,#tbay-header .navbar-nav>li>a:focus,#tbay-header .navbar-nav>li.active>a,.navbar-nav > li:hover > a .caret:before, .navbar-nav > li:focus > a .caret:before, .navbar-nav > li.active > a .caret:before');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li, .tbay-footer .wpb_text_column,.copyright');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu li > a, .tbay-addon-social .social.style3 > li a, .tbay-footer .tbay-copyright .none-menu li a, .copyright a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer ul.menu li > a:hover, .tbay-footer ul.menu li.active > a, .tbay-addon-social .social.style3 > li a:hover, .tbay-footer .tbay-copyright .none-menu li a:hover, .copyright a:hover,.tbay-footer .tbay-copyright .none-menu li.active a,#tbay-footer ul.menu li.active a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column,.copyright');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright .menu li a, .copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright .menu li a:hover, .copyright a:hover,.tbay-footer .tbay-copyright .none-menu li.active a');

return apply_filters('urna_get_output', $output);
