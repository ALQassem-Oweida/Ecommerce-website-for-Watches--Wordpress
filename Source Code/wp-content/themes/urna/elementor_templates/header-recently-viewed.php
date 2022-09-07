<?php
/**
 * Templates Name: Elementor
 * Widget: Product Recently Viewed
 */

extract($settings);

if (isset($limit) && !((bool) $limit)) {
    return;
}


$this->add_render_attribute(
    'content',
    [
        'class' 		=> 'urna-recent-viewed-products',
        'data-column' 	=> $header_column,
    ]
);

$this->settings_layout();

$this->add_render_attribute('wrapper', 'class', ['recent-view']);
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
	<div <?php echo trim($this->get_render_attribute_string('content')); ?>>
    	<?php $this->render_content_header(); ?>    
	</div>
</div>