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
$output['header_text_color'] 			= array(
    'color' => urna_texttrim('#tbay-header p')
);
$output['header_link_color'] 			= array(
    'color' => urna_texttrim('#tbay-search-form-canvas button, .tbay-login >a, .top-wishlist a, .cart-dropdown .cart-icon, .canvas-menu-sidebar >a,#tbay-header .navbar-nav.megamenu > li > a,#tbay-header .search .tbay-search-form .search-open i'),
    'background-color' => urna_texttrim(''),
);

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-search-form-canvas button:hover, .tbay-login >a:hover, .top-wishlist a:hover, .cart-dropdown .cart-icon:hover, .canvas-menu-sidebar >a:hover,#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a,#tbay-header .search .tbay-search-form .search-open i:hover'),
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
    'background'=> urna_texttrim('.tbay-footer, .tbay-footer .tbay-copyright')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .wpb_text_column, .copyright,.tbay-footer  p,.text-black');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu.treeview li > a, .tbay-addon-social .social.style3 > li a, .tbay-copyright a, .tbay-copyright .tbay-addon-newsletter .input-group-btn:before');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu.treeview li > a:hover, .tbay-addon-social .social.style3 > li a:hover, .tbay-copyright a:hover, .tbay-copyright .tbay-addon-newsletter .input-group-btn:hover:before, .tbay-footer ul.menu li.active a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('');
$output['copyright_link_color'] 		= array('.copyright a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover');

return apply_filters('urna_get_output', $output);
