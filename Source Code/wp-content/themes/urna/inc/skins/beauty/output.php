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
$output['header_text_color'] 			= array('.top-contact');
$output['header_link_color'] 			= array('.widget_urna_socials_widget .social li a, #tbay-header .color, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after, #tbay-header .tbay-custom-language .select-button .native, #tbay-header #track-order a, #tbay-header .recent-view h3, .tbay-login a i,.category-inside-title,#tbay-header .navbar-nav.megamenu > li > a, #tbay-search-form-canvas.v2 button i, .top-wishlist a, .cart-dropdown .cart-icon, .cart-dropdown .text-cart,.yith-compare-header i, .tbay-custom-language .select-button:after');

$output['header_link_color_active'] = array(
    'color' => urna_texttrim('#tbay-header .widget_urna_socials_widget .social li a:hover ,#tbay-header .color:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, #tbay-header .tbay-custom-language .select-button .native:hover, .tbay-custom-language li:hover .select-button:after, #tbay-header #track-order a:hover, .category-inside-title:hover, .category-inside-title:focus, #tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a, #tbay-search-form-canvas.v2 button i:hover, .tbay-login a:hover i, .yith-compare-header i:hover, .top-wishlist i:hover, .cart-dropdown .cart-icon i:hover, #tbay-header .recent-view h3:hover'),
    'background-color' => urna_texttrim('#tbay-header .navbar-nav.megamenu > li > a:before'),
);

/*Custom Top Bar color*/
$output['topbar_bg'] 					= array(
    'background'=> urna_texttrim('.topbar')
);
$output['topbar_text_color'] 			= array('.top-contact');
$output['topbar_link_color'] 			= array('.widget_urna_socials_widget .social li a, #tbay-header .color, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont,.woocommerce-currency-switcher-form .SumoSelect > .CaptionCont > label i:after, #tbay-header .tbay-custom-language .select-button .native, #tbay-header #track-order a, #tbay-header .recent-view h3, .tbay-custom-language .select-button:after,#tbay-header .navbar-nav.megamenu > li > a');

$output['topbar_link_color_hover'] 		= array(
    'color' => urna_texttrim('#tbay-header .widget_urna_socials_widget .social li a:hover,#tbay-header .color:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover, .woocommerce-currency-switcher-form .SumoSelect > .CaptionCont:hover label i:after, .tbay-custom-language .select-button:hover,.tbay-custom-language .select-button:hover:after, #tbay-header .tbay-custom-language li:hover .select-button .native, .tbay-custom-language li:hover .select-button:after, #tbay-header #track-order a:hover, #tbay-header .recent-view h3:hover,#tbay-header #track-order a:before,#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a'),
    'background-color' => urna_texttrim(''),
);

/*Custom Main Menu*/
$output['main_menu_bg'] 				= array(
    'background'=> urna_texttrim('#tbay-header .tbay-mainmenu')
);
$output['main_menu_link_color'] 		= array('#tbay-header .navbar-nav.megamenu > li > a');
$output['main_menu_link_color_active'] 	= array(
    'color' => urna_texttrim('#tbay-header .navbar-nav.megamenu > li > a:hover,#tbay-header .navbar-nav.megamenu > li:hover > a,#tbay-header .navbar-nav.megamenu > li.active > a'),
    'background-color' => urna_texttrim('#tbay-header .navbar-nav.megamenu > li > a:before'),
);


/*Custom Footer*/
$output['footer_bg'] 					= array(
    'background'=> urna_texttrim('.tbay-footer')
);
$output['footer_heading_color'] 		= array('.tbay-footer .tbay-addon .tbay-addon-title');
$output['footer_text_color'] 			= array('.tbay-footer .tbay-addon .tbay-addon-title .subtitle, .contact-info li, .tbay-footer p,.text-black,.copyright');
$output['footer_link_color'] 			= array('.contact-info a, .tbay-footer .menu li > a, .tbay-addon-social .social.style3 > li a, .copyright a, .tbay-footer .tbay-copyright .menu li > a');
$output['footer_link_color_hover'] 		= array('.contact-info a:hover, .tbay-footer .menu li > a:hover, #tbay-footer .menu li.active > a, .tbay-addon-social .social.style3 > li a:hover, .copyright a:hover, .tbay-footer .tbay-copyright .menu li > a:hover');

/*Custom Copyright*/
$output['copyright_bg'] 				= array(
    'background'=> urna_texttrim('.tbay-footer .tbay-copyright')
);
$output['copyright_text_color'] 		= array('.tbay-copyright p');
$output['copyright_link_color'] 		= array('.copyright a, .tbay-footer .tbay-copyright .menu li > a');
$output['copyright_link_color_hover'] 	= array('.copyright a:hover, .tbay-footer .tbay-copyright .menu li > a:hover, .tbay-footer .tbay-copyright .menu li.active > a');


return apply_filters('urna_get_output', $output);
