<?php
/**
 * Templates Name: Elementor
 * Widget: Custom Image List Tags
 */
$rows = 1;
extract($settings);

$this->settings_layout();
$this->add_render_attribute('item', 'class', 'item');


if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->add_render_attribute('row', 'class', ['rows-'.$rows ]);

$this->add_render_attribute('wrapper', 'class', ['tbay-addon-tags', 'tags', 'tbay-addon-'.$layout_type]);

$tags_default = $this->get_woocommerce_tags();

?>
<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_element_heading(); ?>
    
    <?php if (is_array($tags_default) && count($tags_default) !== 0) : ?>

        <div class="tbay-addon-content woocommerce">
            <div class="<?php echo esc_attr($layout_type); ?>-wrapper">
                <div <?php echo trim($this->get_render_attribute_string('row')) ?>>
                        <?php foreach ($tags as $item) : ?>
                            
                            <div <?php echo trim($this->get_render_attribute_string('item')); ?>>
                                
                                <?php  $this->render_item($item); ?> 

                            </div>

                        <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
            $this->render_item_button();
        ?>
    <?php else: ?>

        <?php echo '<div class="error-tags">'. esc_html__('Please go to the product save to get the tag.', 'urna') .'</div>'; ?>

    <?php endif; ?>


</div>