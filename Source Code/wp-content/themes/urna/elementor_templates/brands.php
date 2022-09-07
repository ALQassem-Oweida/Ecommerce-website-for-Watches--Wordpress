<?php
/**
 * Templates Name: Elementor
 * Widget: Brands
 */
extract($settings);

if (empty($brands) || !is_array($brands)) {
    return;
}

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->settings_layout();

$this->add_render_attribute('item', 'class', 'item');
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content">
        <div <?php echo trim($this->get_render_attribute_string('row')) ?>>
            <?php foreach ($brands as $item) : ?>

            <?php if (isset($item['brand_image']['url']) && !empty($item['brand_image']['url'])) : ?> 
                <div <?php echo trim($this->get_render_attribute_string('item')); ?>>
                    <?php $this->render_item($item); ?>
                </div>
            <?php endif; ?>

            <?php endforeach; ?>
        </div>
    </div>

    <?php $this->render_btn_readmore(); ?>
</div>