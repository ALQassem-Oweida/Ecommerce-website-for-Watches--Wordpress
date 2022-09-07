<?php

$el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$data_responsive  = urna_tbay_checK_data_responsive_grid($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);


$class_to_filter  = 'tbay-addon tbay-addon-features '. $layout_type .'';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class        = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$items = (array) vc_param_group_parse_atts($items);
$count = count($items);
if (!empty($items)):
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

		    <div class="row grid" <?php echo trim($data_responsive); ?>>

				<?php foreach ($items as $item): ?>

					<div class="feature-box">
						<div class="inner">
							<?php if (isset($item['image']) && $item['image']): ?>
								<?php $img = wp_get_attachment_image_src($item['image'], 'full'); ?>
								<?php if (isset($img[0]) && $img[0]) { ?>
							    	<div class="fbox-image">
							    		<div class="image-inner">
											<?php echo wp_get_attachment_image($item['image'], 'full'); ?>
							    		</div>
							    	</div>
								<?php } ?>
							<?php endif; ?>
							<?php if (!empty($item['icon']) && !isset($item['image'])) { ?>
						        <div class="fbox-icon">
						        	<div class="icon-inner">
						            	<i class="<?php echo esc_attr($item['icon']); ?>"></i>
						            </div>
						        </div>
						    <?php } ?>
						    <div class="fbox-content">  
						        <?php if (isset($item['title']) && trim($item['title'])!='') { ?>
						        	<h3 class="ourservice-heading"><?php echo esc_html($item['title']); ?></h3>   
						        <?php } ?>
						                             
						        <?php if (isset($item['description']) && trim($item['description'])!='') { ?>
						            <p class="description"><?php echo trim($item['description']);?></p>  
						        <?php } ?>

						        <?php if (isset($item['link']) && trim($item['link'])!='') { ?>
						            <a class="btn btn-link btn-xs" href="<?php echo esc_url($item['link']); ?>"><?php esc_html_e('Learn More ', 'urna'); ?><i class="fa fa-arrow-right"></i></a>  
						        <?php } ?>
						    </div>
						</div>      
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif; ?>