<?php

$title = $subtitle = $thumbnail_image = $el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
$video_url = '';
extract($atts);


$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-video';
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$video = urna_tbay_VideoUrlType($video_url);

if ($video['video_type'] == 'youtube') {
    $url  = 'https://www.youtube.com/embed/'.$video['video_id'].'?autoplay=1';
} elseif (($video['video_type'] == 'vimeo')) {
    $url = 'https://player.vimeo.com/video/'.$video['video_id'].'?autoplay=1';
}

$icon = '<i class="zmdi zmdi-play"></i>';

$_id = urna_tbay_random_key();
?>


<div class="<?php echo esc_attr($css_class); ?>">

	<?php if (!empty($url)) : ?>

		<div class="tbay-addon-content">

			<?php $img = wp_get_attachment_image_src($thumbnail_image, 'full'); ?>
			<?php if (!empty($img) && isset($img[0])): ?>
					<div class="video-image">
						<?php echo wp_get_attachment_image($thumbnail_image, 'full'); ?>
	            	</div>
	        <?php endif; ?>

	      <div class="modal fade tbay-video-modal" data-id="<?php echo esc_attr($_id); ?>" id="video-modal-<?php echo esc_attr($_id); ?>">
		        <div class="modal-dialog">
		          <div class="modal-content tbay-modalContent">

		            <div class="modal-body">
		              
		              <div class="close-button">
		              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		              </div>
		              <div class="embed-responsive embed-responsive-16by9">
		                    <iframe class="embed-responsive-item"></iframe>
		              </div>
		            </div>

		          </div><!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<div class="main-content">
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
					<button type="button" class="tbay-modalButton" data-toggle="modal" data-tbaySrc="<?php echo esc_attr($url); ?>" data-tbayWidth="640" data-tbayHeight="480" data-target="#video-modal-<?php echo esc_attr($_id); ?>"  data-tbayVideoFullscreen="true"><?php echo trim($icon); ?></button>
				</div>
	  </div>

    <?php endif; ?>


</div>

