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
    'color' => urna_texttrim('')
);
$output['header_link_color'] 			= array(
    'color' => urna_texttrim('#tbay-search-form-canvas button, .tbay-login >a, .top-wishlist a, .cart-dropdown .cart-icon, .canvas-menu-sidebar >a, #tbay-header .navbar-nav > li > a'),
    'background-color' => urna_texttrim(''),
);

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-search-form-canvas button:hover, .tbay-login >a:hover, .top-wishlist a:hover, .cart-dropdown .cart-icon:hover, .canvas-menu-sidebar >a:hover,#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-megamenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('body .tbay-footer')
);
$output['footer_heading_color'] 		= array('.footer .tbay-addon.tbay-addon-newsletter > h3');
$output['footer_text_color'] 			= array('.tbay-copyright p,.copyright');
$output['footer_link_color'] 			= array('.tbay-footer .tbay-addon-social .social.style1 > li > a,.footer .tbay-addon.tbay-addon-newsletter .input-group-btn:before, .tbay-copyright a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .tbay-addon-social .social.style1 > li > a:hover,.tbay-footer .tbay-addon-social .social.style1 > li > a:active,.footer .tbay-addon.tbay-addon-newsletter .input-group-btn:hover:before, .tbay-copyright a:hover, .tbay-footer ul.menu li.active a');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-copyright p,.copyright');
$output['copyright_link_color'] 		= array('.tbay-copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-copyright a:hover');

return apply_filters('urna_get_output', $output);
