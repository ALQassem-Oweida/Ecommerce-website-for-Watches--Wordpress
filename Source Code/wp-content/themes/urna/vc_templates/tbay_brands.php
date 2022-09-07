<?php

$columns = $screen_desktop = $screen_desktopsmall = $screen_tablet = $screen_landscape_mobile = $screen_mobile = $rows = $nav_type = $pagi_type = $loop_type = $auto_type = $autospeed_type = $disable_mobile = $el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

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

  
$bcol = 12/$columns;
$args = array(
    'post_type' => 'tbay_brand',
    'posts_per_page' => $number
);

$data_responsive  = urna_tbay_checK_data_responsive_grid($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$rows_count = isset($rows) ? $rows : 1;
$class_item = ($rows_count != 1) ? 'row-no-one' : '';

$loop = new WP_Query($args);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-brands '. $layout_type .'';
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

    <div class="tbay-addon-content">
    	<?php if ($loop->have_posts()): ?>
    		<?php if ($layout_type == 'carousel'): ?>

    		<?php
                wp_enqueue_script('slick');
                wp_enqueue_script('urna-slick');

                $data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
                $responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

            ?>	
			<div class="owl-carousel scroll-init brands rows-<?php echo esc_attr($rows_count); ?> <?php echo esc_attr($class_item); ?>" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
			    <?php $count = 0; while ($loop->have_posts()): $loop->the_post(); ?>
				
						<div class="item">
			                <?php
                                $link = get_post_meta(get_the_ID(), 'tbay_brand_link', true);
                                $link = $link ? $link : '#';
                                $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                            ?>
							<a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($onclick); ?>"> 
                                <?php echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', false); ?>
							</a>
						</div>
					
			    <?php endwhile; ?>
			</div> 
	    	<?php else: ?>
	    		<div class="row <?php echo esc_attr($layout_type); ?>" <?php echo trim($data_responsive); ?>>
		    		<?php while ($loop->have_posts()): $loop->the_post(); ?>
		    			<div class="item">
			                <?php
                                $link = get_post_meta(get_the_ID(), 'tbay_brand_link', true);
                                $link = $link ? $link : '#';
                                $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
                            ?>
							<a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($onclick); ?>"> 
                                <?php echo wp_get_attachment_image($post_thumbnail_id, 'thumbnail', false); ?>
							</a>
				        </div>
		    		<?php endwhile; ?>
	    		</div>
	    	<?php endif; ?>
    	<?php endif; ?>
    	<?php wp_reset_postdata(); ?>
    </div>

    <?php if (isset($check_custom_link) && $check_custom_link == 'yes' && '' !== $link) : ?>
       <a class="show-all" href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title); ?>" target="<?php echo esc_attr($a_target); ?>"<?php echo trim($a_rel); ?>><?php echo trim($a_title); ?></a>
    <?php endif; ?>

</div>