<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}
/**
 * Urna woocommerce Template Hooks
 *
 * Action/filter hooks used for Urna woocommerce functions/templates.
 *
 */


/**
 * Urna Header Mobile Content.
 *
 * @see urna_the_button_mobile_menu()
 * @see urna_the_logo_mobile()
 * @see urna_top_header_mobile()
 * @see urna_the_mini_cart_header_mobile()
 */
add_action('urna_header_mobile_content', 'urna_the_button_mobile_menu', 5);
add_action('urna_header_mobile_content', 'urna_the_logo_mobile', 10);
add_action('urna_header_mobile_content', 'urna_top_header_mobile', 15);


/**
 * Urna Header Mobile before content
 *
 * @see urna_the_hook_header_mobile_all_page
 */
add_action('urna_before_header_mobile', 'urna_the_hook_header_mobile_all_page', 5);
add_action('urna_before_header_mobile', 'urna_the_hook_header_mobile_menu_all_page', 10);

/**
 * Urna Footer Mobile Content.
 *
 * @see urna_the_icon_home_footer_mobile()
 * @see urna_the_icon_wishlist_footer_mobile()
 * @see urna_the_icon_order_footer_mobile()
 * @see urna_the_icon_account_footer_mobile()
 */
add_action('urna_footer_mobile_content', 'urna_the_icon_home_footer_mobile', 5);
add_action('urna_footer_mobile_content', 'urna_the_icon_wishlist_footer_mobile', 10);
add_action('urna_footer_mobile_content', 'urna_the_icon_order_footer_mobile', 15);
add_action('urna_footer_mobile_content', 'urna_the_icon_account_footer_mobile', 20);
