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
$output['header_link_color'] 			= array('#tbay-header .navbar-nav > li > a, .header-right .search .btn-search-icon, .header-right .tbay-login > a, .header-right .top-cart .cart-icon');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .navbar-nav > li > a:hover, #tbay-header .navbar-nav > li:hover > a, #tbay-header .navbar-nav > li:focus > a, #tbay-header .navbar-nav > li.active > a, .header-right .search .btn-search-icon:hover, .header-right .tbay-login > a:hover, .header-right .top-cart .cart-icon:hover,#tbay-header .tbay-login > a:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-megamenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover, #tbay-header .navbar-nav > li:hover > a, #tbay-header .navbar-nav > li:focus > a, #tbay-header .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title,.tbay-footer .tbay-addon-newsletter.tbay-addon > h3');
$output['footer_text_color'] 			= array('.tbay-footer .contact-info li,.tbay-footer .tbay-copyright p,.tbay-footer .contact-info li > i,.footer .title-text-footer');
$output['footer_link_color'] 			= array('.tbay-footer .menu.treeview li > a, .tbay-footer .social.style3 li a,.tbay-footer .tbay-copyright .none-menu .menu li a,.tbay-footer a,.tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn input');
$output['footer_link_color_hover'] 		= array('.tbay-footer .menu.treeview li > a:hover, .tbay-footer .social.style3 li a:hover,.tbay-footer .tbay-copyright .none-menu .menu li a:hover,.tbay-footer a:hover, #tbay-footer .menu li.active > a
,.tbay-footer .menu.treeview li:hover > a,.tbay-footer .social.style3 li:hover a,.tbay-footer .tbay-copyright .none-menu .menu li:hover a,.tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn input:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a,.tbay-footer .tbay-copyright .none-menu .menu li a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover,.tbay-footer .tbay-copyright .none-menu .menu li a:hover,.tbay-footer .tbay-copyright .none-menu .menu li:hover a');


return apply_filters('urna_get_output', $output);
