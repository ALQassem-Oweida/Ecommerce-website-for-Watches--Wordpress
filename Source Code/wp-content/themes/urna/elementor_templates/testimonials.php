<?php
/**
 * Templates Name: Elementor
 * Widget: Testimonials
 */
extract($settings);
if (empty($testimonials) || !is_array($testimonials)) {
    return;
}

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->settings_layout();

$skin = urna_tbay_get_theme();
switch ($skin) {
    case 'underwear':
        $layout = 'v2';
        break;
    default:
        $layout = 'v1';
        break;
}

$this->add_render_attribute('item', 'class', ['item', $layout]);
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content">
        <div <?php echo trim($this->get_render_attribute_string('row')) ?>>
            <?php foreach ($testimonials as $item) : ?>
            
                <div <?php echo trim($this->get_render_attribute_string('item')); ?>>
                    <?php $this->render_item($item, $layout); ?>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>