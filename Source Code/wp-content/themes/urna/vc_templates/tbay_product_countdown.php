<?php

$class_position = $show_banner = $banners = $banner_link = $show_menu = $nav_menu = $el_class = $css = $css_animation = $loop_type = $auto_type = $autospeed_type = $disable_mobile = $countdown_title = $link = $position = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$type = 'deals';

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
 
//parse link
$link = ('||' === $link) ? '' : $link;
$link = vc_build_link($link);
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];
$a_rel = $link['rel'];
if (! empty($a_rel)) {
    $a_rel = ' rel="' . esc_attr(trim($a_rel)) . '"';
}

$_id = urna_tbay_random_key();
 
$rows_count = isset($rows) ? $rows : 1;

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);


$countdown = true;

wp_enqueue_script('jquery-countdowntimer');

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$has_banner = ($show_banner) ? 'has-banner' : '';
$has_menu   = ($show_menu) ? 'has-menu' : '';

$class_content = $class_content_wrapper = '';
if ($has_banner &&  $has_menu) {
    $class_content          = 'col-sm-12 col-lg-6';
    $class_content_wrapper  = 'row';
} elseif ($has_banner || $has_menu) {
    $class_content          = 'col-sm-12 col-lg-9';
}

if ('' === $banners) {
    $banners = '-1,-2,-3';
}
$banners = explode(',', $banners);

if (!empty($position)) {
    $class_position = ' tbay-'. $position;
}

$class_to_filter = 'tbay-addon tbay-addon-products product-countdown tbay-addon-'. $layout_type .' '. $class_position .' '.$has_banner.' '.$has_menu.'';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

wp_enqueue_script('jquery-countdowntimer');
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

    <?php if (isset($custom_link) && $custom_link == 'yes' && '' !== $link && 'bottom' !== $position) : ?>
       <a href="<?php echo esc_url($a_href); ?>" class="show-all" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>"<?php echo trim($a_rel); ?>><?php echo trim($a_title); ?></a>
    <?php endif; ?>

    <?php if ($loop->have_posts()) : ?>
        <div class="tbay-addon-content woocommerce <?php echo esc_attr($class_content_wrapper); ?>">

            <?php if ($show_menu && !empty($nav_menu)) : ?>

                <div class="custom-menu-wrapper col-sm-6 col-md-4 col-lg-3">
                    <?php
                        $menu_id = $nav_menu;
                        urna_get_custom_menu($menu_id);
                    ?>
                </div>

            <?php endif; ?>

            <?php if ($show_banner) : ?>

                <?php if (is_array($banners) || is_object($banners)) : ?>
                    <?php if (isset($banner_link) && !empty($banner_link)) : ?>
                        <div class="img-banner col-sm-6 col-md-8 col-lg-3 clearfix">
                            <a href="<?php echo esc_url($banner_link); ?>">
                                <?php
                                    foreach ($banners as $i => $banner) {
                                        if ($banner > 0) {
                                            echo wp_get_attachment_image($banner, 'full');
                                        }
                                    }
                                ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="img-banner col-sm-6 col-md-8 col-lg-3 clearfix">
                            <?php
                                foreach ($banners as $i => $banner) {
                                    if ($banner > 0) {
                                        echo wp_get_attachment_image($banner, 'full');
                                    }
                                }
                            ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            <?php endif; ?>


            <div class="tbay-content <?php echo esc_attr($class_content); ?> <?php echo esc_attr($layout_type); ?>-wrapper">

                <?php  wc_get_template('layout-products/'.$layout_type.'.php', array( 'countdown' => $countdown,'countdown_title' => $countdown_title,'layout_type' => $layout_type, 'loop' => $loop, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'number' => $number, 'responsive_type' => $responsive_type, 'disable_mobile' => $disable_mobile )); ?>

            </div>

        </div>
    <?php endif; ?>

    <?php if (isset($custom_link) && $custom_link == 'yes' && '' !== $link && 'bottom' === $position) : ?>
        <div class="center">
            <a href="<?php echo esc_url($a_href); ?>" class="show-all" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>"<?php echo trim($a_rel); ?>><?php echo trim($a_title); ?></a>
        </div>
    <?php endif; ?>

</div>
