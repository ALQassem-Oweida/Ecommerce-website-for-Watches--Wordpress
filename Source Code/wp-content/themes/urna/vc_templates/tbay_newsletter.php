<?php

$el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter  = 'tbay-addon tbay-addon-newsletter ';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class        = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>
<div class="<?php echo esc_attr($css_class); ?>">
	<?php if ((isset($subtitle) && $subtitle) || (isset($title) && $title)): ?>
        <h3 class="tbay-addon-title">
            <?php if (isset($title) && $title): ?>
                <?php echo trim($title); ?>
            <?php endif; ?>
            <?php if (isset($subtitle) && $subtitle): ?>
                <span class="subtitle"><?php echo trim($subtitle); ?></span>
            <?php endif; ?>
        </h3>
    <?php endif; ?>
    <div class="tbay-addon-content"> 
		<?php if (!empty($description)) { ?>
			<p class="tbay-addon-description">
				<?php echo trim($description); ?>
			</p>
		<?php } ?>		
		
		<?php
            if (function_exists('mc4wp_show_form')) {
            	try {
                    $form = mc4wp_get_form();
                    echo do_shortcode('[mc4wp_form id="'. $form->ID .'"]');
                } catch (Exception $e) {
                    esc_html_e('Please create a newsletter form from Mailchip plugins', 'urna');
                }
            }
        ?>
	</div>
</div>