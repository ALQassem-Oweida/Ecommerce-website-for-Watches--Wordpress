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
$output['header_text_color'] 			= array('#tbay-header .header-main p');
$output['header_link_color'] 			= array('.navbar-nav > li > a, .header-right .tbay-login > a, .top-wishlist i, .header-right .top-cart .cart-icon i, #tbay-search-form-canvas button');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.navbar-nav > li > a:hover, .navbar-nav > li > a:focus, .navbar-nav > li > a:active, .navbar-nav > li:hover > a, .navbar-nav > li:focus > a, .navbar-nav > li.active > a, .navbar-nav > li > a:hover, .navbar-nav > li > a:focus, .navbar-nav > li > a:active, .navbar-nav > li:hover > a, .navbar-nav > li:focus > a, .navbar-nav > li.active > a, .header-right .tbay-login > a:hover, .top-wishlist i:hover, .header-right .top-cart .cart-icon i:hover, #tbay-search-form-canvas button:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('.navbar-nav > li > a:hover, .navbar-nav > li > a:focus, .navbar-nav > li > a:active, .navbar-nav > li:hover > a, .navbar-nav > li:focus > a, .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title, .text-black, .tbay-footer .tbay-addon-newsletter.tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon.tbay-addon-text-heading .description, .contact-info li, .tbay-footer p');
$output['footer_link_color'] 			= array('.tbay-footer .menu li > a, .social.style3 li a, .tbay-footer .wpb_text_column a, .tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn:after');
$output['footer_link_color_hover'] 		= array('.tbay-footer .menu li > a:hover, .tbay-footer a:hover, .tbay-footer .social.style3 li a:hover, .tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn:hover:after');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p, .tbay-footer .tbay-addon-newsletter.tbay-addon .tbay-addon-title');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright .wpb_text_column a, .tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn:after');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright .wpb_text_column a:hover, .tbay-footer .tbay-copyright a:hover, .tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn:hover:after');

return apply_filters('urna_get_output', $output);
