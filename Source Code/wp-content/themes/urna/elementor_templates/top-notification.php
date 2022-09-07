<?php
/**
 * Templates Name: Elementor
 * Widget: Top Notification
 */
extract($settings);
$this->settings_layout();

if (empty($notifications) || !is_array($notifications)) {
    return;
}

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->add_render_attribute('wrapper', 'class', 'tbay-addon-notification');

$this->add_render_attribute(
    'row',
    [
        'class' => 'notifications',
        'data-items' => '1',
        'data-desktopslick' => '1',
        'data-desktopsmallslick' => '1',
        'data-tabletslick' => '1',
        'data-landscapeslick' => '1',
        'data-mobileslick' => '1',
    ]
);


?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content">
        <div <?php echo trim($this->get_render_attribute_string('row')) ?>>
            <?php foreach ($notifications as $item) : ?>

                    <?php $this->render_item($item); ?>

            <?php endforeach; ?>
        </div>
    </div>
</div>