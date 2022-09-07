<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (! function_exists('wc_get_gallery_image_html')) {
    return;
}

$sidebar_configs  = urna_tbay_get_woocommerce_layout_configs();
$images_layout      = ( !empty($sidebar_configs['thumbnail']) ) ? $sidebar_configs['thumbnail'] : 'horizontal';


if (isset($images_layout)) {
    switch ($images_layout) {
        case 'carousel':
        case 'centered':
        case 'gallery':
        case 'stick':
            wc_get_template('single-product/images/product-image-'.$images_layout.'.php');
            break;
        
        default:
            wc_get_template('single-product/images/product-image.php');
            break;
    }
}
