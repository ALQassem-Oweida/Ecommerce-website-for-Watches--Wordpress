<?php
/**
 * Templates Name: Elementor
 * Widget: Banner
 */
$_id = $this->get_id();
$banner_hidden = urna_tbay_get_cookie('banner_remove_'. $_id);

extract($settings);
$link               = $banner_link['url'];



if ($banner_hidden || empty($banner_image) || !is_array($banner_image)) {
    $this->add_render_attribute('_wrapper', 'class', 'banner-close-remove');
    echo '<div class="d-none"></div>';

    return;
}

$this->add_render_attribute('content', 'class', 'banner-content');

?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <div <?php echo trim($this->get_render_attribute_string('content')) ?>>
        <?php
            $this->render_item_content();
        ?>
    </div>
    
</div>