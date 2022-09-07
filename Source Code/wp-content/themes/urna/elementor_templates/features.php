<?php
/**
 * Templates Name: Elementor
 * Widget: Feautures
 */
$styles = '';
extract($settings);
$this->settings_layout();

if (empty($features) || !is_array($features)) {
    return;
}

$this->add_render_attribute('wrapper', 'class', $styles);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->add_render_attribute('item', 'class', 'feature-box');
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content">
        <div <?php echo trim($this->get_render_attribute_string('row')) ?>>
            <?php foreach ($features as $item) : ?>

                <div <?php echo trim($this->get_render_attribute_string('item')); ?>>

                    <?php $this->render_item($item); ?>
                    
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>