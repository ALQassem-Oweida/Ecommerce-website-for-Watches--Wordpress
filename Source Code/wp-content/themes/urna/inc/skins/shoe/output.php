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
$output['topbar_text_color'] 			= array('.topbar, .content');
$output['topbar_link_color'] 			= array('.topbar .content a, .tbay-login a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > span, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i::after');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('.top-contact .content a:hover, .tbay-login a:hover, .tbay-login .dropdown .account-menu ul li a:hover'),
    'background-color' => urna_texttrim('.top-contact .content a:after'),
);

/*Custom Header*/
$output['header_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .header-main')
);
$output['header_text_color'] 			= array('#tbay-header .header-main p');
$output['header_link_color'] 			= array('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a,#tbay-header .header-main .header-right .tbay-login > a,#tbay-header .header-main .header-right .top-cart .cart-icon,
.tbay-search-form .button-search.icon');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li.active > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a:hover,
	#tbay-header .header-main .header-right .tbay-login > a:hover,#tbay-header .header-main .header-right .top-cart .cart-icon:hover i'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .header-main .tbay-mainmenu .navbar-nav > li > a:hover,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .header-main .tbay-mainmenu .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon:not(.tbay-addon-newsletter) .tbay-addon-title,.tbay-footer .tbay-addon-newsletter.tbay-addon > h3');
$output['footer_text_color'] 			= array('.tbay-footer .content-ft p, .tbay-footer .contact-info li');
$output['footer_link_color'] 			= array('.tbay-footer .social.style3 li a,.tbay-footer a, .tbay-footer .menu li > a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .social.style3 li a:hover, .tbay-footer a:hover, .tbay-footer .menu li > a:hover, .tbay-footer .contact-info ul li a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-footer .tbay-copyright p');
$output['copyright_link_color'] 		= array('.tbay-footer .tbay-copyright a, .tbay-addon-newsletter.tbay-addon .input-group .input-group-btn:after');
$output['copyright_link_color_hover'] 	= array('.tbay-footer .tbay-copyright a:hover');

return apply_filters('urna_get_output', $output);
