<?php
/**
 * Templates Name: Elementor
 * Widget: Products
 */
$rows = 1;
extract($settings);
$this->settings_layout();

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

if (isset($limit) && !((bool) $limit)) {
    return;
}

$show_des = (isset($show_des) && $show_des === 'yes') ? true : false;

$this->add_render_attribute('wrapper', 'class', ['products', 'tbay-addon-'. $layout_type]);

/** Get Query Products */
$loop = urna_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);

$category = '';
if (is_array($categories) && count($categories) === 1) {
    $category = $categories[0];
} elseif (!empty($categories)) {
    $category = $categories;
}


$this->add_render_attribute('row', 'class', ['rows-'.$rows ]);
$attr_row = $this->get_render_attribute_string('row');
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content woocommerce">
        <div class="<?php echo esc_attr($layout_type); ?>-wrapper">
            <?php wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'attr_row' => $attr_row, 'layout_type' => $layout_type, 'rows' => $rows, 'show_des' => $show_des)); ?>
        </div>
    </div>
    <?php $this->render_item_button($category); ?>
</div>