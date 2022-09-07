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
    'background'=> urna_texttrim('#tbay-header .header-main, #tbay-header .main-menu')
);
$output['header_text_color'] 			= array('#tbay-header .header-main p');
$output['header_link_color'] 			= array('#tbay-header .tbay-mainmenu .navbar-nav > li > a, .header-right .tbay-login > a,.header-right .top-cart .cart-icon, .top-wishlist a, .canvas-menu-sidebar a, .search .tbay-search-form .button-search.icon');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .tbay-mainmenu .navbar-nav > li > a:hover,#tbay-header .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .tbay-mainmenu .navbar-nav > li.active > a, .header-right .tbay-login:hover > a, .header-right .top-cart:hover i, .top-wishlist:hover a, .canvas-menu-sidebar:hover a, .search .tbay-search-form .button-search.icon:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .tbay-mainmenu .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .tbay-mainmenu .navbar-nav > li > a:hover, #tbay-header .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .tbay-mainmenu .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title, .tbay-footer .tbay-addon-newsletter.tbay-addon > h3');
$output['footer_text_color'] 			= array('.tbay-footer p,.tbay-footer .tbay-addon-newsletter .tbay-addon-title .subtitle,  .tbay-footer .content-ft p, .tbay-footer .contact-info li, .tbay-addon.tbay-addon-text-heading .subtitle');
$output['footer_link_color'] 			= array('.tbay-footer .social.style3 li a,.tbay-footer a, .tbay-footer .menu li > a, .tbay-footer .contact-info ul li a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .social.style3 li a:hover, .tbay-footer a:hover, .tbay-footer .menu li > a:hover, .tbay-footer .contact-info ul li a:hover,.tbay-footer .menu li.active > a,');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover');

return apply_filters('urna_get_output', $output);
