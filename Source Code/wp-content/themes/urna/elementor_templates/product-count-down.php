<?php
/**
 * Templates Name: Elementor
 * Widget: Product Flash Sales
 */
$show_banner = $show_menu = '';
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}
$this->settings_layout();

$has_banner = ($show_banner === 'yes') ? 'has-banner' : '';
$has_menu   = ($show_menu === 'yes') ? 'has-menu' : '';
$class_content = $class_content_wrapper = '';
if ($has_banner &&  $has_menu) {
    $class_content          = 'col-sm-12 col-lg-6';
    $class_content_wrapper  = 'row';
} elseif ($has_banner || $has_menu) {
    $class_content          = 'col-sm-12 col-lg-9';
}

$this->add_render_attribute('wrapper', 'class', [ 'tbay-addon-products', 'product-countdown', 'tbay-addon-'. $layout_type]);

$this->add_render_attribute('content_wrapper', 'class', ['tbay-addon-content', 'woocommerce', $class_content_wrapper]);

$this->add_render_attribute('content', 'class', ['tbay-content', $layout_type.'-wrapper', $class_content]);
  
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
	<?php $this->render_element_heading();?>

	<div <?php echo trim($this->get_render_attribute_string('content_wrapper')); ?>>

		<?php $this->render_content_menu_count_down(); ?>
		<?php $this->render_content_banner_count_down(); ?>

		<div <?php echo trim($this->get_render_attribute_string('content')); ?>>
			<?php $this->render_content_product_count_down(); ?>
		</div>

	</div>

</div>