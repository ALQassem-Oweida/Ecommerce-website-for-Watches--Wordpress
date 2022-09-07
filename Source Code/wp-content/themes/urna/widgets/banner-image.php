<?php

$banner_hidden = urna_tbay_get_cookie('banner_remove');

if ($banner_hidden) {
    return;
}

$title = $single_image = $alt = $url = '';
extract($args);
extract($instance);
$title = apply_filters('widget_title', $instance['title']);

if ($title) {
    echo trim($before_title)  . esc_html($title) . $after_title;
}

?>
<div class="tbay-widget-banner-image">
	<?php if ($banner_image) { ?>
		<?php if (!empty($url)) : ?>

		<a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($alt); ?>" target="_blank">
			<img class="skip-lazy" src="<?php echo esc_url($banner_image); ?>" alt="<?php echo esc_attr($alt); ?>">
		</a>
		<div class="container">
			<button id="banner-remove" class="banner-remove"><i class="linear-icon-cross2"></i></button>
		</div>

		<?php else : ?>
			<div class="container">
				<button id="banner-remove" class="banner-remove"><i class="linear-icon-cross2"></i></button>
			</div>
			<img src="<?php echo esc_url($banner_image); ?>" alt="<?php echo esc_attr($alt); ?>">
		<?php endif; ?>
	<?php } ?>
</div>
