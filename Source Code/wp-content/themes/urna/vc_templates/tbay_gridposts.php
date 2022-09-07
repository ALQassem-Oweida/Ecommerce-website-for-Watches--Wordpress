<?php

$description_number = $el_class = $orderby = $order = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$loop_type = $auto_type = $autospeed_type = '';
extract($atts);

$args = array(
    'posts_per_page' =>     $number,
    'post_status'    =>    'publish',
    'orderby'        =>     $orderby,
    'order'          =>     $order,
    'taxonomy'       =>    'category',
);

if ($category && ($category != esc_html__('--- Choose a Category ---', 'urna'))) {
    $args['cat'] = $category;
}

$loop = new WP_Query($args);

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$show_category_post          = isset($show_category_post) ? $show_category_post : false;
$show_description_post       = isset($show_description_post) ? $show_description_post : false;

$data_responsive  = urna_tbay_checK_data_responsive_grid($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$rows_count = isset($rows) ? $rows : 1;
set_query_var('thumbsize', $thumbsize);
$class_item = ($rows_count != 1) ? 'row-no-one' : '';

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter  = 'tbay-addon tbay-addon-blog '. $layout_type .' ';
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
	<div class="tbay-addon-content"> 

		<?php if (isset($layout_type) && $layout_type == 'carousel') : ?>
			<?php
                wp_enqueue_script('slick');
                wp_enqueue_script('urna-slick');
                
                $data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
                $responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
            ?>

			<div class="owl-carousel scroll-init posts rows-<?php echo esc_attr($rows_count); ?> <?php echo esc_attr($class_item); ?>" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
				<?php $count = 0; while ($loop->have_posts()): $loop->the_post(); global $product; ?>
					<div class="item">

						<?php
                            set_query_var('show_category_post', $show_category_post);
                            set_query_var('show_description_post', $show_description_post);
                            set_query_var('description_number', $description_number);

                            get_template_part('vc_templates/post/carousel/_single_'.$layout_type);
                        ?>
					</div>
				<?php endwhile; ?>
			</div>
			

		<?php elseif (isset($layout_type) && $layout_type == 'vertical') : ?>

			<div class="layout-blog" >
				<div class="row <?php echo esc_attr($layout_type); ?>" <?php echo trim($data_responsive); ?>>

					<?php $count = 0; while ($loop->have_posts()) : $loop->the_post(); ?>

						<div class="item">
							<?php
                                set_query_var('show_category_post', $show_category_post);
                                set_query_var('show_description_post', $show_description_post);
                                set_query_var('description_number', $description_number);

                                get_template_part('vc_templates/post/_vertical');
                            ?>
						</div>

						<?php $count++; ?>
					<?php endwhile; ?>
				</div>
			</div>

		<?php else: ?>

			<div class="layout-blog" >
				<div class="row <?php echo esc_attr($layout_type); ?>" <?php echo trim($data_responsive); ?>>

					<?php $count = 0; while ($loop->have_posts()) : $loop->the_post(); ?>

						<div class="item">
							<?php
                                set_query_var('show_category_post', $show_category_post);
                                set_query_var('show_description_post', $show_description_post);
                                set_query_var('description_number', $description_number);

                                get_template_part('vc_templates/post/_single');
                            ?>
						</div>

						<?php $count++; ?>
					<?php endwhile; ?>
				</div>
			</div>

		<?php endif; ?>
		
	</div>
</div>
<?php wp_reset_postdata(); ?>