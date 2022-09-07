<?php
/**
 * Templates Name: Elementor
 * Widget: Products Tabs
 */
$style = $category = '';

$categories = $cat_operator  = $limit = $orderby = $order = '';
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->settings_layout();

$random_id = urna_tbay_random_key();

if (is_array($categories) && count($categories) === 1) {
    $category = $categories[0];
} elseif (!is_array($categories) && !empty($categories)) {
    $category = $categories;
}

$this->add_render_attribute('wrapper', 'class', ['tbay-addon-products', 'products', 'tbay-addon-'. $layout_type]);


$this->add_render_attribute('row', 'class', ['products']);

if ($ajax_tabs === 'yes') {
    $attr_row = $this->get_render_attribute_string('row'); 

    $show_des = (isset($show_des) && $show_des === 'yes') ? true : false;
    $json = array(
        'categories'                    => $categories,
        'cat_operator'                  => $cat_operator,
        'limit'                         => $limit,
        'orderby'                       => $orderby, 
        'order'                         => $order,
        'attr_row'                      => $attr_row, 
        'layout_type'                   => $layout_type,
        'show_des'                      => $show_des,
        'rows'                          => $rows,  
    );    

    $encoded_settings  = wp_json_encode( $json ); 

    $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';

    $this->add_render_attribute('wrapper', 'class', 'ajax-active'); 
} else {
    $tabs_data = ''; 
}
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    
    <div class="tabs-container tab-heading <?php echo (isset($heading_title) && $heading_title) ? 'has-title' : ''; ?>">

        <?php $this->render_element_heading(); ?>

        <ul class="product-tabs-title tabs-list nav nav-tabs" <?php echo trim($tabs_data); ?>>
            <?php $__count = 0;?>
            <?php foreach ($list_product_tabs as $key) {
                    $active = ($__count==0)? 'active':'';

                    $product_tabs = $key['product_tabs'];
                    $title = $this->get_title_product_type($product_tabs);
                    if (!empty($key['product_tabs_title'])) {
                        $title = $key['product_tabs_title'];
                    }

                    $this->render_product_tabs($product_tabs, $key['_id'], $random_id, $title, $active);
                    $__count++;
                }
            ?>
        </ul>
    </div>

    <?php $this->render_product_tabs_content($list_product_tabs, $random_id); ?>

    <?php $this->render_item_button($category); ?>

</div>