<?php
/**
 * Templates Name: Elementor
 * Widget: Product Flash Sales
 */

extract($settings);

$this->settings_layout();

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$end_date          = strtotime($end_date);

$this->add_render_attribute('wrapper', 'class', [ 'tbay-'. $readmore_position , 'tbay-addon-products', 'tbay-addon-flash-sales', 'products', 'tbay-addon-'. $layout_type , $this->deal_end_class() ]);
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>


	<?php $this->render_element_heading();
    if (isset($end_date) && !empty($end_date)) {
        urna_tbay_countdown_flash_sale($end_date, $date_title, $date_title_ended, true);
    } ?>

	<?php if ($readmore_position !== 'bottom') {
        $this->render_btn_readmore();
    } ?>

    <div class="tbay-addon-content woocommerce">
		<div class="<?php echo esc_attr($layout_type); ?>-wrapper">
            <?php $this->render_content_main(); ?>
		</div>
    </div>

	<?php if ($readmore_position === 'bottom') : ?>
	    <?php
            echo '<div class="center">';
                $this->render_btn_readmore();
            echo '</div>';
        ?>
	<?php endif; ?>

</div>