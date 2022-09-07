<?php

$el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$loop_type = $auto_type = $autospeed_type = '';
extract($atts);

if (isset($tabs) && !empty($tabs)) {
    $tabs = (array) vc_param_group_parse_atts($tabs);
}

$_id = urna_tbay_random_key();

$columns = $screen_desktop = $screen_desktopsmall = $screen_tablet = $screen_landscape_mobile = $screen_mobile = $extrasmall  =  1;

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-notification tbay-addon_products_'. $_id .' ';

$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

wp_enqueue_script('slick');
wp_enqueue_script('urna-slick');
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

	<?php if (count($tabs) > 0) : ?> 
		<div class="tbay-addon-content">


            <?php
                $data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
                $responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
            ?>
            <div class="owl-carousel scroll-init notifications" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
                <?php foreach ($tabs as $tab) : ?>


                    <?php
                        if (isset($tab['description']) && !empty($tab['description'])) {
                            echo '<div class="item">'. trim($tab['description']) .'</div>';
                        }

                    ?>

                <?php endforeach; ?>
            </div> 

		</div>
	<?php endif; ?>    


</div>
