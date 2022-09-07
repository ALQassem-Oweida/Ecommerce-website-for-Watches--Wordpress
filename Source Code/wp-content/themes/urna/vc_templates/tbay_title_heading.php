<?php
 
$style = $el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-text-heading '. $style .' ';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>

<div class="<?php echo esc_attr($css_class);?>">
	<?php if ((isset($subtitle) && $subtitle) || (isset($title) && $title)): ?>
        <h3 class="tbay-addon-title" <?php if ($font_color!=''): ?> style="color: <?php echo esc_attr($font_color); ?>;"<?php endif; ?>>
            <?php if (isset($title) && $title): ?>
                <span><?php echo trim($title); ?></span>
            <?php endif; ?>
            <?php if (isset($subtitle) && $subtitle): ?>
                <span class="subtitle"><?php echo trim($subtitle); ?></span>
            <?php endif; ?>
        </h3>
    <?php endif; ?>
    <?php if (trim($descript)!='') { ?>
        <div class="description">
            <?php echo trim($descript); ?>
        </div>
    <?php } ?>
    <?php if (trim($linkbutton)!='') { ?>
        <div class="clearfix action">
            <?php if (trim($linkbutton)!='') { ?>
            <a class="btn btn-befo <?php echo esc_attr($buttons); ?>" href="<?php echo esc_url($linkbutton); ?>"> <?php echo trim($textbutton); ?> </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>