<?php

$link = $empty_text = $only_image = $number = $el_class = $css = $css_animation = $loop_type = $auto_type = $autospeed_type = $disable_mobile = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$args                       =  urna_tbay_get_products_recently_viewed($number);
$products_list              =  urna_tbay_wc_track_user_get_cookie();
$all                        =  count($products_list);
$count                      =  (int)$args;
$args                       =  apply_filters('urna_list_recently_viewed_products_args', $args);

$loop                       = new WP_Query($args);

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

$rows_count                 = isset($rows) ? $rows : 1;

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-products product-recently-viewed tbay-addon-'. $layout_type .'';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$class_empty = ($loop->have_posts()) ? '' : 'content-empty';
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
    
    <div class="tbay-addon-content woocommerce <?php echo esc_attr($class_empty); ?>">
        <?php if ($loop->have_posts()) : ?>
            
                <div class="<?php echo esc_attr($layout_type); ?>-wrapper">


                    <?php  wc_get_template('layout-products/'.$layout_type.'-recently-viewed.php', array( 'only_image' => $only_image,'layout_type' => $layout_type, 'loop' => $loop, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'],'screen_mobile' => $responsive['mobile'], 'number' => $number, 'responsive_type' => $responsive_type, 'disable_mobile' => $disable_mobile )); ?>

                </div>
        <?php else: ?>
            <?php echo trim($empty_text); ?>
        <?php endif; ?>    
    </div>

    <?php if (isset($check_link_rv) && $check_link_rv == 'yes' && '' !== $link && $all > $count) : ?>
        <a href="<?php echo esc_url($a_href); ?>" class="show-all" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>"<?php echo trim($a_rel); ?>><?php echo trim($a_title); ?></a>
    <?php endif; ?>
</div>
