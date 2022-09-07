<?php
    $class_top_bar 	=  '';

    $always_display_logo 			= urna_tbay_get_config('always_display_logo', false);
    if (!$always_display_logo  && defined('URNA_WOOCOMMERCE_ACTIVED') && !urna_catalog_mode_active() && (is_product() || is_cart() || is_checkout())) {
        $class_top_bar .= ' active-home-icon';
    }
?>
<div class="topbar-device-mobile hidden-lg clearfix <?php echo esc_attr($class_top_bar); ?>">

	<?php
        /**
        * urna_before_header_mobile hook
        */
        do_action('urna_before_header_mobile');

        /**
        * Hook: urna_header_mobile_content.
        *
        * @hooked urna_the_button_mobile_menu - 5
        * @hooked urna_the_logo_mobile - 10
        * @hooked urna_the_title_page_mobile - 10
        * @hooked urna_top_header_mobile - 15
        */

        do_action('urna_header_mobile_content');

        /**
        * urna_after_header_mobile hook
        */
        do_action('urna_after_header_mobile');
    ?>
</div>