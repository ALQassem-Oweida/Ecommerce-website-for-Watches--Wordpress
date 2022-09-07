<?php

$columns = $screen_desktop = $screen_desktopsmall = $screen_tablet = $screen_landscape_mobile = $screen_mobile = $rows = $nav_type = $pagi_type = $loop_type = $auto_type = $autospeed_type = $disable_mobile = $el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$loop_type = $auto_type = $autospeed_type = '';
extract($atts);

if (isset($categoriestabs) && !empty($categoriestabs)) {
    $categoriestabs = (array) vc_param_group_parse_atts($categoriestabs);
}

$_id = urna_tbay_random_key();


$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
$data_responsive  = urna_tbay_checK_data_responsive_grid($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';


$class_to_filter = 'tbay-addon tbay-addon-'. $layout_type .' tbay-addon-categories categories ';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

if (! (isset($shop_now) && $shop_now == 'yes')) {
    $shop_now = '';
    $shop_now_text = '';
}

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
    
	<?php if (isset($categoriestabs) && $categoriestabs) : ?>
		<div class="tbay-addon-content woocommerce">
			<div class="<?php echo esc_attr($layout_type); ?>-wrapper">

                <?php if (isset($layout_type) && $layout_type == 'carousel') : ?>

                    <?php  wc_get_template('layout-categories/'.  $layout_type .'-custom.php', array( 'categoriestabs' => $categoriestabs, 'columns' => $columns, 'count_item' => $count_item, 'rows' => $rows, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'disable_mobile' => $disable_mobile, 'shop_now' => $shop_now,'shop_now_text' => $shop_now_text )); ?>

                <?php else : ?>

                    <div class="row <?php echo esc_attr($layout_type); ?>" <?php echo trim($data_responsive); ?>>
                        <?php  wc_get_template('layout-categories/'.  $layout_type .'-custom.php', array( 'categoriestabs' => $categoriestabs, 'columns' => $columns , 'count_item' => $count_item, 'screen_desktop' => $responsive['desktop'], 'screen_desktopsmall' => $responsive['desktopsmall'], 'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'shop_now' => $shop_now,'shop_now_text' => $shop_now_text )); ?>
                    </div>

                <?php endif; ?>

			</div>
		</div>
        
	<?php endif; ?>

    <?php

        if ($button_show_type === 'all') {
            $aUrl = get_permalink(wc_get_page_id('shop'));

            echo '<a class="show-all" href="'. esc_url($aUrl) .'">'. trim($show_all_text) .'</a>';
        }

    ?>
</div>
