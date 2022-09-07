<?php
/**
 * Templates Name: Elementor
 * Widget: Products Category
 */
$rows = 1;
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', ['tbay-addon-categories', 'categories', 'tbay-addon-'. $layout_type]);

$taxonomy     = 'product_cat';
$orderby      = 'name';
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$empty        = 0;

$args = array(
     'taxonomy'     => $taxonomy,
     'orderby'      => $orderby,
     'number'       => $limit,
     'pad_counts'   => $pad_counts,
     'hierarchical' => $hierarchical,
     'hide_empty'   => $empty,
);
$all_categories = get_categories($args);

$this->add_render_attribute('row', 'class', ['categories', 'rows-'.$rows ]);
$attr_row = $this->get_render_attribute_string('row');

?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content woocommerce">
        <div class="<?php echo esc_attr($layout_type); ?>-wrapper">
            <?php if ($layout_type === 'grid') : ?>
                <div <?php echo trim($this->get_render_attribute_string('row')); ?> > 
            <?php endif;  ?>

            <?php wc_get_template('layout-categories/'. $layout_type .'.php', array( 'all_categories' => $all_categories, 'attr_row' => $attr_row, 'rows' => $rows)); ?>
        
            <?php if ($layout_type === 'grid') : ?>
                </div> 
            <?php endif;  ?>
            <?php $this->render_item_button(); ?>
        </div>
    </div>

</div>