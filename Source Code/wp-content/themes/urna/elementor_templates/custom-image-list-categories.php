<?php
/**
 * Templates Name: Elementor
 * Widget: Products Category
 */
$rows = 1;
$display_count = $shop_now = $shop_now_text = '';
$count_item = 'no';
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$attribute = '';
$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', ['tbay-addon-categories', 'categories', 'tbay-addon-'.$layout_type]);

$this->add_render_attribute('row', 'class', ['categories', 'rows-'.$rows ]);

$attr_row = $this->get_render_attribute_string('row');

Elementor\Icons_Manager::enqueue_shim();
?> 

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_element_heading(); ?>
 
    <div class="tbay-addon-content woocommerce">
        <div class="<?php echo esc_attr($layout_type); ?>-wrapper">
            <?php if ($layout_type === 'grid') : ?>
                <div <?php echo trim($this->get_render_attribute_string('row')); ?> > 
            <?php endif;  ?> 
    
            <?php wc_get_template('layout-categories/'. $layout_type .'-custom.php', array( 'categoriestabs' => $categoriestabs, 'attr_row' => $attr_row, 'rows' => $rows, 'count_item' => $count_item, 'shop_now' => $shop_now,'shop_now_text' => $shop_now_text)); ?>
        
            <?php if ($layout_type === 'grid') : ?>
                </div> 
            <?php endif;  ?>
        </div>

    </div>

    <?php $this->render_item_button(); ?>

</div>