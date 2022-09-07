<?php

$el_class = $show_banner = $banner_positions = $banner = $number = $banner_link = $show_menu = $menu_positions = $nav_menu = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$loop_type = $auto_type = $autospeed_type = '';
extract($atts);

if ($type == '') {
    return;
}

if (isset($categories) && !empty($categories) && strpos($categories, ',') !== false) {
    $categories = explode(',', $categories);
    $categories = urna_tbay_get_category_by_id($categories);

    $loop = urna_tbay_get_products($categories, $type, 1, $number);
} elseif (isset($categories) && !empty($categories)) {
    $categories = get_term_by('id', $categories, 'product_cat')->slug;

    $loop = urna_tbay_get_products(array($categories), $type, 1, $number);
} else {
    $loop = urna_tbay_get_products('', $type, 1, $number);
}

$data_categories = $categories;
 
$_id = urna_tbay_random_key();
$_count = 1;

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$show_des = (isset($show_des)) ? $show_des : false ;

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$has_banner = ($show_banner) ? 'has-banner banner-'.$banner_positions : '';

$has_menu   = ($show_menu) ? 'has-menu menu-'.$menu_positions : '';

$class_to_filter = 'tbay-addon tbay-addon-'. $layout_type .' '. $has_banner .' '. $has_menu .' tbay-addon-carousel tbay-addon-products tbay-addon-products-menu-banner products tbay-addon_products_'. $_id .' ';

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

	<?php if ($loop->have_posts()) : ?>
		<div class="tbay-addon-content woocommerce">

            <?php if ($show_menu && !empty($nav_menu) && $menu_positions === 'top') : ?>

                <div class="custom-menu-wrapper">
                    <?php
                        $menu_id = $nav_menu;
                        urna_get_custom_menu($menu_id);
                    ?>
                </div>

            <?php endif; ?>

			<div class="main-content">

                <?php if ($show_banner) : ?>
                    <?php
                        $img     = (isset($banner)) ? wp_get_attachment_image_src($banner, 'full') : '';
                    ?>

                    <?php if (!empty($img) && isset($img[0])): ?>
                    <div class="hidden-sm hidden-xs banner">
                        <?php if (isset($banner_link) && !empty($banner_link)) : ?>
                            <div class="img-banner">
                                <a href="<?php echo esc_url($banner_link); ?>">
                                    <?php echo wp_get_attachment_image($banner, 'full'); ?>
                                </a>
                            </div>
                        <?php else : ?>
                            <div class="img-banner">
                                <?php echo wp_get_attachment_image($banner, 'full'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    </div>
                <?php endif; ?> 
 
                <?php  wc_get_template('layout-products/'.$layout_type.'.php', array( 'layout_type' => $layout_type, 'show_des' => $show_des, 'loop' => $loop, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'number' => $number, 'responsive_type' => $responsive_type, 'disable_mobile' => $disable_mobile )); ?>
                
			</div>

            <?php if ($show_menu && !empty($nav_menu) && $menu_positions === 'bottom') : ?>

                <div class="custom-menu-wrapper hidden-xs">
                    <?php
                        $menu_id = $nav_menu;
                        urna_get_custom_menu($menu_id);
                    ?>
                </div>

            <?php endif; ?>


		</div>
	<?php endif; ?>    

    <?php if (isset($show_button) && $show_button == 'yes') : ?>
        <?php
            if (empty($data_categories)) {
                $url = get_permalink(wc_get_page_id('shop'));
            } elseif (is_array($data_categories)) {
                $category   = get_term_by('slug', $data_categories['0'], 'product_cat');
                $url = get_term_link($category->term_id, 'product_cat');
            } else {
                $url  = get_term_link($categories, 'product_cat');
            }

        ?>

        <a href="<?php echo esc_url($url); ?>" class="show-all">
            <?php echo trim($button_text); ?>
        </a>
    <?php endif; ?>



</div>
