<?php
/**
 * Templates Name: Elementor
 * Widget: Newsletter
 */
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <?php if (!empty($heading_subtitle) || !empty($heading_title)) : ?>
		<<?php echo trim($heading_title_tag); ?> class="tbay-addon-title">
			<?php if (!empty($heading_title)) : ?>
				<?php echo trim($heading_title); ?>
			<?php endif; ?>	    	
			<?php if (!empty($heading_subtitle)) : ?>
				<span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
			<?php endif; ?>
		</<?php echo trim($heading_title_tag); ?>>
	<?php endif; ?>

    <div class="tbay-addon-content"> 
		<?php if (!empty($heading_description)) { ?>
			<p class="tbay-addon-description">
				<?php echo trim($heading_description); ?>
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