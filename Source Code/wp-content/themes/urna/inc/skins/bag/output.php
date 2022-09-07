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
    'background'=> urna_texttrim('#tbay-header .sidebar-header-main')
);
$output['header_text_color'] 			= array('.top-newsletter .copyright, .top-newsletter .widget-title');
$output['header_link_color'] 			= array('#tbay-header .navbar-nav > li > a, .top-newsletter .copyright a');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.navbar-nav > li > a:hover:after, #tbay-header .navbar-nav > li > a:hover, #tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,.top-newsletter .copyright a:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a,.navbar-nav > li > a:after');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover:after,#tbay-header .navbar-nav > li > a:hover, #tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon-text-heading .subtitle, .contact-info li');
$output['footer_link_color'] 			= array('.tbay-footer .menu li > a, .social.style3 li a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .menu li > a:hover, .social.style3 li a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('')
);
$output['copyright_text_color'] 		= array('');
$output['copyright_link_color'] 		= array('');
$output['copyright_link_color_hover'] 	= array('');

return apply_filters('urna_get_output', $output);
