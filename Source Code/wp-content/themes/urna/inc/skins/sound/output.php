<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();

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
$output['header_text_color'] 			= array('');
$output['header_link_color'] 			= array('.navbar-nav > li > a, #tbay-search-form-canvas button.btn-search-icon, .header-right .tbay-login > a, .top-cart .cart-dropdown > a, .canvas-menu-sidebar > a');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.navbar-nav > li:hover > a, .navbar-nav > li:hover > a, .navbar-nav > li:focus > a, .navbar-nav > li.active > a, #tbay-search-form-canvas button.btn-search-icon:hover, .header-right .tbay-login:hover > a, .top-cart .cart-dropdown:hover > a, .canvas-menu-sidebar:hover > a'),
    'background-color' => urna_texttrim('.navbar-nav > li > a:after'),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('.navbar-nav > li:hover > a, .navbar-nav > li:hover > a, .navbar-nav > li:focus > a, .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title, .tbay-footer .tbay-addon-newsletter.tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .tbay-footer .tbay-addon .tbay-addon-heading .subtitle, .contact-info li, .tbay-footer p');
$output['footer_link_color'] 			= array('.tbay-footer .menu li > a, .social.style3 li a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .menu li > a:hover, .social.style3 li a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column.wpb_content_element p, .tbay-footer .tbay-addon-newsletter.tbay-addon .tbay-addon-title');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover');


return apply_filters('urna_get_output', $output);
