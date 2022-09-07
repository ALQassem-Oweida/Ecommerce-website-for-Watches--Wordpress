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
    'background'=> urna_texttrim('#tbay-header .header-main,.header-mainmenu')
);
$output['header_text_color'] 			= array('#tbay-header p,#tbay-header .cart-dropdown .text-cart');
$output['header_link_color'] 			= array('#tbay-header #track-order a, #tbay-header .yith-compare-header a,#tbay-header .tbay-login > a,#tbay-header .cart-dropdown > a,#track-order a, .yith-compare-header a,.category-inside-title,.category-inside-title:focus,.category-inside-title:hover,.navbar-nav > li > a,.recent-view h3');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header #track-order a:hover, #tbay-header .yith-compare-header a:hover,#tbay-header .tbay-login > a:hover,#tbay-header .cart-dropdown > a:hover,#track-order a:hover, .yith-compare-header a:hover,.navbar-nav > li > a:hover,.navbar-nav > li > a:focus,.navbar-nav > li:hover > a,.navbar-nav > li.active > a,.recent-view:hover h3'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .header-mainmenu .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('.navbar-nav > li.active > a, .navbar-nav > li:hover > a, .navbar-nav > li:focus > a,.navbar-nav > li:focus > a:hover,.navbar-nav > li:focus > a:focus');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer,.tbay-footer .tbay-copyright')
);
$output['footer_heading_color'] 		= array('.tbay-addon .tbay-addon-title, .tbay-addon .tbay-addon-heading');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-copyright p,.tbay-footer p,.contact-info li,.text-black');
$output['footer_link_color'] 			= array('.tbay-footer .menu li > a,.tbay-footer a,.wpb_text_column a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .menu li > a:hover,.tbay-footer .menu li:hover > a,.tbay-footer .menu li.active > a,.tbay-footer a:hover,.tbay-footer a:focus, .wpb_text_column a:hover, .wpb_text_column a:focus');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a,.tbay-copyright .none-menu .menu li a,.tbay-footer .tbay-copyright .wpb_text_column a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover,.tbay-footer .tbay-copyright a:focus,.tbay-footer .tbay-copyright .wpb_text_column a:hover,.tbay-footer .tbay-copyright .wpb_text_column a:focus,.tbay-copyright .none-menu .menu li a:hover,.tbay-copyright .none-menu .menu li a:focus,.tbay-copyright .none-menu .menu li:hover a,.tbay-copyright .none-menu .menu li:focus a,.tbay-copyright .none-menu .menu li.active a');


return apply_filters('urna_get_output', $output);
