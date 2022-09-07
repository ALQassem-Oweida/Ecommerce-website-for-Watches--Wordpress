<?php
/**
 * Urna Core Plugin
 *
 * A simple, truly extensible and fully responsive options framework
 * for WordPress themes and plugins. Developed with WordPress coding
 * standards and PHP best practices in mind.
 *
 * Plugin Name:     Urna Core
 * Plugin URI:      https://thembay.com/urna-core/
 * Description:     Urna Core. A plugin required to activate the functionality in the themes.
 * Author:          Team Thembay
 * Author URI:      https://thembay.com/
 * Version:         1.3.6
 * Text Domain:     urna-core
 * License:         GPL3+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:     languages
 */

define( 'URNA_CORE_VERSION', '1.3.6');
define( 'URNA_CORE_URL', plugin_dir_url( __FILE__ ) ); 
define( 'URNA_CORE_DIR', plugin_dir_path( __FILE__ ) );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once( URNA_CORE_DIR . 'plugin-update-checker/plugin-update-checker.php' );
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://bitbucket.org/devthembay/plugins/raw/master/update/urna-core/plugin.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'urna-core'
);

/**
 * Redux Framework
 *
 */
if ( !class_exists( 'ReduxFramework' ) && file_exists( URNA_CORE_DIR . 'libs/redux/redux-core/framework.php' ) ) { 
    require_once( URNA_CORE_DIR . 'libs/redux/redux-core/framework.php' );
    require_once( URNA_CORE_DIR . 'libs/loader.php' );
    define( 'URNA_CORE_ACTIVED', true );
} else {
	define( 'URNA_CORE_ACTIVED', true );
}

/**
 * Custom Post type
 *
 */
add_action( 'init', 'urna_core_register_post_types', 1 );

/**
 * functions
 *
 */
require URNA_CORE_DIR . 'functions.php';
require URNA_CORE_DIR . 'functions-preset.php';
/**
 * Widgets Core
 *
 */
require URNA_CORE_DIR . 'classes/class-urna-widgets.php';
add_action( 'widgets_init',  'urna_core_widget_init' );

require URNA_CORE_DIR . 'classes/class-urna-megamenu.php';
/**
 * Init
 *
 */
function urna_core_init() {
	$demo_mode = apply_filters( 'urna_core_register_demo_mode', false );
	if ( $demo_mode ) {
		urna_core_init_redux();
	}
	$enable_tax_fields = apply_filters( 'urna_core_enable_tax_fields', false );
	if ( $enable_tax_fields ) {
		if ( !class_exists( 'Taxonomy_MetaData_CMB2' ) ) {
			require_once URNA_CORE_DIR . 'libs/cmb2/taxonomy/Taxonomy_MetaData_CMB2.php';
		}
	}
}
add_action( 'init', 'urna_core_init', 100 );