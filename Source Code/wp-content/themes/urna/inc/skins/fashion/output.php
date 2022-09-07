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
    'background'=> urna_texttrim('#tbay-header .header-main, .topbar')
);
$output['header_text_color'] 			= array('.top-contact .content,.text-black');

$output['header_link_color'] 			= array(
    'color' => urna_texttrim('#tbay-header .widget_urna_socials_widget .social li a, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after, .tbay-custom-language .select-button, .tbay-custom-language .select-button:after, #track-order a, #tbay-header .recent-view h3, #tbay-search-form-canvas.v4 button,#tbay-search-form-canvas.v4 button i, .tbay-login > a,.tbay-login > a span,.top-wishlist a, .tbay-mainmenu .navbar-nav.megamenu > li > a, .yith-compare-header i, .cart-dropdown .cart-icon,#tbay-header #track-order a,#tbay-header .tbay-login a span,#tbay-header .tbay-mainmenu .navbar-nav > li > a'),
    'background-color' => urna_texttrim(''),
);
$output['header_link_color_active'] = array(
    'color' => urna_texttrim('.widget_urna_socials_widget .social li a:hover i:before,#tbay-header .widget_urna_socials_widget .social li a:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover > label i:after, #tbay-search-form-canvas.v4 button:hover, #tbay-search-form-canvas.v4 button:hover i, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, .tbay-custom-language li:hover .select-button, .tbay-custom-language li:hover .select-button:after, #track-order a:hover, .tbay-login >a:hover, .tbay-login >a:hover span, .top-wishlist a:hover, .cart-dropdown:hover .cart-icon,.yith-compare-header i:hover,#tbay-header .recent-view h3:hover,.tbay-custom-language .select-button:hover span, #tbay-search-form-canvas.v4 button:hover, #tbay-search-form-canvas.v4 button:hover i,#tbay-header #track-order a:hover,#tbay-header .tbay-login a span:hover,#tbay-header #track-order a:before,#tbay-header .tbay-mainmenu .navbar-nav > li > a:hover,#tbay-header .tbay-mainmenu .navbar-nav > li:hover > a,#tbay-header .tbay-mainmenu .navbar-nav > li.active > a'),
    'background-color' => urna_texttrim('#tbay-header .tbay-mainmenu .navbar-nav > li > a:before'),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.top-contact .content,.text-black');
$output['topbar_link_color'] 			= array('#tbay-header .widget_urna_socials_widget .social li a, #tbay-header .color, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after, .tbay-custom-language .select-button .native, .tbay-custom-language .select-button:after,#tbay-header .recent-view h3,#tbay-header #track-order a');

$output['topbar_link_color_hover'] 		= array(
    'color' => urna_texttrim('#tbay-header .color:hover, #tbay-header .widget_urna_socials_widget .social li a:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, .tbay-custom-language li:hover .select-button .native, .tbay-custom-language li:hover .select-button:after, #track-order a:hover,.widget_urna_socials_widget .social li a:hover i:before,#tbay-header .recent-view h3:hover,#tbay-header #track-order a:before,#tbay-header #track-order a:hover'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('.navbar-nav.megamenu > li > a, .tbay-mainmenu .navbar-nav .dropdown-menu .tbay-addon ul:not(.entry-meta-list) li > a,.tbay-mainmenu a');
$output['main_menu_link_color_active'] 	= array(
    'color' => urna_texttrim('.navbar-nav.megamenu > li.active > a, .navbar-nav.megamenu > li:hover > a, .navbar-nav.megamenu > li:focus > a,.navbar-nav.megamenu > li > a:before, .navbar-nav.megamenu .dropdown-menu .tbay-addon ul:not(.entry-meta-list) li > a:hover,.tbay-mainmenu a:hover'),
    'background' => urna_texttrim('.tbay-mainmenu .navbar-nav.megamenu > li > a:before'),
);

/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .tbay-footer .wpb_text_column p, .copyright,.tbay-footer .text-black');
$output['footer_link_color'] 			= array('.tbay-footer .menu.treeview li > a,.tbay-addon-social .social.style3 > li a, .tbay-copyright .tbay-addon-newsletter .input-group-btn, .copyright a');
$output['footer_link_color_hover'] 		= array('.tbay-footer .menu.treeview li > a:hover,#tbay-footer .menu li.active > a, .tbay-addon-social .social.style3 > li a:hover,.tbay-copyright .tbay-addon-newsletter .input-group-btn:hover, .copyright a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-copyright')
);
$output['copyright_text_color'] 		= array('.copyright');
$output['copyright_link_color'] 		= array('.copyright a, .tbay-copyright .tbay-addon-newsletter .input-group-btn');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover, .tbay-copyright .tbay-addon-newsletter .input-group-btn:hover');


return apply_filters('urna_get_output', $output);
