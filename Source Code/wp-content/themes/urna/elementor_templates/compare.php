<?php
/**
 * Templates Name: Elementor
 * Widget: Compare
 */
$this->add_render_attribute('wrapper', 'class', 'header-icon');

extract($settings);

if (!class_exists('YITH_Woocompare')) {
    return;
}

?>
<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_item_compare() ?>
</div>
