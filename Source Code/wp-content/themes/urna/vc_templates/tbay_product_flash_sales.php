<?php

$date_title_ended = $date_title = $ids = $link = $position = $el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$loop_type = $auto_type = $autospeed_type = '';
extract($atts);

if (empty($ids)) {
    echo '<div class="not-product-flash-sales">'. esc_html__('Please select the show product', 'urna')  .'</div>';
    return;
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


if (strpos($ids, ",") !== false) {
    $ids = explode(",", $ids);
} else {
    $ids = array($ids);
}

$args = array(
    'post_type'       => array( 'product' ),
    'order'           => $order,
    'post__in'        => $ids,
    'posts_per_page'  => -1,
);

if ($orderby == 'price') {
    $args['orderby']    = 'meta_value_num';
    $args['meta_key']   = '_price';
} else {
    $args['orderby'] = $orderby;
}


$loop = new WP_Query($args);

$_id = urna_tbay_random_key();

$flash_sales = true;
$number = $loop->post_count;

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);


$show_des = (isset($show_des)) ? $show_des : false ;

$class_deal_ended   = '';
$end_date          = strtotime($end_date);
$today              = strtotime("today");
if (!empty($end_date) &&  ($today > $end_date)) {
    $class_deal_ended = 'tbay-addon-deal-ended';
}

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-products tbay-addon-'. $layout_type .' tbay-'. $position .' tbay-addon-flash-sales '. $class_deal_ended .' products tbay-addon_products_'. $_id .' ';

$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class); ?><?php echo ((isset($subtitle) && $subtitle) || (isset($title) && $title)) ? '' : 'no-title' ?>">

    <?php if ((isset($subtitle) && $subtitle) || (isset($title) && $title)) : ?>
        <h3 class="tbay-addon-title">
            <?php if (isset($title) && $title): ?>
                <span><?php echo trim($title); ?></span>
            <?php endif; ?>
            <?php if (isset($subtitle) && $subtitle): ?>
                <span class="subtitle"><?php echo trim($subtitle); ?></span>
            <?php endif; ?>
        </h3>
    <?php endif; ?>

    <?php
        if (isset($end_date) && !empty($end_date)) {
            urna_tbay_countdown_flash_sale($end_date, $date_title, $date_title_ended);
        }
    ?>

    <?php if (isset($check_custom_link) && $check_custom_link == 'yes' && '' !== $link && 'bottom' !== $position) : ?>
       <a href="<?php echo esc_url($a_href); ?>" class="show-all" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>"<?php echo trim($a_rel); ?>><?php echo trim($a_title); ?></a>
    <?php endif; ?>

	<?php if ($loop->have_posts()) : ?>
		<div class="tbay-addon-content woocommerce">
			<div class="<?php echo esc_attr($layout_type); ?>-wrapper">

                <?php  wc_get_template('layout-products/'.$layout_type.'.php', array( 'layout_type' => $layout_type, 'flash_sales' => $flash_sales, 'end_date' => $end_date, 'loop' => $loop, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'number' => $number, 'responsive_type' => $responsive_type, 'disable_mobile' => $disable_mobile )); ?>

			</div>
		</div>
	<?php endif; ?>    

    <?php if (isset($check_custom_link) && $check_custom_link == 'yes' && '' !== $link && 'bottom' === $position) : ?>
        <div class="center">
            <a href="<?php echo esc_url($a_href); ?>" class="show-all" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>"<?php echo trim($a_rel); ?>><?php echo trim($a_title); ?></a>
        </div>
    <?php endif; ?>


</div>
