<?php
/**
 * Templates Name: Elementor
 * Widget: Product Flash Sales
 */

extract($settings);

$this->settings_layout();
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_content_header(); ?>
</div>