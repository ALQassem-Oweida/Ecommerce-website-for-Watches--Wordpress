<?php

$style = $columns = $screen_desktop = $screen_desktopsmall = $screen_tablet = $screen_landscape_mobile = $screen_mobile = $rows = $nav_type = $pagi_type = $loop_type = $auto_type = $autospeed_type = $disable_mobile = $el_class = $css = $css_animation = $disable_mobile = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$loop_type = $auto_type = $autospeed_type = '';
extract($atts);

$taxonomy     = 'product_cat';
$orderby      = 'name';
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$empty        = 0;

$args = array(
     'taxonomy'     => $taxonomy,
     'orderby'      => $orderby,
     'number'       => $number,
     'pad_counts'   => $pad_counts,
     'hierarchical' => $hierarchical,
     'title_li'     => $title,
     'hide_empty'   => $empty
);
$all_categories = get_categories($args);

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
$data_responsive  = urna_tbay_checK_data_responsive_grid($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$_id = urna_tbay_random_key();
$_count = 1;

$screen_desktop          =      isset($screen_desktop) ? $screen_desktop : $columns;
$screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
$screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;


$_id = urna_tbay_random_key();

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter  = 'tbay-addon tbay-addon-'. $layout_type .' tbay-addon-categories categories ';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class        = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

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

	<?php if ($all_categories) : ?>
		<div class="tbay-addon-content woocommerce">
			<div class="<?php echo esc_attr($layout_type); ?>-wrapper">

                <?php if (isset($layout_type) && $layout_type == 'carousel') : ?>


                    <?php  wc_get_template('layout-categories/'. $layout_type .'.php', array( 'all_categories' => $all_categories, 'columns' => $columns, 'rows' => $rows, 'loop_type' => $loop_type, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'screen_desktop' => $responsive['desktop'],'screen_desktopsmall' => $responsive['desktopsmall'],'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'number' => $number, 'disable_mobile' => $disable_mobile )); ?>
                    
                    <?php


                    if (isset($button_show_type) && $button_show_type === 'all') {
                        $aUrl = get_permalink(wc_get_page_id('shop'));

                        echo '<a class="show-all" href="'. esc_url($aUrl) .'">'. trim($show_all_text) .'</a>';
                    }


                    ?>
                <?php else : ?>

                    <div class="row <?php echo esc_attr($layout_type); ?>" <?php echo trim($data_responsive); ?>>
                        <?php  wc_get_template('layout-categories/'. $layout_type .'.php', array( 'all_categories' => $all_categories, 'columns' => $columns, 'number' => $number , 'screen_desktop' => $responsive['desktop'], 'screen_desktopsmall' => $responsive['desktopsmall'], 'screen_tablet' =>$responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'] )); ?> 
                    </div>

                    <?php


                    if (isset($button_show_type) && $button_show_type === 'all') {
                        $aUrl = get_permalink(wc_get_page_id('shop'));

                        echo '<a class="show-all" href="'. esc_url($aUrl) .'">'. trim($show_all_text) .'</a>';
                    }


                    ?>

                <?php endif; ?>


			</div>
		</div>
	<?php endif; ?>

</div>
