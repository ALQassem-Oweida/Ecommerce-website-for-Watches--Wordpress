<?php
/**
 * Templates Name: Elementor
 * Widget: Products Banner Menu
 */
$rows = 1;
$categories =  $cat_operator = $product_type = $limit = $orderby = $order = '';
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

if (!empty($show_banner) && $show_banner === 'yes') {
    $this->add_render_attribute('wrapper', 'class', ['has-banner', 'banner-'. $banner_positions]);
}

if (!empty($show_menu) && $show_menu === 'yes') {
    $this->add_render_attribute('wrapper', 'class', ['has-menu', 'menu-'. $menu_positions]);
}

$this->add_render_attribute('wrapper', 'class', ['products', 'tbay-addon-products', 'tbay-addon-products-menu-banner', 'tbay-addon-'. $layout_type]);

$layout_type = $settings['layout_type'];
$this->settings_layout();
 
/** Get Query Products */
$loop = urna_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);

$attr_row = $this->get_render_attribute_string('row');

?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_element_heading(); ?>

	<div class="tbay-addon-content woocommerce">

		<?php if (!empty($menu_positions) && $menu_positions === 'top') {
    $this->render_item_menu();
} ?>

		<div class="main-content">
			<?php $this->render_item_banner(); ?>
			<?php wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'attr_row' => $attr_row, 'layout_type' => $layout_type, 'rows' => $rows)); ?>

		</div>

		<?php if (!empty($menu_positions) && $menu_positions !== 'top') {
    $this->render_item_menu();
} ?>

	</div>

	<?php $this->render_item_show_all(); ?>
</div>