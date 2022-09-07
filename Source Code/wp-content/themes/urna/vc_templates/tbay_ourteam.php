<?php

wp_enqueue_script('slick');
wp_enqueue_script('urna-slick');

$el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$members = (array) vc_param_group_parse_atts($members);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$screen_desktop          =      isset($screen_desktop) ? $screen_desktop : $columns;
$screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
$screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;


$class_to_filter  = 'tbay-addon tbay-addon-our-team ';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class        = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

if (!empty($members)):
?>
	<div class="<?php echo esc_attr($css_class); ?>">

	   <?php if ((isset($subtitle) && $subtitle) || (isset($title) && $title)): ?>
	    	<?php $img = wp_get_attachment_image_src($image_icon, 'full'); ?>
	    	<div <?php if (!empty($img) && isset($img[0])): ?> style="background: url(<?php echo esc_url($img[0]); ?>) no-repeat center center;" <?php endif; ?>>
	            <h3 class="tbay-addon-title">
	                <?php if (isset($title) && $title): ?>
	                    <span><?php echo trim($title); ?></span>
	                <?php endif; ?>
	                <?php if (isset($subtitle) && $subtitle): ?>
	                    <span class="subtitle"><?php echo trim($subtitle); ?></span>
	                <?php endif; ?>
	            </h3>
	        </div>
        <?php endif; ?>

	    <div class="tbay-addon-content">
	    <?php

            $data_responsive  = urna_tbay_checK_data_responsive_grid($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

        ?> 
			<div class="row grid" <?php echo trim($data_responsive); ?>>
				<?php foreach ($members as $item): ?>
					<div class="item ourteam-inner">
						<div class="avatar">
							<?php if (isset($item['image']) && !empty($item['image'])): ?>
								<?php $img = wp_get_attachment_image_src($item['image'], 'full'); ?>
								<?php if (!empty($img) && isset($img[0])): ?>
									<?php echo wp_get_attachment_image($item['image'], 'full'); ?>
				                <?php endif; ?>
		                    <?php endif; ?>
		                    
		                    <ul class="social-link">
			                    <?php if (isset($item['facebook']) && !empty($item['facebook'])): ?>
			                    	<li><a href="<?php echo esc_url($item['facebook']); ?>"><i class="icon-social-facebook icons"></i></a></li>
			                    <?php endif; ?>
			                    <?php if (isset($item['twitter']) && !empty($item['twitter'])): ?>
			                    	<li><a href="<?php echo esc_url($item['twitter']); ?>"><i class="icon-social-twitter icons"></i></a></li>
			                    <?php endif; ?>
			                    <?php if (isset($item['google']) && !empty($item['google'])): ?>
			                    	<li><a href="<?php echo esc_url($item['google']); ?>"><i class="icon-social-google icons"></i></a></li>
			                    <?php endif; ?>
			                    <?php if (isset($item['linkin']) && !empty($item['linkin'])): ?>
			                    	<li><a href="<?php echo esc_url($item['linkin']); ?>"><i class="icon-social-linkedin icons"></i></a></li>
			                    <?php endif; ?>
			                    <?php if (isset($item['instagram']) && !empty($item['instagram'])): ?>
			                    	<li><a href="<?php echo esc_url($item['instagram']); ?>"><i class="icon-social-instagram icons"></i></a></li>
			                    <?php endif; ?>
	                    	</ul>
	                    </div>
	                    <div class="info">
		                    <?php if (isset($item['name']) && !empty($item['name'])): ?>
		                    	<h3 class="name-team"><?php echo trim($item['name']); ?></h3>
		                    <?php endif; ?>

		                    <?php if (isset($item['job']) && !empty($item['job'])): ?>
		                    	<p class="job"><?php echo trim($item['job']); ?></p>
		                    <?php endif; ?>
		                </div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>