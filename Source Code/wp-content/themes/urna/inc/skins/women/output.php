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
$output['header_text_color'] 			= array('#tbay-header p');
$output['header_link_color'] 			= array('#tbay-header .navbar-nav > li > a, .search .btn-search-icon i,.tbay-login > a,.top-wishlist a,.cart-dropdown > a,.canvas-menu-sidebar > a ');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,.search:hover .btn-search-icon i,.tbay-login > a:hover,.top-wishlist a:hover,.cart-dropdown > a:hover,.canvas-menu-sidebar > a:hover'),
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
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon.tbay-addon-newsletter .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-copyright p,.tbay-footer p,.copyright');
$output['footer_link_color'] 			= array('#tbay-footer a,.tbay-footer .tbay-addon-social .style1 > li > a,.tbay-footer .tbay-addon.tbay-addon-newsletter .input-group-btn::after');
$output['footer_link_color_hover'] 		= array('#tbay-footer a:hover,.tbay-footer .tbay-addon-social .style1 > li > a:hover,.tbay-footer .tbay-addon-social .style1 > li:hover > a,.tbay-footer .tbay-addon-social .style1 > li.active > a,.tbay-footer .tbay-addon.tbay-addon-newsletter .input-group-btn:hover::after');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p,.copyright');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a,#tbay-footer .tbay-copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover,#tbay-footer .tbay-copyright a:hover');

return apply_filters('urna_get_output', $output);
