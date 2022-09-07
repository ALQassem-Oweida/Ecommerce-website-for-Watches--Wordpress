<?php
/**
 * Plugin Name: Photo Reviews for WooCommerce
 * Plugin URI: https://villatheme.com/extensions/woocommerce-photo-reviews/
 * Description: Allow you to automatically send email to your customers to request reviews. Customers can include photos in their reviews.
 * Version: 1.2.2
 * Author: VillaTheme
 * Author URI: http://villatheme.com
 * Text Domain: woo-photo-reviews
 * Domain Path: /languages
 * Copyright 2018-2022 VillaTheme.com. All rights reserved.
 * Requires at least: 5.0
 * Tested up to: 6.0
 * WC requires at least:5.0
 * WC tested up to: 6.8
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'VI_WOO_PHOTO_REVIEWS_VERSION', '1.2.2' );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce-photo-reviews/woocommerce-photo-reviews.php' ) ) {
	return;
}
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	define( 'WOO_PHOTO_REVIEWS_DIR',  plugin_dir_path( __FILE__ ) );
	define( 'WOO_PHOTO_REVIEWS_INCLUDES', WOO_PHOTO_REVIEWS_DIR . "includes" . DIRECTORY_SEPARATOR );
	$init_file = WOO_PHOTO_REVIEWS_INCLUDES . "includes.php";
	require_once $init_file;
}

if ( ! class_exists( 'VI_Woo_Photo_Reviews' ) ) {
	class VI_Woo_Photo_Reviews {

		public function __construct() {
			add_filter(
				'plugin_action_links_woo-photo-reviews/woo-photo-reviews.php', array(
					$this,
					'settings_link'
				)
			);
			add_action( 'admin_notices', array( $this, 'notification' ) );
		}


		public function settings_link( $links ) {
		    $settings_link = sprintf('<a href="admin.php?page=woo-photo-reviews" title="%s">%s</a>',esc_html__( 'Settings', 'woo-photo-reviews' ),esc_html__( 'Settings', 'woo-photo-reviews' ));
			array_unshift( $links, $settings_link );

			return $links;
		}

		public function notification() {
			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				?>
                <div id="message" class="error">
                    <p><?php _e( 'Please install and activate WooCommerce to use Photo Reviews for WooCommerce.', 'woo-photo-reviews' ); ?></p>
                </div>
				<?php
			}
		}
	}
}

new VI_Woo_Photo_Reviews();