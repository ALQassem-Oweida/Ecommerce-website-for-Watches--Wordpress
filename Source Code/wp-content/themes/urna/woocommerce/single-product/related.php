<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if (! defined('ABSPATH')) {
    exit;
}

global $product, $woocommerce_loop;

if (empty($product) || ! $product->exists()) {
    return;
}

if (sizeof($related_products) == 0) {
    return;
}


if (isset($_GET['releated_columns'])) {
    $woocommerce_loop['columns'] = $_GET['releated_columns'];
} else {
    $woocommerce_loop['columns'] = urna_tbay_get_config('releated_product_columns', 4);
}

$columns_desktopsmall = 3;
$columns_tablet = 2;
$columns_mobile = 2;

$rows = apply_filters('urna_supermaket_woo_row_single_full', false, 2);
if ($rows) {
    $rows = 4;
    $woocommerce_loop['columns'] = 1;
    $columns_desktopsmall = 1;
    $columns_tablet = 1;
    $columns_mobile = 1;
} else {
    $rows = 1;
}

$show_product_releated = urna_tbay_get_config('enable_product_releated', true);

$heading = apply_filters('woocommerce_product_related_products_heading', esc_html__('Related products', 'urna'));
 
if ($related_products && $show_product_releated) : ?> 

	<div class="related products tbay-addon tbay-addon-products" id="product-related">
		<?php if ($heading) : ?>
			<h3 class="tbay-addon-title"><span><?php echo esc_html($heading); ?></span></h3>
		<?php endif; ?>
		<div class="tbay-addon-content woocommerce">
		<?php  wc_get_template('layout-products/carousel-related.php', array( 'loops'=>$related_products,'rows' => $rows, 'pagi_type' => 'yes', 'nav_type' => 'yes','columns'=>$woocommerce_loop['columns'],'screen_desktop'=>$woocommerce_loop['columns'],'screen_desktopsmall'=>$columns_desktopsmall,'screen_tablet'=>$columns_tablet,'screen_mobile'=>$columns_mobile )); ?>
		</div>
	</div>

<?php endif;

wp_reset_postdata();
