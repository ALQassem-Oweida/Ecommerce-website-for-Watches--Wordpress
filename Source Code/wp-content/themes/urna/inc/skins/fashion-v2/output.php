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
    'background'=> urna_texttrim('#tbay-header .header-main, #tbay-header .topbar')
);
$output['header_text_color'] 			= array('.top-contact .content');
$output['header_link_color'] 			= array('#tbay-header .social li a, #tbay-search-form-canvas.v4 button i, .tbay-login >a, .top-wishlist a, .cart-dropdown > a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont >label i:after, #tbay-header .tbay-custom-language li .select-button, #tbay-header .tbay-custom-language .select-button:after,#tbay-header .recent-view h3,#tbay-header #track-order a,#tbay-header #tbay-search-form-canvas button i,#tbay-header form.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont,#tbay-header .navbar-nav > li > a');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .social li a:hover, #tbay-search-form-canvas.v4 button:hover i,.tbay-login > a:hover, .top-wishlist a:hover, .cart-dropdown > a:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover >label i:after, #tbay-header .tbay-custom-language .select-button:hover,#tbay-header .tbay-custom-language .select-button:hover:after,  .tbay-custom-language li:hover .select-button:after, #tbay-header .recent-view h3:hover,#tbay-header #track-order a:hover,#tbay-header form.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover,#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a,#tbay-header .navbar-nav > li.active > a,#tbay-header #tbay-search-form-canvas button i:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('#tbay-header .topbar')
);
$output['topbar_text_color'] 			= array('.top-contact .content');
$output['topbar_link_color'] 			= array('#tbay-header .social li a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont >label i:after, #tbay-header .tbay-custom-language li .select-button, #tbay-header .tbay-custom-language .select-button:after,#tbay-header .recent-view h3,#tbay-header #track-order a,#tbay-header form.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont');

$output['topbar_link_color_hover'] = array(
    'color' => urna_texttrim('#tbay-header .social li a:hover,  .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover >label i:after, #tbay-header .tbay-custom-language .select-button:hover,#tbay-header .tbay-custom-language .select-button:hover:after,  .tbay-custom-language li:hover .select-button:after, #tbay-header .recent-view h3:hover,#tbay-header #track-order a:hover,#tbay-header form.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav > li > a');
$output['main_menu_link_color_active'] 	= array('#tbay-header .navbar-nav > li > a:hover,#tbay-header .navbar-nav > li:hover > a, #tbay-header .navbar-nav > li.active > a');


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li, .tbay-footer .wpb_text_column p,.tbay-footer .text-black,.copyright');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu li > a, #tbay-footer .tbay-addon-social .social.style3 li a, .tbay-copyright .none-menu .menu li a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu li > a:hover, #tbay-footer .menu li.active > a, #tbay-footer .tbay-addon-social .social.style3 li a:hover,.tbay-copyright .none-menu .menu li a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-copyright .wpb_text_column, .copyright');
$output['copyright_link_color'] 		= array('.tbay-copyright .none-menu .menu li a,.copyright a');
$output['copyright_link_color_hover'] 	= array('.tbay-copyright .none-menu .menu li a:hover,.tbay-copyright .none-menu .menu li.active a,.copyright a:hover');

return apply_filters('urna_get_output', $output);
