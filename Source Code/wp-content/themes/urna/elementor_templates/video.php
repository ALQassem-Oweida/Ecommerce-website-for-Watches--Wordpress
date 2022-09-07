<?php
/**
 * Templates Name: Elementor
 * Widget: Video
 */
$heading_title = $heading_title_tag = $heading_subtitle = '';

extract($settings);

$this->settings_layout();

?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
	<?php $this->the_video_content(); ?>
</div>