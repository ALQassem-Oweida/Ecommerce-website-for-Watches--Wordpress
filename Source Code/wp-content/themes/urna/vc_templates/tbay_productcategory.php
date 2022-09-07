<?php

$el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$loop_type = $auto_type = $autospeed_type = '';
extract($atts);


$cat_array = array();
$args = array(
    'type' => 'post',
    'child_of' => 0,
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
    'hierarchical' => 1,
    'taxonomy' => 'product_cat'
);
$categories = get_categories($args);
urna_tbay_get_category_childs($categories, 0, 0, $cat_array);

$cat_array_id   = array();
foreach ($cat_array as $key => $value) {
    $cat_array_id[]   = $value;
}

if (!in_array($category, $cat_array_id)) {
    $category = -1;
    $loop            = urna_tbay_get_products($category, '', 1, $number);
} else {
    $cat_category = get_term_by('id', $category, 'product_cat');
    $slug 		  = $cat_category->slug;
    $loop 		  = urna_tbay_get_products(array($slug), '', 1, $number);
}

if ($category !== -1) {
    $url  = get_term_link($cat_category, 'product_cat');
} else {
    $url = get_permalink(wc_get_page_id('shop'));
}

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$_id = urna_tbay_random_key();

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_image_cat  = ($image_cat) ? 'has-banner' : '';

$class_to_filter = 'tbay-addon tbay-addon-product-category '. $class_image_cat .' tbay-addon-products '. $layout_type .' tbay-addon_products_'. $_id .' ';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class); ?>">
	 <?php if ((isset($subtitle) && $subtitle) || (isset($title) && $title)): ?>
        <h3 class="tbay-addon-title">
            <?php if (isset($title) && $title): ?>
                <span><?php echo trim($title); ?></span>
            <?php endif; ?>
            <?php if (isset($subtitle) && $subtitle): ?>
                <span class="subtitle"><?php echo trim($subtitle); ?></span>
            <?php endif; ?>
        </h3>
    <?php endif; ?>



	<?php if ($layout_type == 'carousel') { ?>

		<div class="tbay-addon-content">
			<?php if ($loop->have_posts()): ?>
				<div class="products grid-wrapper woocommerce">
					<?php if ($image_cat): ?>
						<div class="tbay-addon-banner">
							<a href="<?php echo esc_url($url); ?>">
								<?php echo wp_get_attachment_image($image_cat, 'full'); ?>
							</a>
						</div>
					<?php endif ?>

					<?php wc_get_template('layout-products/'.$layout_type.'.php', array( 'loop' => $loop, 'layout_type' => $layout_type, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'number' => $number, 'disable_mobile' => $disable_mobile )); ?>
                 
				</div> 
			<?php endif; ?>
		</div>

	<?php } else { ?>

		<div class="tbay-addon-content">
			<?php if ($loop->have_posts()): ?>
				<div class="products grid-wrapper woocommerce">
					<?php if ($image_cat): ?>
						<div class="tbay-addon-banner">
							<?php echo wp_get_attachment_image($image_cat, 'full'); ?>
						</div>
					<?php endif ?>
					
					<?php wc_get_template('layout-products/'.$layout_type.'.php', array( 'loop' => $loop,'layout_type' => $layout_type, 'columns' => $columns, 'number' => $number,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'] )); ?>
				</div>
			<?php endif; ?>
		</div>

	<?php } ?>

	<?php if (isset($show_button) && $show_button == 'yes' && !empty($button_text)) : ?>
        
        <a href="<?php echo esc_url($url); ?>" class="show-all">
            <?php echo trim($button_text); ?>
        </a>
    <?php endif; ?>

</div>