<?php
/**
 * Templates Name: Elementor
 * Widget: Site Logo
 */

if ($settings['logo_select'] === 'global_logo') {
    $custom_logo = $this->get_value();

    $settings['image']['url'] = $custom_logo['url'];
    $settings['image']['id'] = '';
} else {
    $settings['image']['url'] = $settings['image_logo']['url'];
    $settings['image']['id'] = $settings['image_logo']['id'];
}

if (empty($settings['image']['url'])) {
    return;
}

$this->add_render_attribute('logo_img', [
    'src' => $settings['image']['url'],
    'class' => 'header-logo-img',
]); 

$has_caption = ! empty($settings['caption']);

$this->add_render_attribute('content', 'class', 'header-logo');

if (! empty($settings['shape'])) {
    $this->add_render_attribute('wrapper', 'class', 'elementor-image-shape-' . $settings['shape']);
}
 
$link = $this->get_link_url($settings);

if ($link) {
    $this->add_render_attribute('link', [
        'href' => $link['url'],
    ]);
} ?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <div <?php echo trim($this->get_render_attribute_string('content')); ?>>
        <?php if ($link) : ?>

             <a <?php echo trim($this->get_render_attribute_string('link')); ?>>
                <img <?php echo trim($this->get_render_attribute_string('logo_img')); ?>>
            </a>
 
        <?php else: ?>
            <img <?php echo trim($this->get_render_attribute_string('logo_img')); ?>>
        <?php endif; ?>
    </div>

</div>