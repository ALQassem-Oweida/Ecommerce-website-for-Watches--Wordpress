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
    'background'=> urna_texttrim('#tbay-header ,#tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header .top-contact .content,#tbay-header .top-contact .content .color-black');
$output['header_link_color'] 			= array('#tbay-header .canvas-menu-sidebar .btn-canvas-menu, .tbay-login >a, .top-wishlist a, .cart-dropdown .cart-icon, #tbay-search-form-canvas-v3 .search-open,#tbay-header .navbar-nav.megamenu > li > a');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .canvas-menu-sidebar .btn-canvas-menu:hover, .tbay-login >a:hover, .top-wishlist a:hover, .cart-dropdown .cart-icon:hover, #tbay-search-form-canvas-v3 .search-open:hover,#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .header-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav.megamenu > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .vc_row:not(.tbay-copyright) .wpb_text_column p, .tbay-footer .tbay-copyright .wpb_text_column,.text-black');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu.treeview li > a, .tbay-addon-social .social.style3 > li a, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:before,.tbay-footer a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu.treeview li > a:hover, .tbay-addon-social .social.style3 > li a:hover, .tbay-footer .tbay-copyright .tbay-addon-newsletter .input-group-btn:hover:before, .tbay-footer ul.menu li.active a,.tbay-footer a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column');
$output['copyright_link_color'] 		= array('.copyright a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover');


return apply_filters('urna_get_output', $output);
