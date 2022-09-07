<?php
/**
 * Templates Name: Elementor
 * Widget: Banner
 */
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$link               = $banner_link['url'];

if (empty($banner_image) || !is_array($banner_image)) {
    return;
}

?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <div class="tbay-addon-content">
        <?php
            $this->render_item_description();
            $this->render_item_image();
            $this->render_item_content();
        ?>
    </div>
    <?php $this->render_banner_element_heading(); ?>
</div>