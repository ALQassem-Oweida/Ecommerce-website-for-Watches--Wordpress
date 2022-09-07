<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();


/*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .header-main, .tbay-homepage-demo #tbay-header .header-main')
);
$output['header_text_color'] 			= array('');
$output['header_link_color'] 			= array('.navbar-nav > li > a, .tbay-login > a,.top-cart .cart-icon,
.tbay-search-form .button-search.icon');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.navbar-nav.megamenu > li.active > a, .navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:focus > a,
	.tbay-login > a:hover,.top-cart .cart-icon:hover,.search .tbay-search-form .button-search.icon:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('')
);
$output['topbar_text_color'] 			= array('');
$output['topbar_link_color'] 			= array('');

$output['topbar_link_color_hover'] = array('');

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('.navbar-nav.megamenu > li.active > a, .navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:focus > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title,.tbay-footer .tbay-addon-newsletter.tbay-addon > h3');
$output['footer_text_color'] 			= array('.tbay-footer .contact-info li,.tbay-footer .tbay-copyright p,.tbay-footer .contact-info li > i,.footer .title-text-footer');
$output['footer_link_color'] 			= array('.tbay-footer .menu.treeview li > a, .tbay-footer .social.style3 li a,.tbay-footer .tbay-copyright .none-menu .menu li a,.tbay-footer a,.tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn input,.tbay-footer .link-footer');
$output['footer_link_color_hover'] 		= array('.tbay-footer .menu.treeview li > a:hover, .tbay-footer .social.style3 li a:hover,.tbay-footer .tbay-copyright .none-menu .menu li a:hover,.tbay-footer a:hover
,.tbay-footer .menu.treeview li:hover > a,.tbay-footer .social.style3 li:hover a,.tbay-footer .tbay-copyright .none-menu .menu li:hover a,.tbay-footer .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn input:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a,.tbay-footer .tbay-copyright .none-menu .menu li a,.tbay-footer .link-footer');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover,.tbay-footer .tbay-copyright .none-menu .menu li a:hover,.tbay-footer .tbay-copyright .none-menu .menu li:hover a');

return apply_filters('urna_get_output', $output);
