<?php

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();
$_images =array();
if (has_post_thumbnail()) {
    $_images[] = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'woocommerce_single'));
} else {
    $_images[] = '<img src="'.wc_placeholder_img_src().'" alt="Placeholder" />';
}
foreach ($attachment_ids as $attachment_id) {
    $_images[]       = wp_get_attachment_image($attachment_id, 'woocommerce_single');
}

?>
<?php do_action('urna_before_image_quickview'); ?>

<div id="quickview-carousel" class="carousel slide" data-ride="carousel">
	<?php if (count($_images)>1) { ?>
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php foreach ($_images as $key => $image) {
    echo '<li data-target="#quickview-carousel" data-slide-to="'.esc_attr($key).'" '.(($key==0)?'class="active"':'').'></li>';
} ?>
	</ol>
	<?php } ?>
	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<?php foreach ($_images as $key => $image) { ?>
		<div class="item<?php echo(($key==0)?' active':'') ?>">
			<?php echo trim($image); ?>
		</div>
		<?php } ?>
	</div>

	<!-- Controls -->
	<div class="carousel-controls-v3">
		<a class="left carousel-control carousel-md" href="#quickview-carousel" data-slide="prev">
			<i class="linear-icon-chevron-left"></i>
		</a>
		<a class="right carousel-control carousel-md" href="#quickview-carousel" data-slide="next">
			<i class="linear-icon-chevron-right"></i>
		</a>
	</div>
</div>
<?php do_action('urna_woo_quickview_js'); ?>

