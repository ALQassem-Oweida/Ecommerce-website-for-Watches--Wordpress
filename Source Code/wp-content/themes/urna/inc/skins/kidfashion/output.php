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


/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('');
$output['topbar_link_color'] 			= array('');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim(''),
    'background-color' => urna_texttrim(''),
);

/*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header .header-main p');
$output['header_link_color'] 			= array('#tbay-header .navbar-nav > li > a, #tbay-header .tbay-search-form .button-search.icon, #tbay-header .tbay-login > a i, #tbay-header .top-wishlist i, #tbay-header .cart-dropdown .cart-icon i');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a, #tbay-header .tbay-search-form .button-search.icon:hover, #tbay-header .tbay-login > a i:hover, #tbay-header .top-wishlist i:hover, #tbay-header .cart-dropdown .cart-icon i:hover'),
    'background-color' => urna_texttrim('.canvas-menu-sidebar > a i:hover, .navbar-nav > li.active > a:before, .navbar-nav > li:hover > a:before'),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array(
    'color' => urna_texttrim('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a, #tbay-header .tbay-search-form .button-search.icon:hover, #tbay-header .tbay-login > a i:hover, #tbay-header .top-wishlist i:hover, #tbay-header .cart-dropdown .cart-icon i:hover'),
    'background-color' => urna_texttrim('.canvas-menu-sidebar > a i:hover, .navbar-nav > li.active > a:before, .navbar-nav > li:hover > a:before'),
);


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer,.tbay-copyright')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title, .tbay-footer .tbay-addon .tbay-addon-heading');
$output['footer_text_color'] 			= array('.contact-info li .text-contact, .text-contact, .contact-info i,.contact-info li .text-black.text-black');
$output['footer_link_color'] 			= array('.tbay-footer .wpb_text_column a, .tbay-footer .menu li > a, .social.style3 li a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .wpb_text_column a:hover,.social.style3 li a:hover,.tbay-footer .menu li > a:hover,.tbay-footer .menu li:hover > a,.tbay-footer .menu li.active > a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-copyright .text-contact');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column a, .tbay-footer .tbay-copyright .menu li > a');
$output['copyright_link_color_hover'] 	= array('.tbay-copyright .menu.treeview li a:hover,.tbay-footer .tbay-copyright .wpb_text_column a:hover');



return apply_filters('urna_get_output', $output);
