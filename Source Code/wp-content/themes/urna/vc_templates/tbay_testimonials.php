 <?php

wp_enqueue_script('slick');
wp_enqueue_script('urna-slick');

$style = $columns = $screen_desktop = $screen_desktopsmall = $screen_tablet = $screen_landscape_mobile = $screen_mobile = $rows = $nav_type = $pagi_type = $loop_type = $auto_type = $autospeed_type = $disable_mobile = $el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$args = array(
    'post_type' => 'tbay_testimonial',
    'posts_per_page' => $number,
    'post_status' => 'publish',
);


$skin = urna_tbay_get_theme();
switch ($skin) {
    case 'underwear':
        $layout = 'v2';
        break;
    case 'wedding':
        $layout = 'v3';
        break;
    default:
        $layout = 'v1';
        break;
}

$loop = new WP_Query($args);

$rows_count = isset($rows) ? $rows : 1;

$screen_desktop          =      isset($screen_desktop) ? $screen_desktop : $columns;
$screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
$screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;


$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon-testimonials tbay-addon';
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
	<?php if ($loop->have_posts()): ?>
        <div class="tbay-addon-content">

            <?php
                $data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
                $responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

            ?>
            <div class="owl-carousel scroll-init slick-testimonials rows-<?php echo esc_attr($rows_count); ?>" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
                <?php while ($loop->have_posts()): $loop->the_post(); ?>

                    <div class="item">
                        <?php get_template_part('vc_templates/testimonial/testimonial-' . $layout); ?>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>
	<?php endif; ?>
</div>
<?php wp_reset_postdata(); ?>