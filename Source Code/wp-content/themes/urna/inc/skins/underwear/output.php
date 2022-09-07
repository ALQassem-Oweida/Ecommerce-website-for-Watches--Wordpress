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
$output['header_text_color'] 			= array('#tbay-header .header-main p');
$output['header_link_color'] 			= array('#tbay-header .navbar-nav > li > a,#tbay-header .tbay-login > a i,#tbay-header .top-wishlist i, #tbay-header .cart-dropdown .cart-icon i, #tbay-header .search i, #tbay-header .header-main .canvas-menu-sidebar i');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,#tbay-header .tbay-login > a i:hover,#tbay-header .top-wishlist i:hover, #tbay-header .cart-dropdown .cart-icon i:hover, #tbay-header .search i:hover, #tbay-header .header-main .canvas-menu-sidebar i:hover'),
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
    'background'=> urna_texttrim('#tbay-footer')
);
$output['footer_heading_color'] 		= array('');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-copyright p,.tbay-footer p');
$output['footer_link_color'] 			= array('.tbay-footer .tbay-addon-social .style1 > li > a, .tbay-footer .menu li > a, .tbay-copyright .wpb_text_column a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .tbay-addon-social .style1 > li > a:hover,.tbay-footer .tbay-addon-social .style1 > li:hover > a,.tbay-footer .tbay-addon-social .style1 > li.active > a,.tbay-footer .menu li > a:hover, .tbay-copyright .wpb_text_column a:hover,.tbay-footer .menu li.active > a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover');

return apply_filters('urna_get_output', $output);
