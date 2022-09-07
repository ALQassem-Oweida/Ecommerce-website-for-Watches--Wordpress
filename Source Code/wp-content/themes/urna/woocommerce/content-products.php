<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;


global $product, $woocommerce_loop;
    
// Store loop count we're currently on
if (empty($woocommerce_loop['loop'])) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid

if (!empty($columns)) {
    $woocommerce_loop['columns'] = $columns;
} elseif (empty($woocommerce_loop['columns'])) {
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
}

// Ensure visibility
if (! $product || ! $product->is_visible()) {
    return;
}

$show_des 				= isset($show_des) ? $show_des : false;
$countdown 				= isset($countdown) ? $countdown : false;
$flash_sales 			= isset($flash_sales) ? $flash_sales : false;
$end_date 				= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';


// Increase loop count

// Extra post classes
$classes = array();

$type = apply_filters('urna_woo_config_product_layout', 10, 2);

$inner = 'inner-'.$type;

?>
<div <?php wc_product_class($classes, $product); ?>>
	<?php $product_item = isset($product_item) ? $product_item : $inner; ?>
 	<?php wc_get_template('item-product/'.$product_item.'.php', array('show_des' => $show_des, 'countdown' => $countdown, 'countdown_title' => $countdown_title, 'flash_sales' => $flash_sales, 'end_date' => $end_date )); ?>
</div>
