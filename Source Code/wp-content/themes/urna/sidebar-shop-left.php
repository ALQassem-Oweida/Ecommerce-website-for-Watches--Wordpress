<?php
$class_shop = '';
$sidebar_configs = urna_tbay_get_woocommerce_layout_configs();

if (empty($sidebar_configs['left']['sidebar'])) {
    return;
}

$sidebar_id = $sidebar_configs['left']['sidebar'];

if (is_product_category() || is_product_tag() || is_product_taxonomy() || is_shop()) {
    $class_shop = 'hidden-xs hidden-sm hidden-md';
}

if (urna_woo_is_wcmp_vendor_store()) {
    $sidebar_id = 'wc-marketplace-store';
}

?> 
<?php  if (isset($sidebar_configs['left']) && is_active_sidebar($sidebar_id)) : ?>

	<aside id="sidebar-shop-left" class="sidebar <?php echo esc_attr($sidebar_configs['left']['class']); ?> <?php echo esc_attr($class_shop); ?>">
		<?php dynamic_sidebar($sidebar_id); ?>
	</aside>

<?php endif; ?>