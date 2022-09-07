<?php
    $image_id 		= isset($image_id) ? $image_id : get_post_thumbnail_id(get_the_ID());
    $name	  		= isset($testimonial_name) ? $testimonial_name : get_the_title();
    $job	  		= isset($job) ? $job : get_post_meta(get_the_ID(), 'tbay_testimonial_job', true);
    $description	= isset($description) ? $description : get_the_excerpt();
?>
<div class="testimonials-body">
	<div class="testimonials-profile"> 
	  	<div class="wrapper-avatar">
	     	<div class=" testimonial-avatar">
			 	<?php if (!empty($image_id)) : ?>
					<?php echo wp_get_attachment_image($image_id, 'urna_avatar_post_carousel'); ?>
				 <?php elseif (!empty($image_url)) : ?>
					<?php echo '<img src="'. esc_url($image_url) .'">'; ?>
				 <?php endif; ?>
	     	</div>
	  	</div>
	  	<div class="testimonial-meta">

	     	<span class="name-client"><?php echo trim($name); ?></span>
	     	<span class="job"><?php echo trim($job); ?></span>
	  	</div> 
	</div> 
	<div class="description">
	 	<?php echo trim($description); ?>
	</div>
</div>