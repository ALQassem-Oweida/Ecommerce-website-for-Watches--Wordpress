<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (! empty($product_tabs)) : ?>
	<div class="tabs-sidebar"></div>

	<div class="woocommerce-tabs-mobile clearfix">
		<ul class="tabs-mobile" role="tablist">
			<?php foreach ($product_tabs as $key => $product_tab) : ?>
				<li class="<?php echo esc_attr($key); ?>_tab" id="tbay-wc-tab-<?php echo esc_attr($key); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
					<a data-tabid="tab-<?php echo esc_attr($key); ?>" href="#tab-<?php echo esc_attr($key); ?>"><?php echo apply_filters('woocommerce_product_' . esc_html($key) . '_tab_title', esc_html($product_tab['title']), $key); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ($product_tabs as $key => $product_tab) : ?>
			<div class="wc-tab-mobile" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
				<div class="tab-head">
					<?php if (isset($product_tab['title'])) : ?>
						<div class="title"><?php echo trim($product_tab['title']); ?></div>
					<?php endif; ?>

					<a class="close-tab" href="#"><i class="linear-icon-cross2"></i></a>
				</div>
				<div class="tab-content">
					<?php if (isset($product_tab['callback'])) {
    call_user_func($product_tab['callback'], $key, $product_tab);
} ?>
				</div>

			</div>
		<?php endforeach; ?>
    
		<?php do_action('woocommerce_product_after_tabs'); ?>
	</div>

<?php endif; ?>
