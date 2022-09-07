<?php
/**
 * Templates Name: Elementor
 * Widget: Product Categories Tabs
 */
$tab_title_center = '';
extract($settings);

$this->settings_layout();

if ($tab_title_center === 'yes') {
    $this->add_render_attribute('wrapper', 'class', 'title-center');
}

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

if( $ajax_tabs === 'yes' ) {
    $this->add_render_attribute('wrapper', 'class', ['tbay-product-categories-tabs-ajax', 'ajax-active']); 
}

if (empty($categories)) {
    return;
}

$show_des = (isset($show_des) && $show_des === 'yes') ? true : false;

$this->add_render_attribute('wrapper', 'class', [ 'tbay-addon-products', 'tbay-addon-categoriestabs', 'tbay-addon-'. $layout_type]);

$this->add_render_attribute('wrapper-content', 'class', ['tbay-addon-content', 'woocommerce']);
 
$random_id = urna_tbay_random_key();
?>
 
<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <div class="tabs-container tab-heading <?php echo (isset($heading_title) && $heading_title) ? 'has-title' : ''; ?>">
        <?php
         $this->render_element_heading();
         $this->render_tabs_title($categories, $random_id);
        ?>
    </div>

    <div <?php echo trim($this->get_render_attribute_string('wrapper-content')); ?>>

        <?php
            $this->render_product_tabs_content($categories, $random_id);
        ?>
    </div>
</div>