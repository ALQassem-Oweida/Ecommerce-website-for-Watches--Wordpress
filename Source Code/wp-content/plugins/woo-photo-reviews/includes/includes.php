<?php
// no direct access allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
$plugin_url = plugins_url( 'woo-photo-reviews' );
//$plugin_url = plugins_url( '', __FILE__ );
$plugin_url = str_replace( '/includes', '', $plugin_url );
define( 'WOO_PHOTO_REVIEWS_ADMIN', WOO_PHOTO_REVIEWS_DIR . "admin" . DIRECTORY_SEPARATOR );
define( 'WOO_PHOTO_REVIEWS_FRONTEND', WOO_PHOTO_REVIEWS_DIR . "frontend" . DIRECTORY_SEPARATOR );
define( 'WOO_PHOTO_REVIEWS_TEMPLATES', WOO_PHOTO_REVIEWS_DIR . "templates" . DIRECTORY_SEPARATOR );
define( 'VI_WOO_PHOTO_REVIEWS_CSS', $plugin_url . "/css/" );
define( 'VI_WOO_PHOTO_REVIEWS_JS', $plugin_url . "/js/" );
define( 'VI_WOO_PHOTO_REVIEWS_IMAGES', $plugin_url . "/images/" );
require_once WOO_PHOTO_REVIEWS_INCLUDES . "data.php";
require_once WOO_PHOTO_REVIEWS_INCLUDES . "mobile_detect.php";
global $wcpr_detect;
$wcpr_detect = new VillaTheme_Mobile_Detect();
require_once WOO_PHOTO_REVIEWS_INCLUDES . "support.php";
require_once WOO_PHOTO_REVIEWS_INCLUDES . "functions.php";
vi_include_folder( WOO_PHOTO_REVIEWS_ADMIN, 'VI_WOO_PHOTO_REVIEWS_Admin_' );
vi_include_folder( WOO_PHOTO_REVIEWS_FRONTEND, 'VI_WOO_PHOTO_REVIEWS_Frontend_' );
