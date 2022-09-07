<?php
$el_class = $type = $link = $text_button = $style = $css = $css_animation = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-banner';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class); ?>">
    <div class="tbay-addon-content"> 
		<?php if (!empty($description)) { ?>
			<p class="tbay-addon-description">
				<?php echo trim($description); ?>
			</p>
		<?php } ?>

		<?php $img = wp_get_attachment_image_src($image, 'full'); ?>
		<?php if (!empty($img) && isset($img[0])): ?>
            <div class="image">
                <?php echo wp_get_attachment_image($image, 'full'); ?>
            </div>
        <?php endif; ?>

    <?php if (!empty($link)) :
        if ($style === 'none') : ?>

            <a href="<?php echo esc_url($link); ?>" class="icon"></a>

        <?php elseif ($style === 'button') : ?>

            <a class="button" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($text_button); ?>"><?php echo trim($text_button); ?></a>

        <?php elseif ($style === 'icon') : ?>
            <?php
            
                if (isset($type) && $type !== 'none') {
                    vc_icon_element_fonts_enqueue($type);
                    $iconClass = isset(${'icon_' . $type }) ? esc_attr(${'icon_' . $type }) : 'linear-icon-plus'; ?>
                        <a href="<?php echo esc_url($link); ?>" class="icon" ><i class="<?php echo esc_attr($iconClass); ?>"></i></a>
                    <?php
                }
            ?>
        <?php endif; ?>
    <?php endif; ?>



    </div>
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
</div>